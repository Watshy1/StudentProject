<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Cours;

use App\Form\Type\CoursType;
use App\Repository\StudentRepository;

class CoursController extends AbstractController
{
    #[Route('/cours', name: 'app_cours')]
    public function index(): Response
    {
        return $this->render('cours/index.html.twig');
    }

    #[Route('/cours/create', name: 'app_cours_create')]
    public function new(Request $request, StudentRepository $studentRepository, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $students = $studentRepository->findAll();

        $form = $this->createForm(CoursType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cours = new Cours();
            $cours->setName($form->get('name')->getData());
            dd($form->get('students')->getData());
            $cours->addStudent($form->get('students')->getData());

            $entityManager->persist($cours);
            $entityManager->flush();

            return $this->redirectToRoute('app_cours');
        }

        return $this->render('cours/create.html.twig', [
            'form' => $form->createView(),
            'students' => $students,
        ]);
    }
}
