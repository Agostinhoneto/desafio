<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReceitasRequest;
use App\Models\Categorias;
use App\Models\Receitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReceitasController extends Controller
{

    public function indexReceitas(Request $request)
    {
        $data = Receitas::with('categoria')->get();
        return response()->json(['data' => $data]);
    }

    public function showReceita($id)
    {
        $receita = Receitas::find($id);
        if (!$receita) {
            return response()->json(['error' => 'Receita não encontrada'], 404);
        }
        return response()->json(['data' => $receita]);
    }

    public function create()
    {
        try {
            $categorias = Categorias::orderBy('descricao')->get();
            return view('receitas.create', compact('categorias'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Erro ao carregar o formulário de criação: ' . $e->getMessage());
        }
    }


    public function storeReceitas(Request $request)
    {
        $data = $request->only(['descricao', 'valor', 'data_recebimento', 'categoria_id']);
        $data['status'] = $request->input('status', 1);
        Receitas::create($data);
        return response()->json(['data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        try {
            $receitas = Receitas::findOrFail($id);
            $mensagem = $request->session()->get('mensagem');
            $categorias = Categorias::orderBy('descricao')->get();

            return view('receitas.edit', compact('receitas', 'categorias', 'mensagem'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('receitas.index')->withErrors('Receita não encontrada.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Erro ao carregar o formulário de edição: ' . $e->getMessage());
        }
    }
   
    public function updateReceita(Request $request, $id)
    {
        $dataRequest = $request->all();
        $data = Receitas::findOrFail($id);
        $data->update($dataRequest);
        return response()->json(['msg' => 'Dados atualizados com sucesso', 'data' => $data]);
    }

    public function destroy($id)
    {
        try {
            $receitas = Receitas::findOrFail($id);
            $receitas->delete();

            return redirect()->route('receitas.index')->with('success', 'Receita excluída com sucesso!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('receitas.index')->withErrors('Receita não encontrada.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Erro ao excluir a receita: ' . $e->getMessage());
        }
    }
}
