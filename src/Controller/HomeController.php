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
        $tricks = $entityManager->getRepository(Trick::class)->findBy([], ['id' => 'DESC'], 18);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'tricks' => $tricks,
        ]);
    }

    #[Route('/{id}', name: 'app_trick_show', methods: ['GET'])]
    public function home(EntityManagerInterface $entityManager, $id): Response
    {
        // query qui récupère les 25 tricks suivants en fonction de l'id
        $tricks = $entityManager->getRepository(Trick::class)->findBy(['id' =>  $id ], ['id' => 'DESC'], 25);
        return $this->json([
            'tricks' => $tricks,
        ]);
    }


}
