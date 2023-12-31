<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('Nicolas');
        $user->setEmail('nico@nico.com');
        $user->setRoles(['ROLE_USER']);
        $password = 'plop';
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $user = new User();
        $user->setUsername('Sabrina');
        $user->setEmail('sabrina@nico.com');
        $user->setRoles(['ROLE_USER']);
        $password = "je t'aime";
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $manager->flush();
    }
}
