<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity(repositoryClass="App\Repository\VariedadesRepository")
 */
class Variedades
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string",length=120)
     */
    private $nombre;


    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $tiempo_floracion;


    /**
     * @ORM\Column(type="boolean")
     */
    private $interior;

    /**
     * @ORM\Column(type="boolean")
     */

    private $exterior;


    /**
     * @ORM\Column(type="decimal",scale=2,nullable=true)
     */
    private $THC;

    /**
     * @ORM\Column(type="decimal",scale=2,nullable=true)
     */
    private $CBD;


    /**
     * @ORM\Column(type="string",length=120,nullable=true)
     */
    private $genetica;


    /**
     * @ORM\Column(type="integer")
     */

    /**
     * @ORM\ManyToOne(targetEntity="Tipos")
     * @ORM\JoinColumn(name="id_tipo", referencedColumnName="id",onDelete="CASCADE")
     */
    private $id_tipo;


    /**
     * @ORM\Column(type="integer")
     *
     */

    /**
     * @ORM\ManyToOne(targetEntity="Paises")
     * @ORM\JoinColumn(name="id_pais", referencedColumnName="id",onDelete="CASCADE")
     */
    private $id_pais;

    /**
     * @ORM\Column(type="text",nullable=true)
     */

    private $description;


    /**
     * @ORM\Column(type="string",length=150,nullable=true)
     */
    private $file;




    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Variedades
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     * @return Variedades
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTiempoFloracion()
    {
        return $this->tiempo_floracion;
    }

    /**
     * @param mixed $tiempo_floracion
     * @return Variedades
     */
    public function setTiempoFloracion($tiempo_floracion)
    {
        $this->tiempo_floracion = $tiempo_floracion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInterior()
    {
        return $this->interior;
    }

    /**
     * @param mixed $interior
     * @return Variedades
     */
    public function setInterior($interior)
    {
        $this->interior = $interior;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExterior()
    {
        return $this->exterior;
    }

    /**
     * @param mixed $exterior
     * @return Variedades
     */
    public function setExterior($exterior)
    {
        $this->exterior = $exterior;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTHC()
    {
        return $this->THC;
    }

    /**
     * @param mixed $THC
     * @return Variedades
     */
    public function setTHC($THC)
    {
        $this->THC = $THC;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCBD()
    {
        return $this->CBD;
    }

    /**
     * @param mixed $CBD
     * @return Variedades
     */
    public function setCBD($CBD)
    {
        $this->CBD = $CBD;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGenetica()
    {
        return $this->genetica;
    }

    /**
     * @param mixed $genetica
     * @return Variedades
     */
    public function setGenetica($genetica)
    {
        $this->genetica = $genetica;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdTipo()
    {
        return $this->id_tipo;
    }

    /**
     * @param mixed $id_tipo
     * @return Variedades
     */
    public function setIdTipo($id_tipo)
    {
        $this->id_tipo = $id_tipo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPais()
    {
        return $this->id_pais;
    }

    /**
     * @param mixed $id_pais
     * @return Variedades
     */
    public function setIdPais($id_pais)
    {
        $this->id_pais = $id_pais;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }














}
