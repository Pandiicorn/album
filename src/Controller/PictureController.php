<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Form\PictureType;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/picture')]
class PictureController extends AbstractController
{
    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function index(PictureRepository $repository): Response
    {
        return $this->render('pages/picture/index.html.twig', [
            'pictures' => $repository->findBy(['user' => $this->getUser()])
        ]);
    }

    #[Route('/index', name: 'app_picture_index', methods: ['GET'])]
    public function pic(PictureRepository $repository): Response
    {
        return $this->render('pages/picture/picture_index.html.twig', [
            'pictures' => $repository->findBy(['user' => $this->getUser()])
        ]);
    }

    #[Route('/new', name: 'app_picture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $picture = new Picture();
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->getdata();
            $picture->setUser($this->getUser());

            $manager->persist($picture);
            $manager->flush();

            $this->addFlash('success', 'Your picture has been added !');

            return $this->redirectToRoute('app_picture_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/picture/new.html.twig', [
            'picture' => $picture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_picture_show', methods: ['GET'])]
    public function show(Picture $picture): Response
    {
        return $this->render('pages/picture/show.html.twig', [
            'picture' => $picture,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_picture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Picture $picture, PictureRepository $pictureRepository): Response
    {
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureRepository->save($picture, true);

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/picture/edit.html.twig', [
            'picture' => $picture,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_picture_delete', methods: ['GET'])]
    public function delete(Picture $picture, EntityManagerInterface $manager): Response
    {
        $manager->remove($picture);
        $manager->flush();

        return $this->redirectToRoute('app_picture_index', [], Response::HTTP_SEE_OTHER);
    }
}
