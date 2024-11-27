<?php
namespace App\tests;

use App\Entity\Paciente;
use PHPUnit\Framework\TestCase;

class PacienteTest extends TestCase
{
    /**
     * @dataProvider pacienteProvider
     */
    
    public function testObtenerNombre($nombre, $apellidos, $fechaNacimiento)
    {
        $paciente = new Paciente($nombre, $apellidos, $fechaNacimiento);

        $this->assertEquals($nombre, $paciente->obtenerNombre());
        $this->assertEquals($apellidos, $paciente->obtenerApellidos());
        $this->assertEquals(new \DateTime($fechaNacimiento), $paciente->obtenerFechaNacimiento());
    }

    public function pacienteProvider(): array
    {
        return [
            ['Juan', 'Perez', '1980-01-01'],
            ['Maria', 'Lopez', '1990-02-02'],
            ['Carlos', 'Garcia', '2000-03-03'],
            ['Ana', 'Martinez', '2010-04-04'],
            ['Luis', 'Hernandez', '2020-05-05'],
        ];
    }

    /**
     * @dataProvider imcProvider
     */
    
    public function testCalcularIMC($peso, $altura, $expectedIMC)
    {
        $paciente = new Paciente('Test', 'Paciente', '2000-01-01');
        $paciente->obtenerBascula()->anotarPes($peso, $altura);

        $imc = $paciente->calcularIMC();
        $this->assertEquals($expectedIMC, $imc, '', 0.01);
    }

    public function imcProvider(): array
    {
        return [
            [70, 1.75, 22.86],
            [80, 1.80, 24.69],
            [60, 1.65, 22.04],
            [90, 1.90, 24.93],
            [50, 1.50, 22.22],
        ];
    }
}
?>