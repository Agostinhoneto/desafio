<?php

namespace Database\Seeders;

use App\Models\Lancamento;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LancamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            Lancamento::create([
                'usuario_id' => 1,
                'categoria_id' => 1,
                'descricao' => 'Salário Mensal',
                'valor' => 5000.00,
                'data' => Carbon::now(),
                'tipo' => 'receita',
                'recorrente' => true,
                'proximo_lancamento' => Carbon::now()->addMonth(),
            ]);
    
            Lancamento::create([
                'usuario_id' => 1,
                'categoria_id' => 2,
                'descricao' => 'Conta de Luz',
                'valor' => 150.75,
                'data' => Carbon::now(),
                'tipo' => 'despesa',
                'recorrente' => true,
                'proximo_lancamento' => Carbon::now()->addMonth(),
            ]);
        }
    }

