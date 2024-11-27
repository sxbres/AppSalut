<?php

namespace App\Entity;

use DateTime;

class Paciente {
    var $nombre;
    var $apellidos;
    var $fechaNacimiento;
    var $bascula;

    public function __construct($nombre, $apellidos, $fechaNacimiento) {
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->fechaNacimiento = new \DateTime($fechaNacimiento);
        $this->bascula = new Bascula();
    }

    public function saludar() {
        return "Hola, soy " . $this->nombre . " " . $this->apellidos;
    }

    public function obtenerNombre() {
        return $this->nombre;
    }

    public function modificarNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function obtenerApellidos() {
        return $this->apellidos;
    }

    public function modificarApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function obtenerFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    public function modificarFechaNacimiento($fecha) {
        $this->fechaNacimiento = $fecha;
    }

    public function obtenerEdad() {
        $fechaActual = new DateTime();
        $fechaNacimiento = $this->fechaNacimiento;
        $edad = $fechaActual->diff($fechaNacimiento);
        return $edad->y;
    }

    public function modificarBascula($bascula) {
        $this->bascula = $bascula;
    }

    public function obtenerBascula() {
        return $this->bascula;
    }

    public function calcularIMC() {
        if ($this->bascula) {
            return $this->bascula->calcularIMC();
        } else {
            return "No hay báscula asociada.";
        }
    }
}
