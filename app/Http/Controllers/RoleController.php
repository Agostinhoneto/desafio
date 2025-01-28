<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Http\Resources\UserResource;
use App\Models\Endereco;
use App\Models\EnderecoUser;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function indexRoles()
    {
       $data = Role::all();
       return response()->json(['data' =>$data]);
    }
}