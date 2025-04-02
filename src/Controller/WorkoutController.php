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
    public function index(WorkoutRepository $workoutRepository): Response
    {
        $workouts = $workoutRepository->findBy(['user' => $this->getUser()]);
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

    #[Route('/new1', name: 'app_workout_new1')]
    public function new1(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $workout = new Workout();
        $workout->setUser($this->getUser());

        $form = $this->createForm(WorkoutType::class, $workout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                if ($workout->getWorkoutExercises()->isEmpty()) {
                    throw new \InvalidArgumentException('Додайте хоча б одну вправу');
                }

                foreach ($workout->getWorkoutExercises() as $exercise) {
                    $exercise->setWorkout($workout);

                        // if ($exercise->getSets() <= 0 || $exercise->getReps() <= 0) {
                        //     throw new \InvalidArgumentException('Кількість підходів і повторень має бути більше 0');
                        // }
                }

                $entityManager->persist($workout);
                $entityManager->flush();

                    // $this->addFlash('success','Тренування успішно додано');
                return $this->redirectToRoute('app_workout_show', ['id' => $workout->getId()]);
            } catch (\Exception $e) {
                    // $this->addFlash('error', 'Помилка при збереженні: '.$e->getMessage());
                    // $entityManager->clear();
                    // $workout = new Workout();
                    // $workout->setUser($this->getUser());
                    // $form = $this->createForm(WorkoutType::class, $workout);
                $this->addFlash('error', 'Помилка при збереженні: '.$e->getMessage());
            }
        } else {
            foreach ($form->getErrors(true) as $error){
                $this->addFlash('error', $error->getMessage());
            }
            
        }
        return $this->render('workout/new.html.twig', [
            'form' => $form->createView(),
            'workout' => $workout,
        ]);
    }

    #[Route('/show', 'app_workout_show')]
    public function show(Workout $workout): Response
    {
        return $this->render('workout/show.html.twig', [
            'workout' => $workout,
        ]);
    }
}
