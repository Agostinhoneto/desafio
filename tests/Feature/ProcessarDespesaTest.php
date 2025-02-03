<?php

namespace Tests\Feature;

use App\Jobs\ProcessarDespesa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;

class ProcessarDespesaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function despesa_job_is_dispatched()
    {
        // Simular a fila
        Queue::fake();

        // Dados da despesa de exemplo
        $despesaData = [
            'user_id' => 1,
            'descricao' => 'Compra de materiais de escritório',
            'valor' => 100.0,
            'data_pagamento' => now(),
            'categoria_id' => 1,
            'status' => 1
        ];

        // Despachar o job
        ProcessarDespesa::dispatch($despesaData);
        // Verificar se o job foi despachado
        Queue::assertPushed(ProcessarDespesa::class, function ($job) use ($despesaData) {
            return $job->getDespesa()['descricao'] === $despesaData['descricao'];
        });
    }

    /** @test */
    public function despesa_is_created_in_database()
    {
        // Dados da despesa de exemplo
        $despesaData = [
            'user_id' => 1,
            'descricao' => 'Compra de materiais de escritório',
            'valor' => 100.0,
            'data_pagamento' => now(),
            'categoria_id' => 1,
            'status' => 1
        ];

        // Executar o job diretamente
        (new ProcessarDespesa($despesaData))->handle();

        // Verificar se a despesa foi criada no banco de dados
        $this->assertDatabaseHas('despesas', [
            'descricao' => 'Compra de materiais de escritório',
            'valor' => 100.0
        ]);
    }
}
