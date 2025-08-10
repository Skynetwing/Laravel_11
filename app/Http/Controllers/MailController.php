<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index(Request $request)
    {
        $to = "testmail@gmail.com";
        $msg = "Dummy message";
        $subject = "Dummy subject";

        Mail::to($to)->send(new TestMail($msg, $subject));
    }
}
