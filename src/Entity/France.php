<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FranceRepository")
 */
class France
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="Lambert_X",type="string", length=11)
     */
    private $Lambert_X;

    /**
     * @ORM\Column(name="Lambert_Y",type="string", length=255)
     */
    private $Lambert_Y;

    /**
     * @ORM\Column(name="Region",type="string", length=255)
     */
    private $Region;

    /**
     * @ORM\Column(name="Departement",type="string", length=255)
     */
    private $Departement;

    /**
     * @ORM\Column(name="Commune",type="string", length=255)
     */
    private $Commune;

    /**
     * @ORM\Column(name="Nom_du_site",type="string", length=255)
     */
    private $Nom_du_site;


    /**
     * @ORM\Column(name="Date_debut",type="string", length=255)
     */
    private $Date_debut;

    /**
     * @ORM\Column(name="Date_fin",type="string", length=255)
     */
    private $Date_fin;


    /**
     * @ORM\Column(name="Periodes",type="string", length=255)
     */
    private $Periodes;

    /**
     * @ORM\Column(name="Themes",type="string", length=278)
     */
    private $Themes;


    /**
     * @ORM\Column(name="Type_intervention",type="string", length=255)
     */
    private $Type_intervention;




    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLambertX()
    {
        return $this->Lambert_X;
    }

    /**
     * @param mixed $Lambert_X
     */
    public function setLambertX($Lambert_X): void
    {
        $this->Lambert_X = $Lambert_X;
    }

    /**
     * @return mixed
     */
    public function getLambertY()
    {
        return $this->Lambert_Y;
    }

    /**
     * @param mixed $Lambert_Y
     */
    public function setLambertY($Lambert_Y): void
    {
        $this->Lambert_Y = $Lambert_Y;
    }


    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->Region;
    }

    /**
     * @param mixed $Region
     */
    public function setRegion($Region): void
    {
        $this->Region = $Region;
    }

    /**
     * @return mixed
     */
    public function getDepartement()
    {
        return $this->Departement;
    }

    /**
     * @param mixed $Departement
     */
    public function setDepartement($Departement): void
    {
        $this->Departement = $Departement;
    }

    /**
     * @return mixed
     */
    public function getCommune()
    {
        return $this->Commune;
    }

    /**
     * @param mixed $Commune
     */
    public function setCommune($Commune): void
    {
        $this->Commune = $Commune;
    }

    /**
     * @return mixed
     */
    public function getNomDuSite()
    {
        return $this->Nom_du_site;
    }

    /**
     * @param mixed $Nom_du_site
     */
    public function setNomDuSite($Nom_du_site): void
    {
        $this->Nom_du_site = $Nom_du_site;
    }

    /**
     * @return mixed
     */
    public function getDateDebut()
    {
        return $this->Date_debut;
    }

    /**
     * @param mixed $Date_debut
     */
    public function setDateDebut($Date_debut): void
    {
        $this->Date_debut = $Date_debut;
    }

    /**
     * @return mixed
     */
    public function getDateFin()
    {
        return $this->Date_fin;
    }

    /**
     * @param mixed $Date_fin
     */
    public function setDateFin($Date_fin): void
    {
        $this->Date_fin = $Date_fin;
    }

    /**
     * @return mixed
     */
    public function getPeriodes()
    {
        return $this->Periodes;
    }

    /**
     * @param mixed $Periodes
     */
    public function setPeriodes($Periodes): void
    {
        $this->Periodes = $Periodes;
    }

    /**
     * @return mixed
     */
    public function getThemes()
    {
        return $this->Themes;
    }

    /**
     * @param mixed $Themes
     */
    public function setThemes($Themes): void
    {
        $this->Themes = $Themes;
    }

    /**
     * @return mixed
     */
    public function getTypeIntervention()
    {
        return $this->Type_intervention;
    }

    /**
     * @param mixed $Type_intervention
     */
    public function setTypeIntervention($Type_intervention): void
    {
        $this->Type_intervention = $Type_intervention;
    }
}
