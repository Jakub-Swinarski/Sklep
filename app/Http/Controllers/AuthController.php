<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Notifications\VerifyEmailAlternative;
use App\Services\EmailVerificationService;
use Illuminate\Auth\Events\PasswordReset;
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
    private EmailVerificationService $emailVerificationService;

    public function __construct(EmailVerificationService $evs)
    {
        $this->emailVerificationService = $evs;
    }

    public function acceptEmail(string $uuid)
    {
        DB::transaction(function() use ($uuid) {
            $user = $this->emailVerificationService->checkAttempt($uuid);

            if ($user === false) {
                abort(422, "Invalid link");
            }

            $user->email_verified_at = now();
            $user->save();

            $this->emailVerificationService->deleteAttempt($uuid);
        });

        return redirect()->to(env("FRONTEND_URL") . "/register/accepted");
    }

    public function getUser()
    {
        return auth()->user();
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
        DB::transaction(function ()use ($request){
            $data = $request->validated();
            $user = new User();
            $user->username = $data['username'];
            $data['password'] = Hash::make($data['password']);
            $user->password = $data['password'];
            $user->email = $data['email'];
            $user->is_admin = $data['is_admin'];
            $user->token = Str::random(10);

            $user->save();
            $user->notify(new VerifyEmailAlternative());
            return [
                'token' => Crypt::encryptString("authorization_token:" . auth()->id()),
                'user' => $user
            ];
        });

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
}
