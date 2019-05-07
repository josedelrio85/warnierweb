<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Articulo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\imagenArticulo;
use AppBundle\Entity\Subarticulo;
use AppBundle\Entity\Noticia;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Articulo controller.
 *
 */
class ArticuloController extends Controller {

    /**
     * Lists all articulo entities.
     *
     * @Route("/articulos", name="articulo_index")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $articulos = $em->getRepository('AppBundle:Articulo')->articulosCompletos();
        
        $paginator  = $this->get('knp_paginator');
        $request = Request::createFromGlobals();
        $pagination = $paginator->paginate(
            $articulos, /* query, NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        
        return $this->render('articulo/indexAdmin.html.twig', array(
                    //'articulos' => $articulos,
                    'articulos' => $pagination,
        ));
    }

    /**
     * Lists logistica articulo entities.
     *
     * @Route("/logistica", name="articulo_index_logistica")
     * @Method("GET")
     */
    public function indexLogisticaAction() {
        $articulos = $this->indexSeccionAction();
        
        return $this->render('articulo/index.html.twig', array(
                    'articulos' => $articulos,
                    'servicio' => 'Logística',
        ));
    }

    /**
     * Lists movilidad articulo entities.
     *
     * @Route("/movilidad", name="articulo_index_movilidad")
     * @Method("GET")
     */
    public function indexMovilidadAction() {
        $articulos = $this->indexSeccionAction();

        return $this->render('articulo/index.html.twig', array(
                    'articulos' => $articulos,
                    'servicio' => 'Movilidad',
        ));
    }

    /**
     * Lists hardware articulo entities.
     *
     * @Route("/hardware", name="articulo_index_hardware")
     * @Method("GET")
     */
    public function indexHardwareAction() {
        $articulos = $this->indexSeccionAction();

        return $this->render('articulo/index.html.twig', array(
                    'articulos' => $articulos,
                    'servicio' => 'Hardware Industrial',
        ));
    }

    /**
     * Lists noticias articulo entities.
     *
     * @Route("/noticias", name="articulo_index_noticias")
     * @Method("GET")
     */
    public function indexNoticiasAction() {
        $articulos = $this->indexSeccionAction();

        return $this->render('articulo/index.html.twig', array(
                    'articulos' => $articulos,
                    'servicio' => '',
                    'variable' => 'Últimas noticias de Warnier'
        ));
    }

    protected function indexSeccionAction() {

        $request = Request::createFromGlobals();
//        $path = substr($request->getPathInfo(), strlen("/articulo/"));
        $path = substr($request->getPathInfo(), strlen("/"));

        switch ($path) {
            case "logistica":
                $idSeccion = 1;
                break;
            case "movilidad":
                $idSeccion = 2;
                break;
            case "hardware":
                $idSeccion = 3;
                break;
            case "noticias":
                $idSeccion = 4;
                break;
            default:
                $idSeccion = 0;
        }

        $em = $this->getDoctrine()->getManager();

        $articulos = $em->getRepository('AppBundle:Articulo')->articulos($idSeccion);
        
        /*******************************************************/
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $articulos, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );

