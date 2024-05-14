<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Form\SearchPersonType;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
class PersonController extends AbstractController
{
    #[Route('/', name: 'app_person_index', methods: ['GET', 'POST'])]
    public function index(Request $request, PersonRepository $personRepository): Response
    {
        $person = new Person();
        $form = $this->createForm(SearchPersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nis = $form->getData()->getNis();
            $person = $personRepository->findOneBy(array('nis' => $nis));

            if (!$person) {
                return $this->render('person/not_found.html.twig');
            }

            return $this->render('person/show.html.twig', [
                'person' => $person,
            ]);
        }

        return $this->render('person/search.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'app_person_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PersonRepository $personRepository): Response
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $isNisInvalid = true;
            do {
                $nis = $person->generateNis();
                $isNisInvalid = $personRepository->findBy(array('nis' => $nis));
            } while ($isNisInvalid);
            $person->setNis($nis);
            $entityManager->persist($person);
            $entityManager->flush();

            // return $this->redirectToRoute('app_person_index', [], Response::HTTP_SEE_OTHER);
            return $this->render('person/created.html.twig', [
                'person' => $person,
                'form' => $form,
            ]);
        }

        return $this->render('person/new.html.twig', [
            'person' => $person,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_person_show', methods: ['GET'])]
    public function show(Person $person): Response
    {
        return $this->render('person/show.html.twig', [
            'person' => $person,
        ]);
    }
}
