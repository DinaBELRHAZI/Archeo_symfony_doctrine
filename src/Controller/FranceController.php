<?php

namespace App\Controller;

use App\Entity\France;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\FunctionConvert;
use Knp\Component\Pager\PaginatorInterface;

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


    //Liste de tout les sites de fouille de France

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


    //Affichage des informations d'un site à partir de son id

    /**
     * @Route("/france/liste/site/{id}", name="OneSite", requirements={"id"="\d+"},methods={"GET"})
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


// Maps

    /**
     * @Route("/france/convert", name="listeFranceConvert" )
     */
    public function listeFranceConvert()
    {

        $repo=$this->getDoctrine()->getRepository(France::class);
        $listAllFrance= $repo->findAll();
        //$listAllFrance= $repo->findBy(array(),array('id'=>'DESC'),10, 0);

        $tableaux = array();

        foreach ($listAllFrance as $lieu)
        {
            $tableau = array();
            //convertion des coordonées Lambert en WGS84
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


    //Formulaire de création de site

    /**
     * @Route("/france/site/new", name="creerSite" )
     */
    public function creationSite()
    {
        //dd("toto");
        return $this->render('france/newSite_2.html.twig', [
            'controller_name' => 'FranceController',
            'titre' => "Création d'un nouveau site"
        ]);
    }

    /**
     * @Route("/france/newSite", name="newSite", methods={"POST"})
     */
    public function createOneSite(Request $request)
    {


        $request->request;

        $entityManager = $this->getDoctrine()->getManager();

        $site = new France();
        $site->setLambertX($request->request->get('Lambert_X'));
        $site->setLambertY($request->request->get('Lambert_Y'));
        $site->setRegion($request->request->get('Region'));
        $site->setDepartement($request->request->get('Departement'));
        $site->setCommune($request->request->get('Commune'));
        $site->setNomDuSite($request->request->get('Nom_du_site'));
        $site->setDateDebut($request->request->get('Date_debut'));
        $site->setDateFin($request->request->get('Date_fin'));
        $site->setPeriodes($request->request->get('Periodes'));
        $site->setThemes($request->request->get('Themes'));
        $site->setTypeIntervention($request->request->get('Type_intervention'));

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($site);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response($site->getId());



    }

}
