<?php
// tests/Controller/MenuTest.php

namespace App\Tests\funcionalTest;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MenuTest extends WebTestCase
{
    
    public function testMenuPage()
    {
        $client = static::createClient();
        $client->request('GET', '/menu');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Benvinguts a l\'aplicació de');
    }

    public function testAltaPacienteLink()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/menu');

        $link = $crawler->selectLink('Alta del paciente')->link();
        $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Alta del paciente');
    }

    public function testNuevoPesajeLink()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/menu');

        $link = $crawler->selectLink('Nuevo pesaje')->link();
        $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Nuevo Pesaje');
    }

    public function testVerPacientesLink()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/menu');

        $link = $crawler->selectLink('Ver todos los pacientes registrados')->link();
        $client->click($link);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Lista de Pacientes');
    }
}
?>