        // parameters to template
        //return $this->render('AcmeMainBundle:Article:list.html.twig', array('pagination' => $pagination));
        /**********************************************************/
        //return $articulos;
        return $pagination;
    }

    /**
     * Creates a new articulo entity.
     *
     * @Route("/articulo/new", name="articulo_new")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $articulo = new Articulo();
        $articulo->setActivo(true);
        
        $imagenArticulo = new imagenArticulo();
        $imagenArticulo->setActivo($articulo->getActivo());

        $subarticulo = new Subarticulo();
        $subarticulo->setActivo($articulo->getActivo());

        $form = $this->createForm('AppBundle\Form\NoticiaType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $data = $form->getData();

            $file = $data->getImagen();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                    $this->getParameter('im_upload_directory'), $fileName
            );

            if ($data->getDocAdjunto() != null) {
                $doc = $data->getDocAdjunto();
                $docName = md5(uniqid()) . '.' . $doc->guessExtension();
                $doc->move(
                        $this->getParameter('doc_upload_directory'), $docName
                );
                $subarticulo->setDocumento($docName);
            }

            $articulo->setIdseccion($data->getSeccion());
            $articulo->setTitulo($data->getTitulo());
            $articulo->setContenidoBreve($data->getContenidoBreve());
            $articulo->setFecha($data->getFecha());

            $prefijo = "imagenes/subida/";
            $imagenArticulo->setRuta($prefijo . $fileName);
            $imagenArticulo->setFecha($data->getFecha());

            $subarticulo->setTitulo($data->getTitulo());
            $subarticulo->setContenido($data->getContenido());
            $subarticulo->setVideo($data->getVideo());
            $subarticulo->setFecha($data->getFecha());
            
            
            $em->persist($articulo);
            $imagenArticulo->setIdarticulo($articulo);
            $subarticulo->setIdarticulo($articulo);
            
            $em->persist($imagenArticulo);
            $em->persist($subarticulo);
            
            $em->flush();                

            return $this->redirectToRoute('articulo_index_noticias');
        }

        return $this->render('articulo/new.html.twig', array(
                    'articulo' => $articulo,
                    'form' => $form->createView(),
        ));
    }

    /**
     *
     * @Route("/articulo/edit/{id}", name="articulo_edit", requirements={"id": "\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function editAction($id, Request $request) {

        if (!$id) {
            throw $this->createNotFoundException('No se encuentra el articulo.');
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $articuloComp = $em->getRepository('AppBundle:Articulo')->articuloCompletoById($id);
        
        $articulo = $articuloComp[0];
        $imagenArticulo = $articulo->getImagenes();
        $imagenArticulo = $imagenArticulo[0];
        $subarticulo = $articulo->getSubarticulo();
               
        $noticia = new Noticia();
        $noticia->setTitulo($articulo->getTitulo());
        $noticia->setContenidobreve($articulo->getContenidoBreve());
        $noticia->setFecha($articulo->getFecha());
        $file = new File($imagenArticulo->getRuta(),false);

        $noticia->setImagen($file);
        $noticia->setVideo($subarticulo->getVideo());
        $pdf = null;
        if($subarticulo->getDocumento() != null){
            $pdf = new File($subarticulo->getDocumento(),false);
        }
        $noticia->setDocadjunto($pdf);
        $noticia->setContenido($subarticulo->getContenido());
        $noticia->setSeccion($articulo->getIdseccion());

        $form = $this->createForm('AppBundle\Form\NoticiaType',$noticia);        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            $titulo = $data->getTitulo();
            $contBreve = $data->getContenidobreve();
            $fecha = $data->getFecha();
            $imagen = $data->getImagen();
            $video = $data->getVideo();
            $docAdjunto = $data->getDocadjunto();
            $contenido = $data->getContenido();
            $seccion = $data->getSeccion();

            $file = $imagen;
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                    $this->getParameter('im_upload_directory'), $fileName
            );
                 
            if ($docAdjunto != null) {
                $doc = $docAdjunto;
                $docName = md5(uniqid()) . '.' . $doc->guessExtension();
                $doc->move(
                        $this->getParameter('doc_upload_directory'), $docName
                );
                $subarticulo->setDocumento($docName);
            }

            $articulo->setIdseccion($seccion);
            $articulo->setTitulo($titulo);
            $articulo->setContenidoBreve($contBreve);
            $articulo->setFecha($fecha);

            $prefijo = "imagenes/subida/";
            $imagenArticulo->setRuta($prefijo . $fileName);
            $imagenArticulo->setFecha($fecha);

            $subarticulo->setTitulo($titulo);
            $subarticulo->setContenido($contenido);
            $subarticulo->setVideo($video);
            $subarticulo->setFecha($fecha);
            
            $em->persist($articulo);
            $em->persist($imagenArticulo);
            $em->persist($subarticulo);

            $em->flush();

            return $this->redirectToRoute('articulo_index_noticias');
        }

        return $this->render('articulo/edit.html.twig', array(
                    'articulo' => $articulo,
                    'form' => $form->createView(),
        ));
    }
    
    /**
     *
     * @Route("/articulo/activa/{id}", name="articulo_activa", requirements={"id": "\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"POST"})
     */
    public function activaAction($id){
        
        if (!$id) {
            throw $this->createNotFoundException('No se encuentra el articulo.');
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $articulo = $em->getRepository('AppBundle:Articulo')->find($id);
        
        if($articulo->getActivo() == true){
            $articulo->setActivo(false);
        }else{
            $articulo->setActivo(true);
        }      
        
        $em->persist($articulo);
        $em->flush();
        
        $datosArticulo = array(
                            "activo" => $articulo->getActivo(),
                            "id" => $articulo->getId()
                        );
        
        $response = new Response(json_encode($datosArticulo));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
