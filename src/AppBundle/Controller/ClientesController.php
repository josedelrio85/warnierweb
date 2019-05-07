<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\File;
use AppBundle\Entity\Clientes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Description of ClientesController
 *
 * @author jose
 */
class ClientesController extends Controller {
    
    /**
     * Lists all clientes entities.
     *
     * @Route("/clientes/admin", name="clientes_index_admin")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAdminAction(){
        
        $em = $this->getDoctrine()->getManager();
        
        $clientes = $em->getRepository('AppBundle:Clientes')->findAll();
        
        $paginator  = $this->get('knp_paginator');
        $request = Request::createFromGlobals();
        $pagination = $paginator->paginate(
            $clientes, /* query, NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
        
        return $this->render('/clientes/indexAdmin.html.twig', array(
            'clientes' => $pagination,
            'coso' => 'clientes',
            'ruta' => 'cliente_new',
        ));
    }
    
    
    /**
     *
     * @Route("/clientes/activa/{id}", name="clientes_activa", requirements={"id": "\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"POST"})
     */
    public function activaAction($id){
        
        if (!$id) {
            throw $this->createNotFoundException('No se encuentra el cliente.');
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $objeto = $em->getRepository('AppBundle:Clientes')->find($id);
        
        if($objeto->getActivo() == true){
            $objeto->setActivo(false);
        }else{
            $objeto->setActivo(true);
        }      
        
        $em->persist($objeto);
        $em->flush();
        
        $datosObjeto = array(
                            "activo" => $objeto->getActivo(),
                            "id" => $objeto->getId()
                        );
        
        $response = new Response(json_encode($datosObjeto));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    
    
    /**
     * Creates a new cliente entity.
     *
     * @Route("/clientes/new", name="cliente_new")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        
        $em = $this->getDoctrine()->getManager();

        $cliente = new Clientes();
        $cliente->setActivo(true);
        
        //$form = $this->createForm('AppBundle\Form\NoticiaType');
        $form = $this->createFormBuilder($cliente)
            ->add('nombre', TextType::class, array('label' => 'Titulo'))
            ->add('rutaimagen', FileType::class, array('label' => 'Ruta Imagen'))
            ->add('activo', CheckBoxType::class, array('label' => 'Activo'))        
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            $data = $form->getData();
            
            $cliente->setNombre($data->getNombre());
            
            $file = $data->getRutaimagen();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                    $this->getParameter('im_upload_directory'), $fileName
            );
            $prefijo = "imagenes/subida/";
            $cliente->setRutaimagen($prefijo . $fileName);

            $em->persist($cliente);           
            $em->flush();                

            return $this->redirectToRoute('clientes_index_admin');
        }

        return $this->render('clientes/new.html.twig', array(
                    'cliente' => $cliente,
                    'form' => $form->createView(),
                    'coso' => 'cliente',
        ));
    }
    
    
    /**
     *
     * @Route("/clientes/edit/{id}", name="cliente_edit", requirements={"id": "\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function editAction($id, Request $request) {

        if (!$id) {
            throw $this->createNotFoundException('No se encuentra el cliente.');
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $cliente = $em->getRepository('AppBundle:Clientes')->find($id);
        
        $file = new File($cliente->getRutaimagen(), false);
        $cliente->setRutaimagen($file);

        $form = $this->createFormBuilder($cliente)
            ->add('nombre', TextType::class, array('label' => 'Titulo'))
            ->add('rutaimagen', FileType::class, array('label' => 'Ruta Imagen'))
            ->add('activo', CheckBoxType::class, array('label' => 'Activo'))        
            ->add('save', SubmitType::class, array('label' => 'Guardar'))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                        
            $data = $form->getData();

            $cliente->setNombre($data->getNombre());
            $cliente->setActivo($data->getActivo());

            $file = $data->getRutaimagen();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                    $this->getParameter('im_upload_directory'), $fileName
            );
            
            $prefijo = "imagenes/subida/";
            $cliente->setRutaimagen($prefijo . $fileName);

            $em->persist($cliente);
            $em->flush();

            return $this->redirectToRoute('clientes_index_admin');
        }

        return $this->render('clientes/edit.html.twig', array(
                    'cliente' => $cliente,
                    'form' => $form->createView(),
                    'coso' => 'cliente',
        ));
    }
}
