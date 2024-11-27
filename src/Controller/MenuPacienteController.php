<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MenuPacienteController extends AbstractController
{
    #[Route('/menu', name: 'app_aplicacion')]
    public function index(Request $request): Response
    {
        $sessio = $request->getSession();
        //per no matxacar el array de cotxes
        if (empty($sessio->get("paciente"))) {
            $sessio->set('paciente', array());
        }
        return $this->render('MenuControlador/index.html.twig', [
            'nomWeb' => 'web AppSalut',
        ]);
    }
}