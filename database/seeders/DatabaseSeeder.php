<?php

namespace Database\Seeders;

use App\Models\EnderecoUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(CategoriasSeeder::class);
        $this->call(Admin::class);
        $this->call(DespesasTableSeeder::class);
        $this->call(ReceitasTableSeeder::class);
        $this->call(LancamentoSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RolesUsersTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(CategoriasMetas::class);
        $this->call(EnderecoTableSeeder::class);        
        $this->call(EnderecoUser::class);

    }
}
