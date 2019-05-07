<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class SitemapController extends Controller
{
	/**
	 * @Route("/sitemap.{_format}", name="sample_sitemaps_sitemap", Requirements={"_format" = "xml"})
	 * @Template("AppBundle:Sitemap:sitemap.xml.twig")
	 */
	public function sitemapAction()
	{
		$em = $this->getDoctrine()->getManager();
		
		$request = Request::createFromGlobals();
		
		$hostname = $request->getSchemeAndHttpHost();
		
		$urls = array();
		
		// incluye url página inicial
		$urls[] = array(
				'loc' => $this->get('router')->generate('homepage'),
				'changefreq' => 'weekly',
				'priority' => '1.0'
		);


		$urls[] = array(
				'loc' => $this->get('router')->generate('aviso_legal'), 
				'changefreq' => 'monthly',
				'priority' => '0.3'
		);
		
		$urls[] = array(
				'loc' => $this->get('router')->generate('politica_privacidad'),
				'changefreq' => 'monthly',
				'priority' => '0.3'
		);
		
		$urls[] = array(
				'loc' => $this->get('router')->generate('donde'),
				'changefreq' => 'monthly',
				'priority' => '0.3'
		);
		
		
		$urls[] = array(
				'loc' => $this->get('router')->generate('clientes'),
				'changefreq' => 'monthly',
				'priority' => '0.3'
		);
		
		$urls[] = array(
				'loc' => $this->get('router')->generate('partners'),
				'changefreq' => 'monthly',
				'priority' => '0.3'
		);
		
		$urls[] = array(
				'loc' => $this->get('router')->generate('contacto'),
				'changefreq' => 'monthly',
				'priority' => '0.3'
		);
		
		$urls[] = array(
				'loc' => $this->get('router')->generate('articulo_index_logistica'),
				'changefreq' => 'monthly',
				'priority' => '0.3'
		);
		
		$urls[] = array(
				'loc' => $this->get('router')->generate('articulo_index_movilidad'),
				'changefreq' => 'monthly',
				'priority' => '0.3'
		);
		
		$urls[] = array(
				'loc' => $this->get('router')->generate('articulo_index_hardware'),
				'changefreq' => 'monthly',
				'priority' => '0.3'
		);
		
		$urls[] = array(
				'loc' => $this->get('router')->generate('articulo_index_noticias'),
				'changefreq' => 'monthly',
				'priority' => '0.3'
		);
		
		$urls[] = array(
		    'loc' => $this->get('router')->generate('evento_log_mov'),
		    'changefreq' => 'monthly',
		    'priority' => '0.3'
		);
			

                $subarticulos = $em->getRepository('AppBundle:Subarticulo')->listaSubarticulos();
		foreach ($subarticulos as $item) {
			$urls[] = array(
					'loc' => $this->get('router')->generate('subart_show', array(
							'idArt' => $item->getId()
					)),
					'changefreq' => 'monthly',
					'priority' => '0.5'
			);
		}

		
		return $this->render('sitemap/sitemap.xml.twig', array(
				'urls'     => $urls,
				'hostname' => $hostname
		));
	}
}