<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function index()
    {
        return view('file_upload.index'); // Assuming you have a view for file upload
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');

            return redirect()->back()->with('success', 'File uploaded successfully');
        }
        return redirect()->back()->with('success', 'File uploaded successfully');
    }
}
