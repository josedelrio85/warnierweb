<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subarticulo
 *
 * @ORM\Table(name="Subarticulo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubarticuloRepository")
 */
class Subarticulo
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
     * @ORM\Column(name="titulo", type="string", length=255, nullable=true)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="contenido", type="text", nullable=true)
     */
    private $contenido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="string", length=255, nullable=true)
     */
    private $video;

    /**
     * @var string
     *
     * @ORM\Column(name="documento", type="string", length=255, nullable=true)
     */
    private $documento;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;

    /**
     * @ORM\OneToOne(targetEntity="Articulo", inversedBy="subarticulo")
     * @ORM\JoinColumn(name="idArticulo", referencedColumnName="id" )
     */
    private $idArticulo;   
    
    /**
     * @ORM\OneToOne(targetEntity="recAsociado", mappedBy="idSubarticulo", cascade={"persist"})
     */
    private $recAsociado;
    
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
     * @return Subarticulo
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
     * Set contenido
     *
     * @param string $contenido
     *
     * @return Subarticulo
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Subarticulo
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
     * Set video
     *
     * @param string $video
     *
     * @return Subarticulo
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set documento
     *
     * @param string $documento
     *
     * @return Subarticulo
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return string
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Subarticulo
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
     * Set idArticulo
     *
     * @param integer $idArticulo
     *
     * @return Subarticulo
     */
    public function setIdArticulo($idArticulo)
    {
        $this->idArticulo = $idArticulo;

        return $this;
    }

    /**
     * Get idArticulo
     *
     * @return int
     */
    public function getIdArticulo()
    {
        return $this->idArticulo;
    }

    /**
     * Set recAsociado
     *
     * @param \AppBundle\Entity\recAsociado $recAsociado
     *
     * @return Subarticulo
     */
    public function setRecAsociado(\AppBundle\Entity\recAsociado $recasociado = null)
    {
        $this->recAsociado = $recasociado;

        return $this;
    }

    /**
     * Get recAsociado
     *
     * @return \AppBundle\Entity\recAsociado
     */
    public function getRecAsociado()
    {
        return $this->recAsociado;
    }
}
