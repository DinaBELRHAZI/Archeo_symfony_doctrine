<?php

namespace App\Controller;

use App\Entity\France;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\FunctionConvert;

class FranceController extends AbstractController
{
    /**
     * @Route("/france", name="france")
     */
    public function index(): Response
    {
        return $this->render('france/index.html.twig', [
            'controller_name' => 'FranceController',
        ]);
    }


    /**
     * @Route("/france/liste", name="listAllFrance" )
     */
    public function listeFranceAll()
    {

        $repo=$this->getDoctrine()->getRepository(France::class);
        $listAllFrance= $repo->findAll();

        //var_dump($listAllFrance);
        //die();
        return $this->render('france/listeFranceAll.html.twig', [
            'controller_name' => 'FranceController',
            'titre' => 'lite de tous les sites achéologiques de france',
            'listAllFrance' => $listAllFrance
        ]);
    }


    /**
     * @Route("/france/apiJson", name="listAllFranceJson" )
     */
    public function listeFranceJson()
    {

        $repo=$this->getDoctrine()->getRepository(France::class);
        $listAllFrance= $repo->findAll();

        //var_dump($listAllFrance);
        //die();
        return $this->json($listAllFrance);
    }

    /**
     * @Route("/france/convert", name="listeFranceConvert" )
     */
    public function listeFranceConvert()
    {

        $repo=$this->getDoctrine()->getRepository(France::class);
        $listAllFrance= $repo->findAll();

        //var_dump($listAllFrance);
        foreach ($listAllFrance as $lieu)
        {
            echo "<pre>";
            //var_dump($lieu);
            echo $lieu->getId();
            echo '<br>';
            echo $lieu->getNomdusite();
            echo '<br>';
            echo $lieu->getLambertX();
            echo '<br>';
            echo $lieu->getLambertY();
            echo '<br>';
            var_dump(FunctionConvert::lambert93ToWgs84($lieu->getLambertX(), $lieu->getLambertY()));
            echo '<br>';

            echo '<br>************************************<br>';
            $tableau = array();
            $tableau = FunctionConvert::lambert93ToWgs84($lieu->getLambertX(), $lieu->getLambertY());

            echo $tableau['wgs84']['lat'];
            echo '<br>';
            echo $tableau['wgs84']['long'];
            //var_dump($tableau);
            echo '<br><br>';

            echo "</pre>";
        }
        die();
        return $this->json($listAllFrance);
    }


}
