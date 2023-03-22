<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    public function enderecoIndex()
    {
        $data = Endereco::get();
        return response()->json(['data' =>$data]);
    }

    public function storeEndereco(Request $request)
    {
        $endereco = Endereco::create([
            "logradouro"=>$request->input("logradouro"),
            "cep"=>$request->input("cep")
        ]);
	    return $endereco;
    }
    
    public function enderecoDestroy($id)
    {
        $data = Endereco::find($id);
        $data->delete();
        return response()->json(['msg' => 'Dados excluidos com sucesso', 'data' => $data]);    
    }

}   
