<?php

namespace App\Controller;

use App\Entity\Workout;
use App\Repository\WorkoutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/workout')]
final class WorkoutController extends AbstractController
{
    #[Route('/', name: 'app_workout_index', methods: ['GET'])]
    public function index(WorkoutRepository $workoutRepository): Response
    {
        $workouts = $workoutRepository->findBy(['user' => $this->getUser()]);
        return $this->render('workout/index.html.twig', [
            'workouts' => $workouts,
        ]);
    }

    #[Route('/{id}', name: 'app_workout_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Workout $workout,
        EntityManagerInterface $entityManager
    ): Response
    {
        if ($this->isCsrfTokenValid('delete_exercise'.$workout->getId(), $request->request->get()))
    }
}
