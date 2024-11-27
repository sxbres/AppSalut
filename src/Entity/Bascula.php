<?php

namespace App\Entity;

class Bascula
{
    private $operaciones = [];
    private $pesMaximo = null;
    private $pesMinimo = null;

    public function __construct()
    {
        // Constructor sin parámetros
    }

    public function obtenerNombreOperaciones()
    {
        return count($this->operaciones);
    }

    public function anotarPes($pes, $altura = 1, $fecha = null)
    {
        if ($fecha === null) {
            $fecha = new \DateTime();
        }

        $this->operaciones[] = [
            'pes' => $pes,
            'altura' => $altura,
            'fecha' => $fecha
        ];

        if ($this->pesMaximo === null || $pes > $this->pesMaximo) {
            $this->pesMaximo = $pes;
        }

        if ($this->pesMinimo === null || $pes < $this->pesMinimo) {
            $this->pesMinimo = $pes;
        }
    }

    public function obtenerPesMaximo()
    {
        return $this->pesMaximo;
    }

    public function obtenerPesMinimo()
    {
        return $this->pesMinimo;
    }

    public function calcularIMC()
    {
        if (empty($this->operaciones)) {
            return null;
        }

        $ultimaOperacion = end($this->operaciones);
        $pes = $ultimaOperacion['pes'];
        $altura = $ultimaOperacion['altura'];

        $imc = $pes / ($altura * $altura);
        return round($imc, 2); // Redondear el IMC a dos decimales
    }

    public function describirIMC($imc)
    {
        if ($imc < 16) {
            return 'infrapeso (primesa severa)';
        } elseif ($imc >= 16 && $imc < 17) {
            return 'infrapeso (primesa moderada)';
        } elseif ($imc >= 17 && $imc < 18.5) {
            return 'infrapeso (primesa aceptable)';
        } elseif ($imc >= 18.5 && $imc < 25) {
            return 'peso normal';
        } elseif ($imc >= 25 && $imc < 30) {
            return 'sobrepeso';
        } elseif ($imc >= 30 && $imc < 35) {
            return 'obeso (tipo I)';
        } elseif ($imc >= 35 && $imc < 40) {
            return 'obeso (tipo II)';
        } else {
            return 'obeso (tipo III)';
        }
    }

    public function obtenerOperaciones()
    {
        return $this->operaciones;
    }
}