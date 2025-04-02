<?php

namespace App\Controller;

use App\Entity\Workout;
use App\Form\WorkoutType;
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

        $form = $this->createForm(WorkoutType::class, $workout);
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
}
