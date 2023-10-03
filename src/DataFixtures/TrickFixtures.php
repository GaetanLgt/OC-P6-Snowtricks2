<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TrickFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $tricks = [
            [
                'name' => 'Mute',
                'description' => 'Saisie de la carre frontside de la planche entre les deux pieds avec la main avant.',
                'categorie' => ['Grabs'],
                'media' => ['media_6', 'media_1', 'media_2'],
            ],
            [
                'name' => 'Sad',
                'description' => 'Saisie de la carre backside de la planche, entre les deux pieds, avec la main avant.',
                'categorie' => ['Grabs', 'Rotations'],
                'media' => ['media_6', 'media_1', 'media_2','media_3', 'media_4', 'media_5'],
            ],
            [
                'name' => 'Indy',
                'description' => 'Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière.',
                'categorie' => ['Rotations'],
                'media' => ['media_3', 'media_4', 'media_5','media_6', 'media_7', 'media_2'],
            ],
            [
                'name' => 'Stalefish',
                'description' => 'Saisie de la carre backside de la planche entre les deux pieds avec la main arrière.',
                'categorie' => ['Old school'],
                'media' => ['media_3', 'media_4', 'media_5'],
            ],
            [
                'name' => 'Tail grab',
                'description' => 'Saisie de la partie arrière de la planche, avec la main arrière.',
                'categorie' => ['Old school'],
                'media' => ['media_6', 'media_1', 'media_2'],
            ],
            [
                'name' => 'Nose grab',
                'description' => 'Saisie de la partie avant de la planche, avec la main avant.',
                'categorie' => ['Slides'],
                'media' => ['media_6', 'media_1', 'media_2','media_3', 'media_4', 'media_5']
            ],
            [
                'name' => 'Seat belt',
                'description' => 'Saisie du carre frontside à l\'arrière avec la main avant.',
                'categorie' => ['Old school', 'Rotations désaxées'],
                'media' => ['media_3', 'media_4', 'media_5'],
            ],
            [
                'name' => 'Japan air',
                'description' => 'Saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside.',
                'categorie' => ['Rotations désaxées'],
                'media' =>  ['media_4', 'media_1', 'media_2'],
            ],
            [
                'name' => 'Truck driver',
                'description' => 'Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture).',
                'categorie' => ['Rotations désaxées'],
                'media' => ['media_6', 'media_1', 'media_2'],
            ],
            [
                'name' => 'Seat belt',
                'description' => 'Saisie du carre frontside à l\'arrière avec la main avant.',
                'categorie' => ['Old school', 'Rotations désaxées'],
                'media' => ['media_3', 'media_4', 'media_5'],
            ],
            [
                'name' => '360 désaxé',
                'description' => 'Trois six désaxé.',
                'categorie' => ['Rotations désaxées'],
                'media' => ['media_6', 'media_1', 'media_2'],
            ],
            [
                'name' => 'One foot',
                'description' => 'Figure réalisée avec un seul pied fixé sur la planche.',
                'categorie' => ['One foot tricks'],
                'media' => ['media_3', 'media_4', 'media_5'],
            ]
        ];

        foreach ($tricks as $trickKey => $figure) {
            $trick = new Trick();
            $trick->setName($figure['name']);
            $trick->setDescription($figure['description']);
        
            foreach ($figure['categorie'] as $category) {
                $categoryEntity = $this->getReference('categorie_' . $category);
                $trick->addCategory($categoryEntity);
            }
        
            foreach ($figure['media'] as $mediaKey) {
                $mediaEntity = $this->getReference($mediaKey);
                $trick->addMedium($mediaEntity);
            }
        
            $thumbnail = $this->getReference($figure['media'][0])->getUrl();
            $trick->setThumbnail($thumbnail);
        
            $trick->setSlug($this->generateSlug($figure['name']));  
            $manager->persist($trick);
            
            $this->addReference('trick_' . $trickKey, $trick);
        }
        

        $manager->flush();
    }

    public function generateSlug($title)
    {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }
}
