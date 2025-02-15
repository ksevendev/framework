<?php

namespace Core\Console;

abstract class Command
{
    // Nome do grupo do comando (ex: 'Make')
    protected $group;

    // Nome do comando (ex: 'make:controller')
    protected $name;

    // Descrição do comando
    protected $description;

    // Método para retornar o nome do grupo
    public function group(): string
    {
        return $this->group;
    }

    // Método para retornar o nome do comando
    public function name(): string
    {
        return $this->name;
    }

    // Método para retornar a descrição do comando
    public function description(): string
    {
        return $this->description;
    }

    // Método para retornar a "assinatura" do comando
    public function signature(): string
    {
        return $this->name;
        //return str_replace(':', '-', $this->name);
    }

    // Método abstrato que deve ser implementado pelos comandos
    abstract public function run(array $args);
}
