<?php

namespace Database\Seeders;

use App\Models\Endereco;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = Role::create(['name' => 'User']);
        $adminRole = Role::create(['name' => 'Admin']);
        User::create([
            'name' => 'Admin',
            'email' => 'agostinho@admin.com',
            'cpf' => '123456879',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Agostinho Neto',
            'email' => 'agostinho@user.com',
            'cpf' => '123456879',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role_id' => $userRole->id,
        ]);
    }
}
