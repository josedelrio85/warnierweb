<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Articulo
 *
 * @ORM\Table(name="Articulo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticuloRepository")
 */
class Articulo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=50, nullable=true)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="contenidoBreve", type="text", nullable=true)
     */
    private $contenidoBreve;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="rutaImagen", type="string", length=255, nullable=true)
     */
    private $rutaImagen;

    /**
     * @var int
     *
     * @ORM\Column(name="mostrar", type="integer", nullable=true)
     */
    private $mostrar;

    /**
     * @ORM\ManyToOne(targetEntity="Seccion")
     * @ORM\JoinColumn(name="idSeccion", referencedColumnName="id")
     */
    private $idSeccion;

    
    /**
     * @ORM\OneToMany(targetEntity="Imagenarticulo", mappedBy="idArticulo", cascade={"persist"})
     */
    private $imagenes;
    
    
    /**
     * @ORM\OneToOne(targetEntity="Subarticulo", mappedBy="idArticulo", cascade={"persist"})
     */
    private $subarticulo;
    
    
    public function __construct() {
        $this->imagenes = new ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Articulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set contenidoBreve
     *
     * @param string $contenidoBreve
     *
     * @return Articulo
     */
    public function setContenidoBreve($contenidoBreve)
    {
        $this->contenidoBreve = $contenidoBreve;

        return $this;
    }

    /**
     * Get contenidoBreve
     *
     * @return string
     */
    public function getContenidoBreve()
    {
        return $this->contenidoBreve;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Articulo
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Articulo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return bool
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Articulo
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set rutaImagen
     *
     * @param string $rutaImagen
     *
     * @return Articulo
     */
    public function setRutaImagen($rutaImagen)
    {
        $this->rutaImagen = $rutaImagen;

        return $this;
    }

    /**
     * Get rutaImagen
     *
     * @return string
     */
    public function getRutaImagen()
    {
        return $this->rutaImagen;
    }

    /**
     * Set mostrar
     *
     * @param integer $mostrar
     *
     * @return Articulo
     */
    public function setMostrar($mostrar)
    {
        $this->mostrar = $mostrar;

        return $this;
    }

    /**
     * Get mostrar
     *
     * @return int
     */
    public function getMostrar()
    {
        return $this->mostrar;
    }

    /**
     * Set idSeccion
     *
     * @param integer $idSeccion
     *
     * @return Articulo
     */
    public function setIdSeccion($idSeccion)
    {
        $this->idSeccion = $idSeccion;

        return $this;
    }

    /**
     * Get idSeccion
     *
     * @return int
     */
    public function getIdSeccion()
    {
        return $this->idSeccion;
    }
    
    /**
     * Get imagenes
     *
     * @return ArrayCollection
     */
    public function getImagenes()
    {
        return $this->imagenes;
    }
    
    /**
     * Set imagenes
     *
     * @param Imagenarticulo
     * 
     * @return Articulo
     */
    public function setImagenes($imagenArticulo)
    {
        $this->imagenes = $imagenArticulo;
        return $this;
    }
    
    /**
     * Get subarticulo
     *
     * @return Subarticulo
     */
    public function getSubarticulo()
    {
        return $this->subarticulo;
    }
    
    /**
     * Set subarticulo
     *
     * @param Subarticulo
     * 
     * @return Articulo
     */
    public function setSubarticulo($subarticulo)
    {
        $this->subarticulo = $subarticulo;
        return $this;
    }
}

