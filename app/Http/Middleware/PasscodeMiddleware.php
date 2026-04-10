<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PasscodeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $passcode = SiteSetting::get('passcode');

        // If no passcode is set, allow through
        if (empty($passcode)) {
            return $next($request);
        }

        // Step 1: passcode not yet entered → go to passcode gate
        if ($request->session()->get('passcode_unlocked') !== true) {
            return redirect()->route('passcode.show');
        }

        // Step 2: passcode entered but email not yet submitted → go to email page
        if ($request->session()->get('visitor_email_submitted') !== true) {
            return redirect()->route('visitor.email.show');
        }

        return $next($request);
    }
}
