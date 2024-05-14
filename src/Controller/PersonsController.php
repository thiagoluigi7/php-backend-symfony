<?php

namespace App\Controller;

use App\Entity\Persons;
use App\Form\PersonsType;
use App\Repository\PersonsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/persons')]
class PersonsController extends AbstractController
{
    #[Route('/', name: 'app_persons_index', methods: ['GET'])]
    public function index(PersonsRepository $personsRepository): Response
    {
        return $this->render('persons/index.html.twig', [
            'persons' => $personsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_persons_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $person = new Persons();
        $form = $this->createForm(PersonsType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($person);
            $entityManager->flush();

            return $this->redirectToRoute('app_persons_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('persons/new.html.twig', [
            'person' => $person,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_persons_show', methods: ['GET'])]
    public function show(Persons $person): Response
    {
        return $this->render('persons/show.html.twig', [
            'person' => $person,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_persons_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Persons $person, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PersonsType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_persons_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('persons/edit.html.twig', [
            'person' => $person,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_persons_delete', methods: ['POST'])]
    public function delete(Request $request, Persons $person, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$person->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($person);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_persons_index', [], Response::HTTP_SEE_OTHER);
    }
}
