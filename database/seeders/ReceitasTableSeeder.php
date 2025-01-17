<?php

namespace Database\Seeders;

use App\Models\Receitas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReceitasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Receitas::create([
            'descricao' => 'Salário',
            'valor' => 1500.00,
            'data_recebimento' => '2024-01-01',
            'status' => true,
            'categoria_id' => 1,

        ]);

        Receitas::create([
            'descricao' => 'Aluguel',
            'valor' => 400.00,
            'data_recebimento' => '2024-01-01',
            'status' => true,
            'categoria_id' => 2,
        ]);
    }
}
