<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;

use App\Entity\Classe;
use App\Entity\Student;
use App\Entity\Address;

use App\Form\Type\StudentType;

class StudentController extends AbstractController
{
    #[Route('/student/show/{id}', name: 'app_student_show')]
    public function show(Student $student): Response
    {
        return $this->render('student/show.html.twig', [
            'student' => $student,
        ]);
    }

    #[Route('/student/create', name: 'app_student_create')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $form = $this->createForm(StudentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classeId = $request->query->get('classeId');
            $classe = $entityManager->getRepository(Classe::class)->find($classeId);

            $address = new Address();
            $address->setStreet($form->get('Street')->getData());
            $address->setPostalCode($form->get('Postal_code')->getData());
            $address->setCity($form->get('City')->getData());

            $student = new Student();
            $student->setCreatedAt(new \Datetime());
            $student->setFirstName($form->get('first_name')->getData());
            $student->setLastName($form->get('last_name')->getData());
            $student->setEmail($form->get('email')->getData());
            $student->setBirthDate($form->get('birthdate')->getData());
            $student->setAddress($address);
            $student->addClasse($classe);

            $entityManager->persist($address);
            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('app_classe_show', ['id' => $classeId]);
        }

        return $this->render('student/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/student/delete/{id}', name: 'app_student_delete')]
    public function delete(Student $student, ManagerRegistry $doctrine): Response
    {
        $classeId = $student->getClasse()[0]->getId();
        
        $entityManager = $doctrine->getManager();
        $entityManager->remove($student);
        $entityManager->flush();

        return $this->redirectToRoute('app_classe_show', ['id' => $classeId]);
    }
}
