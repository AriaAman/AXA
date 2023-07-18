<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class ProjetController extends AbstractController
{
    /**
     * @Route("/projets", name="projets_liste", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $projets = $entityManager->getRepository(Projet::class)->findAll();

        return $this->render('projet/index.html.twig', [
            'projets' => $projets,
        ]);
    }

    /**
     * @Route("/projets/nouveau", name="projet_nouveau", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetFormType::class, $projet);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('projet_details', ['id' => $projet->getId()]);
        }

        return $this->render('projet/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/projets/{id}", name="projet_details", methods={"GET"})
     */
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $projet = $entityManager->getRepository(Projet::class)->find($id);

        if (!$projet) {
            throw $this->createNotFoundException('Projet non trouvé.');
        }

        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    /**
     * @Route("/projets/{id}/edit", name="projet_edit", methods={"GET","POST"})
     */
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $projet = $entityManager->getRepository(Projet::class)->find($id);

        if (!$projet) {
            throw $this->createNotFoundException('Projet non trouvé.');
        }

        // Ici, vous pouvez gérer le formulaire d'édition...

        return $this->render('projet/edit.html.twig', [
            'projet' => $projet,
            // 'form' => $form->createView(), // Si vous avez un formulaire
        ]);
    }


    /**
     * @Route("/projets", name="projet_creation", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $projet = new Projet();
        $projet->setName($data['name']);
        $projet->setDescription($data['description']);
        $projet->setStartDate($data['start_date']);
        $projet->setEndTime($data['end_time']);

        $entityManager->persist($projet);
        $entityManager->flush();

        return $this->redirectToRoute('projet_details', ['id' => $projet->getId()]);
    }

    /**
     * @Route("/projets/{id}", name="projet_suppression", methods={"DELETE"})
     */
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $projet = $entityManager->getRepository(Projet::class)->find($id);

        if (!$projet) {
            throw $this->createNotFoundException('Projet non trouvé.');
        }

        $entityManager->remove($projet);
        $entityManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}

