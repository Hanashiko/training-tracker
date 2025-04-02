<?php

namespace App\Controller;

use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
