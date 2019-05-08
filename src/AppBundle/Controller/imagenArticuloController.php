<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Imagenarticulo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * ImagenArticulo controller.
 *
 * @Route("imagenarticulo")
 */
class ImagenArticuloController extends Controller
{
    /**
     * Lists all imagenarticulo entities.
     *
     * @Route("/", name="imagenarticulo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $imagenarticulos = $em->getRepository('AppBundle:Imagenarticulo')->findAll();

        return $this->render('imagenarticulo/index.html.twig', array(
            'imagenarticulos' => $imagenarticulos,
        ));
    }
}
