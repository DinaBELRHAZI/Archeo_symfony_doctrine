<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImagesRepository::class)
 */
class Images
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",name="id_img")
     */
    private $id;

    /**
     * @ORM\Column(name="name",type="text", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="id_france",type="integer", length=255)
     */
    private $id_france ;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getIdFrance()
    {
        return $this->id_france;
    }

    /**
     * @param mixed $id_france
     */
    public function setIdFrance($id_france): void
    {
        $this->id_france = $id_france;
    }

}
