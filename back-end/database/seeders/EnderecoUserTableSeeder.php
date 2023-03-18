<?php

namespace Database\Seeders;

use App\Models\EnderecoUser;
use Illuminate\Database\Seeder;

class EnderecoUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EnderecoUser::create([
            'logradouro' => 'av manoel novais',
            'cep'     => '4880000',
        ]);
    }
}
