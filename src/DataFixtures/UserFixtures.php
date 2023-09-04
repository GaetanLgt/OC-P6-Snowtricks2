<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $userData = [
            [
                'username' => 'admin',
                'email' => 'gtn.langlet@gmail.com',
                'password' => 'admin',
                'roles' => ['ROLE_ADMIN'],
            ],
            [
                'username' => 'user',
                'email' => 'testSnowtricksBeta@yopmail.com',
                'password' => 'user',
                'roles' => ['ROLE_USER'],
            ],
        ];

        foreach ($userData as $key => $data) {
            $user = new User();
            $user->setPseudo($data['username'])
                 ->setEmail($data['email'])
                 ->setPassword($this->userPasswordHasher->hashPassword($user, $data['password']))
                 ->setRoles($data['roles']);

            $manager->persist($user);
            $this->addReference('user_' . $key, $user);
        }

        $manager->flush();
    }
}
