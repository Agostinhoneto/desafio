<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnderecoUser extends Model
{
    use HasFactory;

    public function users(){
        return $this->ManytoMany(User::class);
    }

    public function enderecos(){
        return $this->hasMany(Endereco::class);
    }

}
