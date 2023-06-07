<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticateLoginAttempt
{
    public function __invoke(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            if (!$user->active) {
                session()->flash('error', __('Your account is deactivated.'));
                return null;
            }
            return $user;
        }
    }
}
