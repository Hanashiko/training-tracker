<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Form\ExerciseFormType;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\{
    Request,
    Response
};

#[Route('/exercise')]
final class ExerciseController extends AbstractController
{
    #[Route('/', name: 'app_exercise_index', methods: ['GET'])]
    public function index(ExerciseRepository $exerciseRepository): Response
    {
        return $this->render('exercise/index.html.twig', [
            'exercises' => $exerciseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_exercise_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $exercise = new Exercise();
        $form = $this->createForm(ExerciseFormType::class, $exercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($exercise);
            $entityManager->flush();

            return $this->redirectToRoute('app_exercise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercise/new.html.twig', [
            'exercise' => $exercise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exercise_show', methods: ['GET'])]
    public function show(Exercise $exercise): Response
    {
        return $this->render('exercise/show.html.twig', [
            'exercise' => $exercise,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_exercise_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Exercise $exercise, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExerciseFormType::class, $exercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_exercise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercise/edit.html.twig', [
            'exercise' => $exercise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exercise_delete', methods: ['POST'])]
    public function delete(Request $request, Exercise $exercise, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exercise->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($exercise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_exercise_index', [], Response::HTTP_SEE_OTHER);
    }
}
