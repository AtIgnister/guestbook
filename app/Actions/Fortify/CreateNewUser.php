<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Models\Invite;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'password' => $this->passwordRules(),
        ])->validate();

        $invite = Invite::where('id',session('token_invitation'))->first();
        if(!$invite){
            abort(403);
        }

        $user = User::create([
            'name' => $input['name'],
            'email' => $invite->email,
            'password' => $input['password'],
            'email_verified_at' => now(),
        ]);

        if(Role::exists($invite->role)) {
            $user->assignRole($invite->role);
        }

        $invite->delete();

        return $user;
    }
}
