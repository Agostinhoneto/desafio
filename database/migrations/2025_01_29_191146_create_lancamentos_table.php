<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLancamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lancamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('usuario_id');
            $table->string('descricao');
            $table->decimal('valor', 10, 2);
            $table->date('data'); // Data do lançamento
            $table->enum('tipo', ['receita', 'despesa']); // Tipo de transação
            $table->boolean('recorrente')->default(false); // Se é uma transação recorrente
            $table->date('proximo_lancamento')->nullable(); // Próxima data caso seja recorrente
            
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');   
            $table->timestamps(); // Criado em / Atualizado em
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lancamentos');
    }
}
