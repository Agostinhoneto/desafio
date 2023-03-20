<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    //protected $fillable = ['enderecos'];

    public function enderecoUser()
    {
        return $this->belongsTo(Endereco::class);
    } 

    public function users(){
        return $this->belongsTo(User::class);
    }
}
