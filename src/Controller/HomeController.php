<?php

namespace App\Controller;

use App\Entity\Trick;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        // query qui récupère les 18 premiers tricks
        $tricks = $entityManager->getRepository(Trick::class)->findBy([], ['id' => 'ASC'], 8);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'tricks' => $tricks,
        ]);
    }

    #[Route('/{slug}', name: 'app_trick_show', methods: ['GET'])]
    public function home(EntityManagerInterface $entityManager, string $slug): Response
    {
        // query qui récupère les 25 tricks suivants en fonction de l'id
        $tricks = $entityManager->getRepository(Trick::class)->findBy(['slug' => $slug], ['id' => 'ASC'], 8);

        return $this->json([
            'tricks' => $tricks,
        ]);
    }

    #[Route('/loadmore/{offset}', name: 'app_load_more', methods: ['GET'])]
    public function loadMore(EntityManagerInterface $entityManager, $offset): Response
    {
        $tricks = $entityManager->getRepository(Trick::class)->findBy([], ['id' => 'ASC'], 4, $offset );
        
        $tricksArray = array_map(function ($trick) {
            // Convertissez chaque Trick en tableau
            // Remplacez par votre logique de conversion
            return [
                'id' => $trick->getId(),
                'name' => $trick->getName(),
                'description' => $trick->getDescription(),
                'thumbnail' => $trick->getThumbnail(),
                'slug' => $trick->getSlug(),
            ];
        }, $tricks);

        return $this->json([
            'data' => $tricksArray,
        ]);
    }
}
