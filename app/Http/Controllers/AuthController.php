<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * @property $userRepository
 */
class AuthController extends Controller
{
    public function getUser()
    {
        return auth()->id();
    }

    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where("username", '=', $data['username'])->first();

        if ($user === null) {
            throw ValidationException::withMessages(['data' => ["Dane są niepoprawne"]]);
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages(['data' => ["Dane są niepoprawne"]]);
        }

        auth()->setUser($user);

        return [
            'token' => Crypt::encryptString("authorization_token:" . auth()->id()),
            'user' => auth()->user()
        ];

    }

    public function logout()
    {
        auth()->logout();
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = new User();
        $user->username = $data['username'];
        $data['password'] = Hash::make($data['password']);
        $user->password = $data['password'];
        $user->email = $data['email'];
        $user->is_admin = $data['is_admin'];
        $user->token = Str::random(10);

        $user->save();
        $user->sendEmailVerificationNotification();
        event(new Registered($user));
        return $user;
    }

    public function delete(DeleteUserRequest $request)
    {
        $data = $request->validated();

        $user = auth()->user();

        $doesPasswordMatch = Hash::check($data['password'], $user->getAuthPassword());

        if (!$doesPasswordMatch) {
            throw ValidationException::withMessages(['data' => ['password' => ['Złe hasło.']]]);
        }

        DB::table('users')
            ->where('id', '=', auth()->id())
            ->delete();
    }

    public function emailPasswordReset(EmailRequest $request)
    {

        $request->validated();

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? ['status' => __($status)]
            : ['email' => ($status)];
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $request->validated();
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? ['status' => __($status)]
            : ['email' => __($status)];
    }
}
