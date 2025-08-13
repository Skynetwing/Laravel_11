<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index(Request $request)
    {

        $msg = "Dummy message";
        $subject = "Dummy subject";
        $to = "cv9870305@gmail.com";
        Mail::to($to)->queue(new TestMail($msg, $subject));
        // dispatch(new TestMail($msg, $subject));


        // Mail::to($to)->send(new TestMail($msg, $subject));
    }
}
