<?php

namespace App\Entity;

class Pesaje
{
    private $peso;
    private $altura;
    private $fecha;

    public function __construct($peso, $altura, $fecha)
    {
        $this->peso = $peso;
        $this->altura = $altura;
        $this->fecha = $fecha;
    }

    public function obtenerPeso()
    {
        return $this->peso;
    }

    public function obtenerAltura()
    {
        return $this->altura;
    }

    public function obtenerFecha()
    {
        return $this->fecha;
    }
}
?>