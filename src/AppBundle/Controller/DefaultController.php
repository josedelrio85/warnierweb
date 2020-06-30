<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ContactoType;
use AppBundle\Form\EventoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$logistica = $em->getRepository('AppBundle:Articulo')->articulosPortada('1');
    	$movilidad = $em->getRepository('AppBundle:Articulo')->articulosPortada('2');
        $noticias = $em->getRepository('AppBundle:Articulo')->articulosPortada('4');

        $hayEvento = $this->getParameter('evento');
        $evento = $em->getRepository('AppBundle:Articulo')->getEvento();
        dump($evento);
    	return $this->render('default/prueba.html.twig', array(
    		'logistica' => $logistica,
    		'movilidad' => $movilidad,
            'noticias' => $noticias,
            'hayEvento' => $hayEvento,
            'evento' => $evento,
    	));
    }
    
    
    public function headerAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$seccions = $em->getRepository('AppBundle:Seccion')->findAll();
    	
    	return $this->render('/header.html.twig', array(
    			'seccions' => $seccions,
    	));
    }
    
    
    public function footerAction()
    {
    	return $this->render('/footer.html.twig');
    }
    
    
    public function cabeceraClasicaAction()
    {
        return $this->render('/default/cabeceraClasica.html.twig');
    }
    
    
    public function cabeceraEventoAction($subartid, $rutaimg, $descripcion)
    {
        return $this->render('/default/cabeceraEvento.html.twig', array(
            'subartid' => $subartid, 
            'rutaimg' => $rutaimg,
            'descripcion' => $descripcion,
        ));
    }
    
    public function cabeceraEventoCDTICAction()
    {
        return $this->render('/default/cabeceraEventoAlt.html.twig', array(
            'rutaimg' => 'portadacdtic.png',
            'descripcion' => 'Almacéns xestionados por voz Vocollect. Warnier/JSV',
            'href' => 'https://cdtic.xunta.gal/warnier',
        ));
    }

    /**
     * @Route("/aviso_legal", name="aviso_legal")
     */
    public function avisoLegalAction()
    {
    	return $this->render('default/aviso_legal.html.twig');
    }
    
    /**
     * @Route("/politica_privacidad", name="politica_privacidad")
     */
    public function politica_privacidadAction()
    {
    	return $this->render('default/politica_privacidad.html.twig');
    }
    
    /**
     * @Route("/donde", name="donde")
     */
    public function dondestamosAction()
    {
    	return $this->render('default/donde.html.twig');
    }
    
    
    /**
     * @Route("/clientes", name="clientes")
     */
    public function clientesAction()
    {
    	return $this->render('default/clientes.html.twig');
    }
    

    public function clientesTemplateAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$clientes = $em->getRepository('AppBundle:Clientes')->findActivos();
    	
    	return $this->render('default/clientesTemplate.html.twig', array(
    			'clientes' => $clientes,
    	));
    }

    
    /**
     * @Route("/partners", name="partners")
     */
    public function partnersAction()
    {
    	return $this->render('default/partners.html.twig');
    }
    
    
    public function partnersTemplateAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$partners = $em->getRepository('AppBundle:Partners')->findActivos();
    	
    	return $this->render('default/partnersTemplate.html.twig', array(
    			'partners' => $partners,
    	));
    }
    
    /**
     * @Route("/contacto", name="contacto")
     * @Method({"GET", "POST"})
     */
    public function contactoAction(Request $query)
    {
    	$form = $this->createForm(ContactoType::class);
    	
    	$enviador = $this->getParameter('mailer_user');
    	$destinatario = $this->getParameter('destinatarioMailEvento');
    	
    	if ($query->isMethod('POST')) {
    		$form->handleRequest($query);
    		
    		if ($form->isValid()) {
    			$mailer = $this->get('mailer');
    			$message = $mailer->createMessage()
    			->setSubject('Solicitud info desde warnier.com')
    			->setFrom($enviador)
    			->setTo($destinatario)
    			->setBody(
    					$this->renderView(
    							'default/contactoTemplate.html.twig',
    							array(
    									'ip' => $query->getClientIp(),
    									'nombre' => $form->get('nombre')->getData(),
    									'email' => $form->get('email')->getData(),
    									'asunto' => $form->get('asunto')->getData()
    							)
    							)
    					);
    			
    			$mailer->send($message);
    			
    			$query->getSession()->getFlashBag()->add('success', 'Hemos recibido tu solicitud. Gracias por confiar en nosotros.');
    			
    			return $this->redirect($this->generateUrl('contacto'));
    		}
    	}
    	
    	return $this->render('default/contacto.html.twig', array(
    			'form'   => $form->createView()
    	));
    }
    
    public function cookiesAction()
    {
    	return $this->render('/cookies.html.twig');
    }
    
    
    /**
     * @Route("/politica_cookies", name="politica_cookies")
     * @Method({"GET", "POST"})
     */
    public function politicaCookiesAction()
    {
    	return $this->render('default/politica_cookies.html.twig');
    }

    /**
     * @Route("/evento", name="evento_log_mov")
     * @Method({"GET", "POST"})
     */
    public function eventoAction(Request $query)
    {
        
        $form = $this->createForm(EventoType::class);
        
        $enviador = $this->getParameter('mailer_user');
        $destinatario = $this->getParameter('destinatarioMailEvento');
        
        
        if ($query->isMethod('POST')) {
            $form->handleRequest($query);
            
            if ($form->isValid()) {
                $mailer = $this->get('mailer');
                $message = $mailer->createMessage()
                ->setSubject('Solicitud registro evento movilidad')
                ->setFrom($enviador)
                ->setTo($destinatario)
                ->setBody(
                    $this->renderView(
                        'default/eventoTemplate.html.twig',
                        array(
                            'ip' => $query->getClientIp(),
                            'nombre' => $form->get('nombre')->getData()." ".$form->get('apellidos')->getData(),
                            'empresa' => $form->get('empresa')->getData(),
                            'email' => $form->get('email')->getData(),
                            'telefono' => $form->get('telefono')->getData(),
                            'cargo' => $form->get('cargo')->getData(),
                            'direccion' => $form->get('direccion')->getData(),
                            'poblacion' => $form->get('poblacion')->getData(),
                            'codigopostal' => $form->get('codigopostal')->getData(),
                            'provincia' => $form->get('provincia')->getData(),
                        )
                        )
                    );
                
                $mailer->send($message);
                
                $query->getSession()->getFlashBag()->add('success', 'Tu solicitud de asistencia ha sido registrada. Gracias');
                
                //return $this->redirect($this->generateUrl('evento_log_mov'));
            }
        }
        
        return $this->render('default/evento.html.twig', array(
            'form'   => $form->createView()
        ));
    }
    
    /**
     * @Route("/admin", name="admin")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET"})
     */
    public function adminAction(){
        
        return $this->render('default/admin.html.twig');
    }
    
    public function videoFlotanteAction(){
        return $this->render('default/videoFlotante.html.twig');
    }

    /**
     * @Route("/evento2019", name="evento_log_mov_2019")
     * @Method({"GET", "POST"})
     */
    public function evento2019Action(Request $query)
    {
        
        $form = $this->createForm(EventoType::class);
        
        $enviador = $this->getParameter('mailer_user');
        $destinatario = $this->getParameter('destinatarioMailEvento');
        
        
        if ($query->isMethod('POST')) {
            $form->handleRequest($query);
            
            if ($form->isValid()) {
                $mailer = $this->get('mailer');
                $message = $mailer->createMessage()
                ->setSubject('Solicitud registro evento movilidad')
                ->setFrom($enviador)
                ->setTo($destinatario)
                ->setBody(
                    $this->renderView(
                        'default/eventoTemplate.html.twig',
                        array(
                            'ip' => $query->getClientIp(),
                            'nombre' => $form->get('nombre')->getData()." ".$form->get('apellidos')->getData(),
                            'empresa' => $form->get('empresa')->getData(),
                            'email' => $form->get('email')->getData(),
                            'telefono' => $form->get('telefono')->getData(),
                            'cargo' => $form->get('cargo')->getData(),
                            'direccion' => $form->get('direccion')->getData(),
                            'poblacion' => $form->get('poblacion')->getData(),
                            'codigopostal' => $form->get('codigopostal')->getData(),
                            'provincia' => $form->get('provincia')->getData(),
                        )
                        )
                    );
                
                $mailer->send($message);
                
                $query->getSession()->getFlashBag()->add('success', 'Tu solicitud de asistencia ha sido registrada. Gracias');
            }
        }
        
    	$em = $this->getDoctrine()->getManager();
        $evento = $em->getRepository('AppBundle:Articulo')->getEvento();

        return $this->render('default/evento2019.html.twig', array(
            'form'   => $form->createView(),
            'evento' => $evento,
        ));
    }
    
}
