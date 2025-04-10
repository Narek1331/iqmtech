<?php

namespace App\Traits\User;

use Illuminate\Support\Facades\Auth;

trait StoreHelper
{
    /**
     * Mutate the form data before creating the record.
     *
     * This method ensures that the correct user ID is set in the data,
     * prioritizing the 'main_user_id' if available, otherwise falling back to the default user ID.
     *
     * @param array $data
     * @return array
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();
        $data['user_id'] = $user->main_user_id ?? $user->id;

        return $data;
    }
}
