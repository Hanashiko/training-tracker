<?php

namespace App\Controller;

use App\Entity\Workout;
use App\Entity\WorkoutExercise;
use App\Form\WorkoutExerciseFormType;
use App\Form\WorkoutFormType;
use App\Repository\WorkoutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/workout')]
final class WorkoutController extends AbstractController
{
    #[Route('/', name: 'app_workout_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $workouts = $entityManager->getRepository(Workout::class)
            ->findBy(['user' => $this->getUser()]);
        return $this->render('workout/index.html.twig', [
            'workouts' => $workouts,
        ]);
    }

    #[Route('/new', name:'app_workout_new')]
    #[IsGranted('ROLE_USER')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $workout = new Workout();
        $workout->setUser($this->getUser());

        $form = $this->createForm(WorkoutFormType::class, $workout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($workout->getWorkoutExercises() as $workoutExercise) {
                $workoutExercise->setWorkout($workout);
            }

            $entityManager->persist($workout);
            $entityManager->flush();

            $this->addFlash('success', 'Тренування успішно додано');
            return $this->redirectToRoute('app_workout_index');
        }

        return $this->render('workout/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/{id}', name: 'app_workout_show', requirements: ['id' => '\d+'])]
    public function show(Workout $workout): Response
    {
        if ($workout->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        return $this->render('workout/show.html.twig', [
            'workout' => $workout,
        ]);
    }

    #[Route('/{id}/add-exercise', name: 'app_workout_add_exercise')]
    public function addExercise(
        Request $request,
        Workout $workout,
        EntityManagerInterface $entityManager
    ): Response
    {
        if ($workout->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $workoutExercise = new WorkoutExercise();
        $workoutExercise->setWorkout($workout);

        $form = $this->createForm(WorkoutExerciseFormType::class, $workoutExercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($workoutExercise);
            $entityManager->flush();

            $this->addFlash('success', 'Вправу успішно додано до тренування');
            return $this->redirectToRoute('app_workout_show', ['id' => $workout->getId()]);
        }

        return $this->render('workout/add_exercise.html.twig', [
            'form' => $form->createView(),
            'workout' => $workout,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_workout_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Workout $workout,
        EntityManagerInterface $entityManager
    ): Response
    {
        if ($workout->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        $form = $this->createForm(WorkoutFormType::class, $workout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Тренування успішно відредаговано');
            return $this->redirectToRoute('app_workout_index');
        }

        return $this->render('workout/edit.html.twig', [
            'form' => $form->createView(),
            'workout' => $workout,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_workout_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Workout $workout,
        EntityManagerInterface $entityManager
    ): Response
    {
        if ($workout->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        if ($this->isCsrfTokenValid('delete'.$workout->getId(), $request->request->get('_token'))) {
            foreach ($workout->getWorkoutExercises() as $exercise) {
                $entityManager->remove($exercise);
            }
            $entityManager->remove($workout);
            $entityManager->flush();

            $this->addFlash('success', 'Тренування успішно видалено');
        }
        return $this->redirectToRoute('app_workout_index');
    }
}
