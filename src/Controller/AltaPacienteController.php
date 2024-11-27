<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\Paciente;

class AltaPacienteController extends AbstractController
{
    #[Route('/menu/alta_paciente', name: 'app_alta_paciente')]
    public function index(Request $request): Response
    {
        $sessio = $request->getSession();
        //creo un objecte de la classe Paciente
        $paciente = new Paciente("","","");
        $form = $this->createFormBuilder($paciente)
                ->add('nombre', TextType::class, [
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Regex([
                            'pattern' => '/^[^0-9]*$/',
                            'message' => 'El nombre no puede contener números.',
                        ]),
                    ],
                ])
                ->add('apellidos', TextType::class, [
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Regex([
                            'pattern' => '/^[^0-9]*$/',
                            'message' => 'Los apellidos no pueden contener números.',
                        ]),
                    ],
                ])
                ->add('fechaNacimiento', DateType::class, [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'html5' => true,
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\LessThanOrEqual([
                            'value' => new \DateTime(),
                            'message' => 'La fecha de nacimiento no puede ser mayor que la fecha actual.',
                        ]),
                    ],
                ])
                ->add('save', SubmitType::class, ['label' => 'Crear Paciente'])
                ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $paciente = $form->getData();
            $arrayPacientes = $sessio->get('pacientes', []); // Inicializa con un array vacío si no existe
            array_push($arrayPacientes, $paciente);
            $sessio->set('pacientes', $arrayPacientes);

            return $this->redirectToRoute('correcto');
        }
        
        return $this->render('AltaPacienteControlador/index.html.twig', [
            'controller_name' => 'AltaPacienteController',
            'formulari' => $form->createView(),
        ]);
    }

    #[Route('/menu/alta_paciente/formOk', name: 'correcto')]
    public function formOK(Request $request): Response
    {
        $sessio = $request->getSession();
        var_dump($sessio->get('pacientes'));
        //return new Response("Tot OK");
        return $this->render('AltaPacienteControlador/OK.html.twig', [
            'controller_name' => 'AltaPacienteController',
        ]);
    }
}