<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaisesRepository")
 */
class Paises
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=2)
     */
    private $iso;

    /**
     *
     * @ORM\Column(type="string",length=120)
     */
    private $pais;



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Paises
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param mixed $pais
     * @return Paises
     */
    public function setPais($pais)
    {
        $this->pais = $pais;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * @param mixed $iso
     */
    public function setIso($iso)
    {
        $this->iso = $iso;
    }




    /**
     * @ORM\OneToMany(targetEntity="Variedades", mappedBy="id_pais")
     */
    private $variedades;
    public function __construct()
    {
        $this->variedades = new \Doctrine\Common\Collections\ArrayCollection();
    }
    public function addVariedades(Variedades $variedad)
    {
        $this->variedades[] = $variedad;
    }
    public function SetVariedades(\Doctrine\Common\Collections\ArrayCollection $variedad)
    {
        $this->variedades[] = $variedad;
        return $this;
    }

    public function getVariedades()
    {
        return $this->variedades;
    }


}
