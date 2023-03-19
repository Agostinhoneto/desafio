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
            'endereco_id' => '1',
            'user_id'     => '10',
        ]);
    }
}
