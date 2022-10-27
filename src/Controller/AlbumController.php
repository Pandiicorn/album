<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/album')]
class AlbumController extends AbstractController
{

    #[Route('/', name: 'app_album', methods: ['GET'])]
    public function index(AlbumRepository $repository): Response
    {
        return $this->render('pages/album/index.html.twig', [
            'albums' => $repository->findBy(['user' => $this->getUser()])
        ]);
    }

    #[Route('/new', name: 'app_album_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $album = $form->getData();

            $manager->persist($album);
            $manager->flush();

            $this->addFlash('success', 'Your album has been created !');

            return $this->redirectToRoute('app_album');
        }

        return $this->render('pages/album/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}', name: 'app_album_show', methods: ['GET'])]
    public function show(Album $album): Response
    {
        return $this->render('pages/album/show.html.twig', [
            'album' => $album
        ]);
    }

    #[Route('/{id}/edit', name: 'app_album_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Album $album, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $album = $form->getData();

            $manager->persist($album);
            $manager->flush();

            return $this->redirectToRoute('app_album', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/album/edit.html.twig', [
            'album' => $album,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_album_delete', methods: ['GET'])]
    public function delete(Album $album, EntityManagerInterface $manager): Response
    {
        $manager->remove($album);
        $manager->flush();
        return $this->redirectToRoute('app_album', [], Response::HTTP_SEE_OTHER);
    }
}
