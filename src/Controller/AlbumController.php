<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/album')]
class AlbumController extends AbstractController
{

    #[Route('/', name: 'app_album', methods: ['GET'])]
    public function index(AlbumRepository $repository): Response
    {
        return $this->render('pages/album/index.html.twig', [
            'albums' => $repository->findAll()
        ]);
    }
}
