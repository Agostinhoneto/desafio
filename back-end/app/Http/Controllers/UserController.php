<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Http\Resources\UserResource;
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
       $data = User::with('role','enderecoUser')->get();
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
        $user->enderecos->create([
            'logradouro' => $request->lagrodouro,
            'cep' => $request->cep,
        ]);
        $user->enderecosUser->create([
            'user_id' => $request->user_id,
            'endereco_id' => $request->endereco_id,
        ]);

        //dd($user);
        //$enderecoUser = new EnderecoUser($request->all());
        //$enderecoUser->user_id = $user->id;
        //$endereco->save();
       // $date = Carbon::now()->format('d-m-Y');
        return response()->json(['msg' => 'Dados Salvos com sucesso', 'data' => $user]);
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

    public function search(Request $request)
    {
        $query = User::get();
        if ($request->has('name')) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->has('email')) {
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }

        if ($request->has('cpf')) {
            $query->where('cpf', 'LIKE', '%' . $request->cpf . '%');
        }
        return $query;
    }  
}
