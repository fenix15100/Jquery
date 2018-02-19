<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Indaxia\OTR\ITransformable;
use \Indaxia\OTR\Traits\Transformable;
use \Indaxia\OTR\Annotations\Policy;

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







}
