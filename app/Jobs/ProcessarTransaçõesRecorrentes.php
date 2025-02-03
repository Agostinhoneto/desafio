<?php

namespace App\Jobs;

use App\Models\Lancamento;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Lancamento;
use Illuminate\Support\Facades\DB;

class ProcessarTransaçõesRecorrentes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute o job.
     */
    public function handle()
    {
        Log::info('O job ProcessarTransaçõesRecorrentes foi iniciado.');

        DB::transaction(function () {
            $transacoes = Lancamento::where('recorrente', true)
                ->where('proximo_lancamento', '<=', Carbon::now()) 
                ->lockForUpdate()
                ->get();

            foreach ($transacoes as $transacao) {
                Lancamento::create([
                    'usuario_id'        => $transacao->usuario_id,
                    'categoria_id'      => $transacao->categoria_id,
                    'descricao'         => $transacao->descricao,
                    'valor'             => $transacao->valor,
                    'data'              => Carbon::now(), // Data atual
                    'recorrente'        => false, // O novo lançamento não é recorrente
                    'proximo_lancamento'=> null,
                ]);

                $transacao->update([
                    'proximo_lancamento' => Carbon::parse($transacao->proximo_lancamento)->addMonth(),
                ]);
            }
        });

        Log::info('O job ProcessarTransaçõesRecorrentes foi concluído.');
    }
}
