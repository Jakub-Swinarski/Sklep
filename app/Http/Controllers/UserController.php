<?php

namespace App\Http\Controllers;


use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangeUsernameRequest;
use App\Http\Requests\DeleteUserNoPasswordRequest;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\NewEmailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    public function emailPasswordReset(EmailRequest $request)
    {
        $request->validated();

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? ['status' => ($status)]
            : ['email' => ($status)];
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $request->validated();
        $status = Password::reset(
            $request->only('email', 'password', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? ['status' => ($status)]
            : ['email' => ($status)];
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->validated();
        $user = User::where('id',$data['user_id'])->first();

        if (Hash::check($data['old_password'], $user->password)) {
            User::where('id',$data['user_id'])
                ->update(['password' => Hash::make($data['new_password'])]);
        } else
            throw ValidationException::withMessages(['data' => ["Hasło jest nieprawidłowe"]]);
    }

    public function changeEmail(NewEmailRequest $request)
    {
        $data = $request->validated();
        if (Hash::check($data['password'], auth()->user()->getAuthPassword())) {
            User::where('id',$data['user_id'])
                ->update([
                    'email' => $data['email']
                ]);
            return $data;
        }
        abort(422, 'Hasło niepoprawne');
    }

    public function changeUsername(ChangeUsernameRequest $request)
    {
        $data = $request->validated();
        User::where('id',$data['user_id'])
            ->update([
                'username' => $data['username']
            ]);
        return $data;
    }

    public function getAllUsers()
    {
        return User::all();
    }
    public function deleteUser(DeleteUserNoPasswordRequest $request){
        $data = $request->validated();
        User::where('id',$data['user_id'])
            ->delete();
    }
}
