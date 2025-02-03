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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($despesa)
    {
        $this->despesa = $despesa;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {
        Log::info('Processando despesa:', $this->despesa);

        // Criar a despesa no banco de dados
        Despesas::create($this->despesa);

        Log::info('Despesa processada com sucesso!');
    }
}
