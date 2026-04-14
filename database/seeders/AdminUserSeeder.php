<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Crée ou met à jour le compte administrateur (accès /admin).
     * Variables : ADMIN_EMAIL, ADMIN_PASSWORD, ADMIN_SEED_NAME (voir config/admin.php).
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => config('admin.email')],
            [
                'name' => config('admin.seed_name'),
                'password' => config('admin.password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
