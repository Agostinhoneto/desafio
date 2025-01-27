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
        $data = Receitas::find($id);
        return response()->json(['data' => $data]);

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
        return response()->json(['data' =>$data]);
    }

    /**
     * Show the form for editing the specified receita.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
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

    /**
     * Update the specified receita in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $receitas = Receitas::findOrFail($id);
            $receitas->update($request->only(['descricao', 'valor', 'data_recebimento', 'categoria_id', 'status']));

            return redirect()->route('receitas.index')->with('success', 'Receita atualizada com sucesso!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('receitas.index')->withErrors('Receita não encontrada.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Erro ao atualizar a receita: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified receita from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
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
