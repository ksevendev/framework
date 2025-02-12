<?php

namespace App\Database;

class QueryBuilder
{
    protected $pdo;
    protected $table;
    protected $columns = '*';
    protected $conditions = [];
    protected $bindings = [];
    
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function select($columns)
    {
        $this->columns = implode(', ', (array) $columns);
        return $this;
    }

    public function where($column, $operator, $value)
    {
        $this->conditions[] = "$column $operator ?";
        $this->bindings[] = $value;
        return $this;
    }

    public function get()
    {
        $sql = "SELECT {$this->columns} FROM {$this->table}";
        if ($this->conditions) {
            $sql .= ' WHERE ' . implode(' AND ', $this->conditions);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
