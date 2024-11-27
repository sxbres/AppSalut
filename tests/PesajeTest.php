<?php
namespace App\tests;

use App\Entity\Pesaje;
use PHPUnit\Framework\TestCase;

class PesajeTest extends TestCase
{
    /**
     * @dataProvider pesajeProvider
     */
    public function testCrearPesaje($peso, $altura, $fecha)
    {
        $pesaje = new Pesaje($peso, $altura, new \DateTime($fecha));

        $this->assertEquals($peso, $pesaje->obtenerPeso());
        $this->assertEquals($altura, $pesaje->obtenerAltura());
        $this->assertEquals(new \DateTime($fecha), $pesaje->obtenerFecha());
    }

    public function pesajeProvider(): array
    {
        return [
            [70, 1.75, '2022-01-01'],
            [80, 1.80, '2022-02-02'],
            [60, 1.65, '2022-03-03'],
            [90, 1.90, '2022-04-04'],
            [50, 1.50, '2022-05-05'],
        ];
    }
}
?>