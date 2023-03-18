<?php

namespace Database\Seeders;

use App\Models\Endereco;
use Illuminate\Database\Seeder;

class EnderecoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Endereco::create([
            'logradouro' => 'av manoel novais',
            'cep'     => '4880000',
        ]);
    }
}
