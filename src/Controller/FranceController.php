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

        return $this->render('france/listeFranceAll.html.twig', [
            'controller_name' => 'FranceController',
            'titre' => 'lite de tous les sites achéologiques de france',
            'listAllFrance' => $listAllFrance
        ]);
    }


    /**
     * @Route("/liste/site/{id}", name="OneSite", requirements={"id"="\d+"},methods={"GET"})
     */
    public function indexoneSite($id)
    {
        $repo=$this->getDoctrine()->getRepository(France::class);
        $oneSite= $repo->find($id);

        $tableaux = array();
        $tableau = array();

        $tableau = FunctionConvert::lambert93ToWgs84($oneSite->getLambertX(), $oneSite->getLambertY());
        $tableaux[] =  [$oneSite, $tableau['wgs84']['lat'],$tableau['wgs84']['long']];


        return $this->render('france/listeFranceOneSite.html.twig', [
            'controller_name' => 'FranceController',
            'titre' => 'Un site',
            'oneSite' => $oneSite,
            'tableau' => $tableaux
        ]);
    }


    /**
     * @Route("/france/apiJson", name="listAllFranceJson" )
     */
    public function listeFranceJson()
    {
        $repo=$this->getDoctrine()->getRepository(France::class);
        $listAllFrance= $repo->findAll();

        return $this->json($listAllFrance);
    }



    /**
     * @Route("/france/convert", name="listeFranceConvert" )
     */
    public function listeFranceConvert()
    {

        $repo=$this->getDoctrine()->getRepository(France::class);
        //$listAllFrance= $repo->findAll();
        $listAllFrance= $repo->findBy(array(),array('id'=>'DESC'),10, 0);

        $tableaux = array();

        foreach ($listAllFrance as $lieu)
        {
            $tableau = array();
            $tableau = FunctionConvert::lambert93ToWgs84($lieu->getLambertX(), $lieu->getLambertY());
            $tableaux[] =  [$lieu, $tableau['wgs84']['lat'],$tableau['wgs84']['long']];
        }
        return $this->render('france/maps.html.twig',  [
            'controller_name' => 'FranceController',
            'titre' => 'Liste de tous les sites de fouilles achéologiques de france',
            'listAllFrance' => $listAllFrance,
            'tableau' => $tableaux


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
