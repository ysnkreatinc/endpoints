<?php

namespace Kreatinc\Bot\Middlewares;

class VerifyFacebookSignatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $expected_signature = 'sha1='. hash_hmac('sha1', $request->getContent(), config('bot.facebook.messenger.verify_token'));
        $signature = $request->header('x-hub-signature');

        if (! hash_equals($signature, $expected_signature)) {
            return response(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
