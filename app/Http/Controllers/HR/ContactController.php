<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ], [
            'name.required'    => 'Nama wajib diisi.',
            'email.required'   => 'Email wajib diisi.',
            'subject.required' => 'Subjek wajib diisi.',
            'message.required' => 'Pesan wajib diisi.',
        ]);

        // Kirim email ke HR
        Mail::raw(
            "Pesan dari: {$request->name} ({$request->email})\n\nSubjek: {$request->subject}\n\n{$request->message}",
            function ($mail) use ($request) {
                $mail->to('hr@ntp.co.id')
                     ->subject("[NTP Careers] {$request->subject}")
                     ->replyTo($request->email, $request->name);
            }
        );

        return redirect()->route('kontak')->with('success', 'Pesan berhasil dikirim! Tim HR kami akan membalas dalam 1–2 hari kerja.');
    }
}