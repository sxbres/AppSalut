<?php
// tests/Controller/NuevoPesajeTest.php

namespace App\Tests\funcionalTest;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Paciente;

class NuevoPesajeTest extends WebTestCase
{
    public function testNuevoPesajePage()
    {
        $client = static::createClient();
        $client->request('GET', '/menu/nuevo_pesaje');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Nuevo Pesaje');
    }

    public function testRegistrarPesaje()
    {
        $client = static::createClient();
        $session = $client->getContainer()->get('session');

        // Agregar un paciente de prueba en la sesión
        $paciente = new Paciente('Test', 'Paciente', '2000-01-01');
        $pacientes = [$paciente];
        $session->set('pacientes', $pacientes);
        $session->save();

        $crawler = $client->request('GET', '/menu/nuevo_pesaje');

        $form = $crawler->selectButton('Registrar Pesaje')->form();
        $form['form[paciente]'] = 0; // Asumiendo que el primer paciente tiene índice 0
        $form['form[peso]'] = 70;
        $form['form[altura]'] = 175;

        $client->submit($form);

        $this->assertResponseRedirects('/menu/nuevo_pesaje/IMC');
        $client->followRedirect();

        $this->assertSelectorTextContains('h1', 'IMC del Paciente');
    }
}
?>