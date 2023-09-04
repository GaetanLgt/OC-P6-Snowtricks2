<?php

namespace App\DataFixtures;

use App\Entity\Media;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class MediaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $mediasData = [
            ['https://www.youtube.com/watch?v=7NOSDKb0HlU', 'video'],
            ['t705_V-RDcQ', 'tag'],
            ['snowboard.jpg', 'image'],
            ['snowboard-1.jpg', 'image'],
            ['snowboard-2.jpg', 'image'],
            ['snowboard-3.jpg', 'image'],
            ['snowboard-4.jpg', 'image'],
            ['snowboard-5.jpg', 'image']
        ];

        foreach ($mediasData as $key => $mediaData) {
            $mediaEntity = new Media();
            $mediaEntity->setUrl($mediaData[0]);
            $mediaEntity->setType($mediaData[1]);
            $manager->persist($mediaEntity);

            // Ajout d'une référence pour une utilisation ultérieure dans d'autres fixtures
            $this->addReference('media_' . $key, $mediaEntity);
        }

        $manager->flush();
    }
}
