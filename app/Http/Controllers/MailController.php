<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MailController extends Controller
{
    public function index(Request $request)
    {
        return view('mail.index');
    }

    /**
     * Send email using queue
     */
    public function sendMail(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'to' => 'required|email',
                'cc' => 'nullable|array',
                'cc.*' => 'email',
                'bcc' => 'nullable|array',
                'bcc.*' => 'email',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
                'data' => 'nullable|array',
                'attachments' => 'nullable|array',
                'attachments.*' => 'file|max:10240' // 10MB max per file
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Extract validated data
            $to = $request->input('to');
            $cc = $request->input('cc', []);
            $bcc = $request->input('bcc', []);
            $subject = $request->input('subject');
            $message = $request->input('message');
            $data = $request->input('data', []);
            $attachments = $request->file('attachments', []);

            // Handle file uploads
            $uploadedFiles = [];
            if (!empty($attachments)) {
                foreach ($attachments as $attachment) {
                    if ($attachment->isValid()) {
                        $path = $attachment->store('email-attachments', 'public');
                        $uploadedFiles[] = [
                            'path' => $path,
                            'original_name' => $attachment->getClientOriginalName(),
                            'mime_type' => $attachment->getMimeType()
                        ];
                    }
                }
            }

            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $data[$key] = json_encode($value);
                }
            }

            // Add file info to data
            // Mail::to($to)
            //     ->cc($cc)
            //     ->bcc($bcc)
            //     ->send(new TestMail($message, $subject, $data, $uploadedFiles));

            SendMail::dispatch($to, $cc, $bcc, $subject, $message, $data, $uploadedFiles);

            // SendMail::dispatch(
            //     $to, $cc, $bcc, $subject, $message, $data, $uploadedFiles
            //     )->onQueue('emails');

            Log::info('Email job dispatched successfully', [
                'to' => $to,
                'cc' => $cc,
                'bcc' => $bcc,
                'subject' => $subject,
                'attachments_count' => count($uploadedFiles),
                'user_id' => auth()->id() ?? 'guest'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email has been queued for delivery',
                'data' => [
                    'to' => $to,
                    'cc' => $cc,
                    'bcc' => $bcc,
                    'subject' => $subject,
                    'attachments_count' => count($uploadedFiles),
                    'queued_at' => now()->toISOString()
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to dispatch email job', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id() ?? 'guest'
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to queue email. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Send bulk emails using queue
     */
    public function sendBulkMail(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'emails' => 'required|array|min:1',
                'emails.*.to' => 'required|email',
                'emails.*.cc' => 'nullable|array',
                'emails.*.cc.*' => 'email',
                'emails.*.bcc' => 'nullable|array',
                'emails.*.bcc.*' => 'email',
                'emails.*.subject' => 'required|string|max:255',
                'emails.*.message' => 'required|string',
                'emails.*.data' => 'nullable|array',
                'emails.*.attachments' => 'nullable|array',
                'emails.*.attachments.*' => 'file|max:10240' // 10MB max per file
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $emails = $request->input('emails');

            $dispatchedCount = 0;

            $uploadedFiles = [];
            foreach ($emails as $index => $emailData) {
                // Handle file uploads for each email
                $attachments = $request->file("emails.$index.attachments", []);
                if (!empty($attachments)) {
                    foreach ($attachments as $attachment) {
                        if ($attachment && $attachment->isValid()) {
                            $path = $attachment->store('email-attachments', 'public');
                            $uploadedFiles[] = [
                                'path' => $path,
                                'original_name' => $attachment->getClientOriginalName(),
                                'mime_type' => $attachment->getMimeType()
                            ];
                        }
                    }
                }

                // Add file info to data
                $emailData['data'] = $emailData['data'] ?? [];
                $cc = $emailData['cc'] ?? [];
                $bcc = $emailData['bcc'] ?? [];

                SendMail::dispatch($emailData['to'], $cc, $bcc, $emailData['subject'], $emailData['message'], $emailData['data'], $uploadedFiles);

                // SendMail::dispatch(
                //     $emailData['to'], $cc, $bcc, $emailData['subject'], $emailData['message'], $emailData['data'], $uploadedFiles
                // )->onQueue('emails');

                // Mail::to($emailData['to'])
                //     ->cc($cc)
                //     ->bcc($bcc)
                //     ->send(new TestMail($emailData['message'], $emailData['subject'], $emailData['data'], $uploadedFiles));

                $dispatchedCount++;
            }

            Log::info('Bulk email jobs dispatched successfully', [
                'count' => $dispatchedCount,
                'user_id' => auth()->id() ?? 'guest'
            ]);

            return response()->json([
                'success' => true,
                'message' => "Successfully queued {$dispatchedCount} emails for delivery",
                'data' => [
                    'dispatched_count' => $dispatchedCount,
                    'queued_at' => now()->toISOString()
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to dispatch bulk email jobs', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id() ?? 'guest'
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to queue bulk emails. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get queue status
     */
    public function getQueueStatus()
    {
        try {
            // You can implement queue monitoring here
            // For now, return basic info
            return response()->json([
                'success' => true,
                'data' => [
                    'queue_connection' => config('queue.default'),
                    'current_time' => now()->toISOString(),
                    'status' => 'Queue system is running'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get queue status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
