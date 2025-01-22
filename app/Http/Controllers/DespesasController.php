<?php

namespace App\Http\Controllers;

use App\Mail\MailDespesas as MailMailDespesas;
use App\Mail\SendWelcomeEmail;
use App\Models\Categorias;
use App\Models\Despesas;
use App\Models\User;
use App\Notifications\DespesaAlertaNotification;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DespesasController extends Controller
{

    public function indexDespesas(Request $request)
    {
        $data = Despesas::with('categoria')->get();
        return response()->json(['data' =>$data]);
    }

        
    public function storeDespesas(Request $request)
    {
        $data = $request->only(['descricao', 'valor', 'data_pagamento', 'categoria_id','user_id']);
        $data['status'] = $request->input('status', 1);
        Despesas::create($data);
        return response()->json(['data' =>$data]);
    }

    public function edit(Request $request, Despesas $despesas, $id)
    {
        try {
            $despesas = Despesas::find($id);
            $mensagem = $request->session()->get('mensagem');

            $categorias = Categorias::query()->orderBy('descricao')->get();
            return view('despesas.edit', compact('despesas', 'categorias', 'mensagem'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Erro ao carregar o formulário de criação: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Despesas $despesas, $id)
    {
        $despesas = Despesas::findOrFail($id);
        $despesas->update($request->all());
        return redirect()->route('despesas.index')->with('success', 'Despesas atualizada com sucesso!');
    }

    public function destroy(Despesas $despesas)
    {
        $despesas->delete();
        $mensagem = session()->get('mensagem');
        return redirect()->route('despesas.index')->with('success', 'Despesa excluida com sucesso!');
    }

    public function gerarPdf()
    {
        $despesas = Despesas::orderByDesc('created_at')->get();

        $pdf = FacadePdf::loadView('relatorios.pdf', ['despesas' => $despesas])->setPaper('a4', 'portrait');

        return $pdf->download('listar_despesas.pdf');
    }

    public function enviarAlertaDespesa($userId, $gastoAtual, $limiteGastos)
    {
        $user = User::find($userId);

        if ($user) {
            $user->notify(new DespesaAlertaNotification($gastoAtual, $limiteGastos));
            return response()->json(['message' => 'Notificação enviada com sucesso!']);
        }

        return response()->json(['message' => 'Usuário não encontrado'], 404);
    }

    public function enviarEmail()
    {
        $dados = [
            'item1' => 'Valor 1',
            'item2' => 'Valor 2',
        ];

        Mail::to('agostneto6@gmail.com')->send(new SendWelcomeEmail($dados));

        return 'E-mail enviado com sucesso!';
    }
}
