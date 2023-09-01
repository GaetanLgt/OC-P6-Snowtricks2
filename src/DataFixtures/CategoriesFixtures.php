<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categoryNames = [
            'Grabs',
            'Rotations',
            'Flips',
            'Rotations désaxées',
            'Slides',
            'One foot tricks',
            'Old school',
            'Grab désaxés',
            'Autres'
        ];

        foreach ($categoryNames as $name) {
            $categoryEntity = new Categorie();
            $categoryEntity->setName($name);
            $manager->persist($categoryEntity);

            // Ajout d'une référence pour une utilisation ultérieure dans d'autres fixtures
            $this->addReference('categorie_' . $name, $categoryEntity);
        }

        $manager->flush();
    }
}
