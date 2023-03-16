<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
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
      
      //  $users = User::with('role')->get();
       // return UserResource::collection($users);
      
       $data = User::with('role')->get();
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
            'lagradouro' => $request->lagradouro,
            'perfil' => $request->perfil,
            'cep' => $request->cep,
            'role_id' => 1           
        ]);

        return response()->json(['data' =>$user]);     
     }
 
     
    public function show($id)
    {
        $result = ['status' =>200];
        try{
            $result['data'] = $this->userService->getById($id);
        }
        catch(Exception $e){
            $result = [
                'status' =>500,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result,$result['status']);   
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
        return response()->json(['msg' => 'Dados atualizados com sucesso', 'data' => $data]);
    }

    public function destroy($id)
    {
        $data = User::find($id);
        $data->delete();
        return response()->json(['msg' => 'Dados excluidos com sucesso', 'data' => $data]);    
    }
}
