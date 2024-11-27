<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ListaPacientesController extends AbstractController
{
    #[Route('/menu/ver_pacientes', name: 'app_lista_pacientes')]
    public function index(Request $request): Response
    {
        $sessio = $request->getSession();
        $pacientes = $sessio->get('pacientes', []);

        // Renderizar la vista con la lista de pacientes
        return $this->render('ListaPacienteControlador/index.html.twig', [
            'pacientes' => $pacientes,
        ]);
    }

    #[Route('/menu/ver_paciente/{index}', name: 'app_ver_paciente')]
    public function verPaciente(Request $request, $index): Response
    {
        $sessio = $request->getSession();
        $pacientes = $sessio->get('pacientes', []);
        $paciente = $pacientes[$index];

        // Renderizar la vista con los pesajes del paciente
        return $this->render('ListaPacienteControlador/ver_paciente.html.twig', [
            'paciente' => $paciente,
            'pesajes' => $paciente->obtenerBascula()->obtenerOperaciones(),
        ]);
    }
}