<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // If new_password is provided, hash it and replace the password field
        if (! empty($data['new_password'])) {
            $data['password'] = Hash::make($data['new_password']);
        }

        // Remove new_password from data as it's not a real field
        unset($data['new_password']);

        return $data;
    }

    protected function afterSave(): void
    {
        // Sync roles with the user
        $roles = $this->data['roles'] ?? [];
        $roleModels = Role::whereIn('id', $roles)->get();
        $this->record->syncRoles($roleModels);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load the user's existing roles
        /** @var User $user */
        $user = $this->getRecord();
        $data['roles'] = $user->roles->pluck('id')->toArray();

        return $data;
    }
}
