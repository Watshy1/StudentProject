<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;

use App\Entity\School;
use App\Entity\Classe;

use App\Form\Type\ClasseType;

class ClasseController extends AbstractController
{
    #[Route('/classe/show/{id}', name: 'app_classe_show')]
    public function show(Classe $classe): Response
    {
        return $this->render('classe/show.html.twig', [
            'classe' => $classe,
        ]);
    }

    #[Route('/classe/create', name: 'app_classe_create')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $form = $this->createForm(ClasseType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $schoolId = $request->query->get('schoolId');
            $school = $entityManager->getRepository(School::class)->find($schoolId);

            $classe = new Classe();
            $classe->setName($form->get('Classe_name')->getData());
            $classe->setSchool($school);

            $entityManager->persist($classe);
            $entityManager->flush();

            return $this->redirectToRoute('app_school_show', ['id' => $schoolId]);
        }

        return $this->render('classe/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/classe/delete/{id}', name: 'app_classe_delete')]
    public function delete(Classe $classe, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($classe);
        $entityManager->flush();

        return $this->redirectToRoute('app_school_show', ['id' => $classe->getSchool()->getId()]);
    }

}
