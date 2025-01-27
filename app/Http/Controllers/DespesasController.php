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

    public function showDespesas($id)
    {
        $despesa = Despesas::find($id);
        if (!$despesa) {
            return response()->json(['error' => 'despesa não encontrada'], 404);
        }
        return response()->json(['data' => $despesa]);
    }
        
    public function storeDespesas(Request $request)
    {
        $data = $request->only(['descricao', 'valor', 'data_pagamento', 'categoria_id','user_id']);
        $data['status'] = $request->input('status', 1);
        Despesas::create($data);
        return response()->json(['data' =>$data]);
    }

    public function updateDespesas(Request $request, Despesas $despesas, $id)
    {
        $despesas = Despesas::findOrFail($id);
        $despesas->update($request->all());
        return response()->json(['msg' => 'Dados atualizados com sucesso', 'data' => $despesas]);
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

    public function destroy(Despesas $despesas)
    {
        $despesas->delete();
        $mensagem = session()->get('mensagem');
        return redirect()->route('despesas.index')->with('success', 'Despesa excluida com sucesso!');
    }
}
