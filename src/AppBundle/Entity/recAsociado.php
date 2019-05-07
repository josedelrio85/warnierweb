<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subarticulo
 *
 * @ORM\Table(name="recAsociado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\recAsociadoRepository")
 */
class recAsociado
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
     * @ORM\OneToOne(targetEntity="Subarticulo", inversedBy="recAsociado")
     * @ORM\JoinColumn(name="idSubarticulo", referencedColumnName="id" )
     */
    private $idSubarticulo;

    /**
     * Get id
     *
     * @return integer
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
     * @return recAsociado
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
     * @return recAsociado
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
     * @return recAsociado
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
     * Set documento
     *
     * @param string $documento
     *
     * @return recAsociado
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
     * @return recAsociado
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set idSubarticulo
     *
     * @param \AppBundle\Entity\Subarticulo $idSubarticulo
     *
     * @return recAsociado
     */
    public function setIdSubarticulo(\AppBundle\Entity\Subarticulo $idSubarticulo = null)
    {
        $this->idSubarticulo = $idSubarticulo;

        return $this;
    }

    /**
     * Get idSubarticulo
     *
     * @return \AppBundle\Entity\Subarticulo
     */
    public function getIdSubarticulo()
    {
        return $this->idSubarticulo;
    }
}
