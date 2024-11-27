<?php
namespace App\Tests;

use App\Entity\Bascula;
use PHPUnit\Framework\TestCase;

class BasculaTest extends TestCase
{
    /**
     * @dataProvider pesajeProvider
     */
    public function testAnotarPes($peso, $altura)
    {
        $bascula = new Bascula();
        $bascula->anotarPes($peso, $altura);

        $operaciones = $bascula->obtenerOperaciones();
        $this->assertCount(1, $operaciones);
        $this->assertEquals($peso, $operaciones[0]['pes']);
        $this->assertEquals($altura, $operaciones[0]['altura']);
    }

    public function pesajeProvider(): array
    {
        return [
            [70, 175],
            [80, 180],
            [60, 165],
            [90, 190],
            [50, 150],
        ];
    }

    /**
     * @dataProvider imcProvider
     */
    public function testCalcularIMC($peso, $altura, $expectedIMC)
    {
        $bascula = new Bascula();
        $bascula->anotarPes($peso, $altura);

        $imc = $bascula->calcularIMC();
        $this->assertEquals($expectedIMC, $imc, '', 0.01);
    }

    public function imcProvider(): array
    {
        //A diferencia de la prueba de arriba, aqui le pasamos la altura en metros para que calcule el imc
        //correctamente porque asi lo requiere la funcion calcularIMC
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