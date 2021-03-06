<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Imagenarticulo
 *
 * @ORM\Table(name="Imagenarticulo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImagenarticuloRepository")
 */
class Imagenarticulo
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
     * @ORM\Column(name="ruta", type="string", length=255, nullable=true)
     */
    private $ruta;

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
     * @ORM\ManyToOne(targetEntity="Articulo", inversedBy="imagenes")
     * @ORM\JoinColumn(name="idArticulo", referencedColumnName="id")
     */
    private $idArticulo;


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
     * Set ruta
     *
     * @param string $ruta
     *
     * @return Imagenarticulo
     */
    public function setRuta($ruta)
    {
        $this->ruta = $ruta;

        return $this;
    }

    /**
     * Get ruta
     *
     * @return string
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Imagenarticulo
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
     * @return Imagenarticulo
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
     * @return Imagenarticulo
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
}

