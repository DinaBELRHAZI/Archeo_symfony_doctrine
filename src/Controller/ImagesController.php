<?php

namespace App\Controller;

use App\Repository\ImagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImagesController extends AbstractController
{
    /**
     * @Route("/images", name="images")
     */
    public function index(ImagesRepository $repoImage): Response
    {
        dd($repoImage->findAll());
        return $this->render('images/index.html.twig', [
            'controller_name' => 'ImagesController',
        ]);
    }
}
