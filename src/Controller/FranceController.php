<?php

namespace App\Controller;

use App\Entity\France;
use App\Entity\Images;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\FunctionConvert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @Route("/france/liste/site/{id}/photos", name="OneSitePhotos", requirements={"id"="\d+"},methods={"GET"})
     */
    public function OneSitePhotos($id)
    {
        $repo=$this->getDoctrine()->getRepository(France::class);
        $oneSite= $repo->find($id);

        return $this->render('france/listeFranceOneSitePhotos.html.twig', [
            'controller_name' => 'FranceController',
            'titre' => 'Un site',
            'oneSite' => $oneSite
            /*'tableau' => $tableaux*/
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



    /* Formulaire d'ajout de photos */


    /**
     * @Route("/france/liste/site/{id}/photos/ajout", name="OneSitePhotosAjout", requirements={"id"="\d+"},methods={"GET"})
     */
    public function OneSitePhotosAjout($id)
    {
        $repo=$this->getDoctrine()->getRepository(France::class);
        $oneSite= $repo->find($id);

        return $this->render('france/listeFranceOneSitePhotosForm.html.twig', [
            'controller_name' => 'FranceController',
            'titre' => 'Un site',
            'oneSite' => $oneSite
        ]);
    }


    /**
     * @Route("/france/liste/site/photos/add", name="OneSitePhotosAdd", methods={"POST"})
     */
    public function OneSitePhotosAdd(Request $request)
    {
        $request->files;
        $request->request;
        //dd($request->files);

        $entityManager = $this->getDoctrine()->getManager();

        $img = new Images();

        $uploadedFile = $request->files->get('name');
        $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
        $newFilename = uniqid().'-'.$uploadedFile->getClientOriginalName();
        //dd($uploadedFile->move($destination));
        $uploadedFile->move(
            $destination,
            $newFilename
        );

        $img->setName($newFilename);
        $img->setIdFrance($request->request->get('id_france'));

        //$img->$request->files->get('name');
        //$img->setIdFrance($request->request->get('id_france'));



        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($img);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('OneSitePhotos');
    }



    //Formulaire de modification d'un site

    /**
     * @Route("/france/site/update/{id}", name="updateSite" , requirements={"id"="\d+"},methods={"GET"})
     */
    public function updateSite($id)
    {
        $repo=$this->getDoctrine()->getRepository(France::class);
        $oneSite= $repo->find($id);

        $tableaux = array();
        $tableau = array();

        $tableau = FunctionConvert::lambert93ToWgs84($oneSite->getLambertX(), $oneSite->getLambertY());
        $tableaux[] =  [$oneSite, $tableau['wgs84']['lat'],$tableau['wgs84']['long']];

        return $this->render('france/updateSite.html.twig', [
            'controller_name' => 'FranceController',
            'titre' => 'Un site',
            'oneSite' => $oneSite,
            'tableau' => $tableaux
        ]);
    }

    /**
     * @Route("/france/updateSite/{id}", name="modifSite" , requirements={"id"="\d+"}, methods={"POST"})
     */
    public function updateOneSite(Request $request, $id)
    {


        $request->request;

        $entityManager = $this->getDoctrine()->getManager();
        $site = $entityManager->getRepository(France::class)->find($id);

        //$site = new France();
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

        //return new Response($site->getId());
        return $this->redirectToRoute('listAllFrance');

    }

}
