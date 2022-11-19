<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Address;
use App\Entity\School;

use App\Repository\SchoolRepository;

use App\Form\Type\SchoolType;

class SchoolController extends AbstractController
{
    #[Route('/', name: 'app_school')]
    public function index(SchoolRepository $schoolRepository): Response
    {
        $schools = $schoolRepository->findAll();

        return $this->render('school/index.html.twig', [
            'controller_name' => 'SchoolController',
            'schools' => $schools,
        ]);
    }

    #[Route('/school/show/{id}', name: 'app_school_show')]
    public function show(School $school): Response
    {
        return $this->render('school/show.html.twig', [
            'school' => $school,
        ]);
    }

    #[Route('/school/create', name: 'app_school_create')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $form = $this->createForm(SchoolType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $school = new School();
            $school->setName($form->get('name')->getData());

            $address = new Address();
            $address->setStreet($form->get('Street')->getData());
            $address->setPostalCode($form->get('Postal_code')->getData());
            $address->setCity($form->get('City')->getData());

            $school->setAddress($address);

            $entityManager->persist($school);
            $entityManager->flush();

            return $this->redirectToRoute('app_school');
        }

        return $this->render('school/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/school/delete/{id}', name: 'app_school_delete')]
    public function delete(School $school, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($school);
        $entityManager->flush();

        return $this->redirectToRoute('app_school');
    }
}
