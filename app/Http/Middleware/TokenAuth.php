<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;

class TokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $header = $request->header('Authorization');
        if ($header === null) abort(401, 'brak tokenu'); // 401

        $splittedHeader = explode(" ", $header);
        if (count($splittedHeader) !== 2) abort(401); // 401
        if ($splittedHeader[0] !== "Bearer") abort(401); // 401

        $decryptedPayload = null;

        try {
            $decryptedPayload = Crypt::decryptString($splittedHeader[1]);
        } catch (DecryptException $e) {
            abort(401);
        }

        $userId = intval(str_replace("authorization_token:", "", $decryptedPayload));

        $user = User::find($userId);
        if ($user === null) abort(401);

        auth()->setUser($user);
        return $next($request);
    }
}
