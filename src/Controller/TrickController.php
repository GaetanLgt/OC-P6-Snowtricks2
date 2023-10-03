<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Trick;
use App\Form\TrickType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\File\FileUploaderService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/trick')]
class TrickController extends AbstractController
{
    private $fileUploader;

    public function __construct(FileUploaderService $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }
    
    #[Route('/', name: 'app_trick_index', methods: ['GET'])]
    public function index(TrickRepository $trickRepository): Response
    {
        return $this->render('trick/index.html.twig', [
            'tricks' => $trickRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_trick_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trick);
            $entityManager->flush();
            $this->addFlash(
               'success',
               'Votre trick a bien été ajouté'
            );
            return $this->redirectToRoute('app_trick_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_trick_show', methods: ['GET','POST'])]
    public function show( EntityManagerInterface $entityManager, Request $request, string $slug): Response
    {
        $trick = $entityManager->getRepository(Trick::class)->findOneBy(['slug' => $slug]);
        $commentaires = $trick->getCommentaires();

        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $this->getUser()->getId()]);
            $commentaire->setTrick($trick);
            $commentaire->setPublishedAt(new \DateTimeImmutable());
            $commentaire->setImageProfilAuteur($user->getImageProfil() ? $user->getImageProfil() : '');
            $commentaire->setPseudoAuteur($user->getPseudo());
            $entityManager->persist($commentaire);
            $entityManager->flush();
        }
        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'commentaires' => $commentaires,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_trick_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, string $slug): Response
    {
        $trick = $entityManager->getRepository(Trick::class)->findOneBy(['slug' => $slug]);
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            if($form->get('thumbnail')->getData() !== null) {
                $file = $form->get('thumbnail')->getData();
            if ($file) {
                $fileName = $this->fileUploader->upload($file, '', null);
                $trick->setThumbnail($fileName);
                $entityManager->persist($trick);
                $entityManager->flush();
            }
                
            }
            $this->addFlash(
               'success',
               'Votre trick a bien été modifié'
            );  
            return $this->redirectToRoute('app_trick_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_trick_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $entityManager, string $slug): Response
    {
        $trick = $entityManager->getRepository(Trick::class)->findOneBy(['slug' => $slug]);
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $entityManager->remove($trick);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_trick_index', [], Response::HTTP_SEE_OTHER);
    }

    public function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}
