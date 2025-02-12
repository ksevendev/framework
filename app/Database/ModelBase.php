<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model as Eloquent;

class ModelBase extends Eloquent
{
    // Definir os campos permitidos para operações de criação e atualização
    protected $fillable = [];

    // Método para buscar todos os registros
    public static function allRecords()
    {
        return self::all();  // Eloquent oferece o método all()
    }

    // Método para buscar um registro por ID
    public static function findRecord($id)
    {
        return self::find($id);  // Eloquent oferece o método find()
    }

    // Método para criar um novo registro
    public static function createRecord(array $data)
    {
        return self::create($data);  // Eloquent oferece o método create()
    }

    // Método para atualizar um registro
    public static function updateRecord($id, array $data)
    {
        $record = self::find($id);
        if ($record) {
            $record->update($data);  // Eloquent oferece o método update()
            return $record;
        }
        return null;
    }

    // Método para deletar um registro
    public static function deleteRecord($id)
    {
        $record = self::find($id);
        if ($record) {
            $record->delete();  // Eloquent oferece o método delete()
            return true;
        }
        return false;
    }
}
