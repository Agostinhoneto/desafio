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
            'logradouro' => 'Rua Teste 1',
            'cep'     => '4000000',
        ]);

        Endereco::create([
            'logradouro' => 'Rua teste 2',
            'cep'     => '48888888',
        ]);
    }
}
