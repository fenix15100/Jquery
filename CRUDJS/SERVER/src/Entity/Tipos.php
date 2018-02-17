<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TiposRepository")
 */
class Tipos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string" ,length=120,columnDefinition="ENUM('Hibrida_Mixta','Hibrida_Indica','Hibrida_Sativa','Sativa','Indica','Ruderalis','Legendaria')")
     */
    private $Tipo;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->Tipo;
    }

    /**
     * @param mixed $Tipo
     */
    public function setTipo($Tipo)
    {
        $this->Tipo = $Tipo;
    }



    /**
     * @ORM\OneToMany(targetEntity="Variedades", mappedBy="id_tipo")
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
