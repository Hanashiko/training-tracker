<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;
    
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $usersData = [
            ['name' => 'user1', 'email' => 'user1@gmail.com', 'password' => '123'],
            ['name' => 'user2', 'email' => 'user2@gmail.com', 'password' => '123'],
        ];

        foreach ($usersData as $data) {
            $user = new User();
            $user->setName($data['name']);
            $user->setEmail($data['email']);

            $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
            $user->setPassword($hashedPassword);
            
            $manager->persist($user);
        }
    }
}
