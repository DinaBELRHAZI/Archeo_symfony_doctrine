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
        $list = array();
        $test1 = array();

        //var_dump($listAllFrance);
        foreach ($listAllFrance as $lieu)
        {
            $tableau = array();
            $tableau = FunctionConvert::lambert93ToWgs84($lieu->getLambertX(), $lieu->getLambertY());

            $test1[] =  [$lieu, $tableau['wgs84']['lat'],$tableau['wgs84']['long']];


        }
        //dd($test1);
        //$list[] =[$listAllFrance, $test1];
        //dd($list);

        //dd($test1);
        return $this->render('france/maps.html.twig', [
            'controller_name' => 'FranceController',
            'titre' => 'Liste de tous les sites de fouilles achéologiques de france',
            'listAllFrance' => $listAllFrance,
            'tableau' => $test1,
            'list'=> $list

        ]);
    }

    /**
     * @Route("/france/maps", name="listFranceMaps" )
     */
    public function listFranceMaps()
    {

        $repo=$this->getDoctrine()->getRepository(France::class);
        $listAllFrance= $repo->findAll();

        //var_dump($listAllFrance);
        //die();
        return $this->render('france/maps.html.twig', [
            'controller_name' => 'FranceController',
            'titre' => 'lite de tous les sites achéologiques de france',
            'listAllFrance' => $listAllFrance
        ]);
    }


}
