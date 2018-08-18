<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * Send an email
     *
     * @param Request $request
     */
    public function sendEmail(Request $request) {
        Mail::send('emails.mail-to-owner', $request->toArray(), function($message) use ($request) {
            $message->to(config('mail.to.address'), config('mail.to.name'))
                ->subject('Lana Sells Delta Website Contact Form: ' . $request->input('firstName') . ' ' . $request->input('lastName'));
            $message->from(config('mail.from.address'), config('mail.from.name'));
        });
    }
}
