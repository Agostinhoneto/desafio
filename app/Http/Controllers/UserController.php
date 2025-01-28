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
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{    

    protected $user,$userService;

    public function __construct(User $user,UserService $userService)
    {
        $this->user = $user;
        $this->userService = $userService;
    }

    public function indexUsers()
    {
       $data = User::with('role','enderecoUsers')->get();
       return response()->json(['data' =>$data]);
    }

    public function storeUsers(UserFormRequest $request)
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
 
     
    public function showUsers($id)
    {
        $data = User::with('enderecoUsers')->find($id);
        return response()->json(['msg' => 'Dados exibidos com sucesso', 'data' => $data]);

    }

    public function updateUsers(Request $request, $id)
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

    public function destroyUsers($id)
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

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
            $user = Auth::user();

            // Gera um token de autenticação para o usuário
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status' => 'success',
                'message' => 'Login successful.',
                'user' => $user,
                'token' => $token,
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid email or password.',
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully.',
        ], 200);
    }
}

