<?php

namespace App\Jobs;

use App\Mail\TestMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3; // Number of retry attempts
    public $timeout = 60; // Job timeout in seconds
    public $backoff = [10, 30, 60]; // Delay between retries in seconds

    protected $to;
    protected $subject;
    protected $message;
    protected $data;
    protected $cc;
    protected $bcc;
    protected $uploadedFiles;

    /**
     * Create a new job instance.
     */
    public function __construct($to, $cc = [], $bcc = [], $subject, $message, $data = [], $uploadedFiles = [])
    {
        // $to, $cc, $bcc, $subject, $message, $data, $uploadedFiles
        $this->to = $to;
        $this->cc = $cc;
        $this->bcc = $bcc;
        $this->subject = $subject;
        $this->message = $message;
        $this->data = $data;
        $this->uploadedFiles = $uploadedFiles;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('Starting to send email', [
                'to' => $this->to,
                'cc' => $this->cc,
                'bcc' => $this->bcc,
                'subject' => $this->subject,
                'attachments_count' => isset($this->uploadedFiles) ? count($this->uploadedFiles) : 0,
                'job_id' => $this->job->getJobId()
            ]);

            // Send the email with CC and BCC
            $mail = Mail::to($this->to);

            if (!empty($this->cc)) {
                $mail->cc($this->cc);
            }

            if (!empty($this->bcc)) {
                $mail->bcc($this->bcc);
            }

            $mail->send(new TestMail($this->message, $this->subject, $this->data, $this->uploadedFiles));

            Log::info('Email sent successfully', [
                'to' => $this->to,
                'cc' => $this->cc,
                'bcc' => $this->bcc,
                'subject' => $this->subject,
                'job_id' => $this->job->getJobId()
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send email', [
                'to' => $this->to,
                'cc' => $this->cc,
                'bcc' => $this->bcc,
                'subject' => $this->subject,
                'error' => $e->getMessage(),
                'job_id' => $this->job->getJobId()
            ]);

            // Re-throw the exception to trigger retry logic
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Email job failed permanently', [
            'to' => $this->to,
            'cc' => $this->cc,
            'bcc' => $this->bcc,
            'subject' => $this->subject,
            'error' => $exception->getMessage(),
            'job_id' => $this->job->getJobId()
        ]);
    }
}
