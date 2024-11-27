<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;


class NuevoPesajeController extends AbstractController
{
    #[Route('/menu/nuevo_pesaje', name: 'app_nuevo_pesaje')]
    public function index(Request $request): Response
    {
        $sessio = $request->getSession();
        $arrayPacientes = $sessio->get('pacientes', []);

        // Crear un array de opciones para el formulario
        $opcionesPacientes = [];
        foreach ($arrayPacientes as $index => $paciente) {
            $opcionesPacientes[$paciente->obtenerNombre() . ' ' . $paciente->obtenerApellidos()] = $index;
        }

        // Crear el formulario para seleccionar un paciente
        $form = $this->createFormBuilder()
            ->add('paciente', ChoiceType::class, [
            'choices' => $opcionesPacientes,
            'label' => 'Seleccionar Paciente'
            ])
            ->add('peso', NumberType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Positive(),
            ],
            'label' => 'Peso',
            'help' => 'Introduce el peso en kilogramos'
            ])
            ->add('altura', NumberType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Positive(),
            ],
            'label' => 'Altura',
            'help' => 'Introduce la altura en centímetros (por ejemplo, 175)'
            ])
            ->add('save', SubmitType::class, ['label' => 'Registrar Pesaje'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $indexPacienteSeleccionado = $data['paciente'];
            $pacienteSeleccionado = $arrayPacientes[$indexPacienteSeleccionado];

            // Convertir la altura de centímetros a metros
            $alturaEnMetros = $data['altura'] / 100;

            // Registrar el pesaje en la instancia de Bascula del paciente
            $pacienteSeleccionado->obtenerBascula()->anotarPes($data['peso'], $alturaEnMetros);

            // Guardar los cambios en la sesión
            $arrayPacientes[$indexPacienteSeleccionado] = $pacienteSeleccionado;
            $sessio->set('pacientes', $arrayPacientes);

            // Guardar el índice del paciente seleccionado en la sesión
            $sessio->set('pacienteSeleccionado', $indexPacienteSeleccionado);

            // Redirigir a otra ruta, por ejemplo, para mostrar el IMC
            return $this->redirectToRoute('imc');
        }

        return $this->render('NuevoPesajeControlador/index.html.twig', [
            'controller_name' => 'NuevoPesajeController',
            'formulari' => $form->createView(),
        ]);
    }

    #[Route('/menu/nuevo_pesaje/IMC', name: 'imc')]
    public function formOK(Request $request): Response
    {
        $sessio = $request->getSession();
        $arrayPacientes = $sessio->get('pacientes', []);
        $indexPacienteSeleccionado = $sessio->get('pacienteSeleccionado');

        if ($indexPacienteSeleccionado !== null) {
            $pacienteSeleccionado = $arrayPacientes[$indexPacienteSeleccionado];
            $bascula = $pacienteSeleccionado->obtenerBascula();
            $imc = $bascula->calcularIMC();
            $descripcionIMC = $bascula->describirIMC($imc);

            return $this->render('NuevoPesajeControlador/IMC.html.twig', [
                'nombre' => $pacienteSeleccionado->obtenerNombre(),
                'apellidos' => $pacienteSeleccionado->obtenerApellidos(),
                'imc' => $imc,
                'descripcionIMC' => $descripcionIMC,
            ]);
        }

        return new Response("No se pudo calcular el IMC.");
    }
}