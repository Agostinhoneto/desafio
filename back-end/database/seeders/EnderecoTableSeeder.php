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

        Endereco::create([
            'logradouro' => 'Praça Monsenhor Berenque',
            'cep'     => '4880000',
        ]);
    }
}
