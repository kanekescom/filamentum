<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Auth\Pages\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Register extends BaseRegister
{
    use WithRateLimiting;

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRegistration(array $data): Model
    {
        $user = parent::handleRegistration($data);

        // Assign default 'User' role
        $userRole = Role::where('name', 'User')->first();
        if ($userRole) {
            $user->assignRole($userRole);
        }

        return $user;
    }
}
