<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Http\Resources\UserResource;
use App\Models\Endereco;
use App\Models\EnderecoUser;
use App\Models\User;
use App\Services\UserService;
use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{    

    protected $user,$userService;

    public function __construct(User $user,UserService $userService)
    {
        $this->user = $user;
        $this->userService = $userService;
    }

    public function index()
    {
       $data = User::with('role','enderecoUsers')->get();
       return response()->json(['data' =>$data]);
    }

    public function create()
    {
        //
    }

    public function store(UserFormRequest $request)
    {
        
        $user = User::create([
            'name' =>$request->name,
            'email' =>$request->email,
            'password' =>bcrypt($request->password),
            'cpf' => $request->cpf,
            'role_id' => $request->role_id,
        ]);
      
        $user->enderecos()->create([
            'logradouro' => $request->logradouro,
            'cep' => $request->cep,
        ]);
        $user->enderecoUser()->create([
            'user_id' => $request->user_id,
            'endereco_id' => $request->endereco_id,
        ]);
           //dd($user);
     
        return response()->json(['msg' => 'Dados Salvos com sucesso', 'data' => $user]);
     }
 
     
    public function show($id)
    {
        $data = User::with('enderecoUsers')->find($id);
        return response()->json(['msg' => 'Dados exibidos com sucesso', 'data' => $data]);

    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
    
        $dataRequest = $request->all();
        $data = User::findOrFail($id);
        
        $data->update($dataRequest);
        $data->enderecos()->update([
            
            'logradouro' => $request->logradouro,
            'cep' => $request->cep,
        ]);
            
        return response()->json(['msg' => 'Dados atualizados com sucesso', 'data' => $data]);
    }   

    public function destroy($id)
    {
        $data = User::find($id);
        $data->delete();
        return response()->json(['msg' => 'Dados excluidos com sucesso', 'data' => $data]);    
    }

    public function search(Request $request)
    {
        $filterUser = 
        User::where('name', $request->name ,'cpf', $request->cpf )
         ->get();
    }  
}
