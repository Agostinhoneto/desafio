<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lancamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'categoria_id',
        'descricao',
        'valor',
        'data',
        'tipo',
        'recorrente',
        'proximo_lancamento',
    ];

    // Relação com o usuário
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    // Relação com a categoria
    public function categoria()
    {
        return $this->belongsTo(Categorias::class);
    }
}
