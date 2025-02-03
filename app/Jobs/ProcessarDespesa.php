<?php

namespace App\Jobs;

use App\Mail\DespesaRegistrada;
use App\Models\Despesas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ProcessarDespesa implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $despesa;

    public function __construct($despesa)
    {
        $this->despesa = $despesa;
    }

    public function handle()
    {
        try {
            Log::info('Processando despesa:', $this->despesa);

            // Criar a despesa no banco de dados
          $despesa = Despesas::create($this->despesa);
            dd($despesa);
            Log::info('Despesa processada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao processar despesa: ' . $e->getMessage());
        }
    }

    // Método público para acessar a propriedade $despesa nos testes
    public function getDespesa()
    {
        return $this->despesa;
    }       
}
