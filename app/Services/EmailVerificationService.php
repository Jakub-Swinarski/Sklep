<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmailVerificationService
{
    public function createAttempt($userId): string
    {
        $uuid = Str::uuid()->toString();

        DB::table('email_verification_attempts')
            ->insert([
                'uuid' => $uuid,
                'user_id' => $userId
            ]);

        return $uuid;
    }

    public function checkAttempt($uuid): false|User {
        $result = DB::table('email_verification_attempts')
            ->where('uuid', $uuid)
            ->exists();

        if ($result === false) {
            return false;
        }

        return User::leftJoin('email_verification_attempts', 'email_verification_attempts.user_id', '=', 'users.id')
            ->where('uuid', $uuid)
            ->firstOrFail();
    }

    public function deleteAttempt($uuid)
    {
        return DB::table('email_verification_attempts')
            ->where('uuid', $uuid)
            ->delete();
    }
}
