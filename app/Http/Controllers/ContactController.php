<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show(string $locale, Request $request)
    {
        $request->session()->put('contact_form_started_at', now()->timestamp);

        return view('pages.contact');
    }

    public function submit(string $locale, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:3000'],
            'website' => ['nullable', 'string', 'max:255'],
        ]);

        $startedAt = (int) $request->session()->pull('contact_form_started_at', 0);
        $elapsed = $startedAt > 0 ? now()->timestamp - $startedAt : 0;

        if (($validated['website'] ?? '') !== '' || $startedAt === 0 || $elapsed < 3) {
            return back()
                ->withInput()
                ->withErrors(['spam' => __('pages.contact.spam_error')]);
        }

        Mail::send('mail.contact-message', [
            'contactMessage' => [
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'submitted_at' => now(),
                'ip' => $request->ip(),
            ],
        ], function ($mail) use ($validated): void {
            $recipient = (string) config('site.public_contact_email', '');

            $mail->to($recipient)
                ->replyTo($validated['email'], $validated['full_name'])
                ->subject('[Contact] '.$validated['subject']);
        });

        return redirect()
            ->route('contact')
            ->with('contact_ok', __('pages.contact.success'));
    }
}
