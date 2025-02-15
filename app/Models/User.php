<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Core\Database\ModelBase;
use Core\Database\QueryBuilder;

class User extends ModelBase
{
    // O Eloquent usa o nome da classe no plural como o nome da tabela por padrão
    // Se a tabela for diferente, você pode especificar o nome dela assim:
    // protected $table = 'users_table';

    // Define os campos que podem ser preenchidos em uma inserção
    protected $fillable = ['name', 'email', 'password'];
}
