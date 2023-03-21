<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    //protected $fillable = ['enderecos'];

    protected $fillable = [
        'logradouro',
        'cep', 
     ];
    public function user(){
        return $this->belongsTo(User::class);
    }    
    
    public function enderecoUser()
    {
        return $this->manyTomany(EnderecoUser::class);
    }
}
