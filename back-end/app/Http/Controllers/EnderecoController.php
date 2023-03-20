<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    public function enderecoIndex()
    {
        $data = Endereco::all();
        return response()->json(['data' =>$data]);
    }
}   
