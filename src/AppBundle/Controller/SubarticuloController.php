<?php

namespace AppBundle\Controller;
    
use AppBundle\Entity\Subarticulo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Filesystem\Filesystem;


/**
 * Subarticulo controller.
 *
 * @Route("subarticulo")
 */
class SubarticuloController extends Controller
{  
    
    /**
     * Finds and displays a subarticulo entity.
     *
     * @Route("/{idArt}", name="subart_show", requirements={"idArt": "\d+"})
     * @Method("GET")
     */
    public function showAction($idArt)
    {
       	$em = $this->getDoctrine()->getManager();
        
        $hayEvento = $this->getParameter('evento');
    	
       	$subarticulo = $em->getRepository('AppBundle:Subarticulo')->subarticulo($idArt);
        if(!$subarticulo){
            throw $this->createNotFoundException('');
        }else{
            $imagen = $em->getRepository('AppBundle:Imagenarticulo')->findByIdArticulo($subarticulo[0]->getIdarticulo());
            $recAsociados = $em->getRepository('AppBundle:recAsociado')->recursosSubarticulo($subarticulo[0]->getId());
            
            return $this->render('subarticulo/show.html.twig', array(
                            'subarticulo' => $subarticulo[0],
                            'imagen' => $imagen[0],
                            'recursos' => $recAsociados,
                            'hayEvento' => $hayEvento       
            ));
        }
    }     
    
    
    /**
     * @Route("/download/{id}", name="download_file", requirements={"id": "\d+"})
     **/
    public function downloadFileAction($id){

    	$em = $this->getDoctrine()->getManager();
    	$subarticulo = $em->getRepository('AppBundle:Subarticulo')->find($id);    	
   	
        if(!$subarticulo){
            throw $this->createNotFoundException('');
        }else{
            $filename = $subarticulo->getDocumento();
            $request = Request::createFromGlobals();
            // $document_root = $request->server->get('DOCUMENT_ROOT');
            $filepath = $this->getParameter('doc_upload_directory')."/".$filename;

            //check if file exists
            $fs = new FileSystem();    	
            if (!$fs->exists($filepath)) {
                throw $this->createNotFoundException();    		
            }

            // prepare BinaryFileResponse   	
            $response = new BinaryFileResponse($filepath);
            $response->trustXSendfileTypeHeader();
            $response->setContentDisposition(  			
                        ResponseHeaderBag::DISPOSITION_INLINE,
                        $filename,
                        iconv('UTF-8', 'ASCII//TRANSLIT', $filename)
                    );


            return $response;
        }    	
    }
    
    
        /**
     * @Route("/downloadRecurso/{id}", name="download_recurso", requirements={"id": "\d+"})
     **/
    public function downloadRecursoAction($id){

    	$em = $this->getDoctrine()->getManager();
    	$subarticulo = $em->getRepository('AppBundle:recAsociado')->find($id);    	
   	
        if(!$subarticulo){
            throw $this->createNotFoundException('');
        }else{
            $filename = $subarticulo->getDocumento();
            $request = Request::createFromGlobals();
            // $document_root = $request->server->get('DOCUMENT_ROOT');
            $filepath = $this->getParameter('doc_upload_directory')."/".$filename;

            //check if file exists
            $fs = new FileSystem();    	
            if (!$fs->exists($filepath)) {
                throw $this->createNotFoundException();    		
            }

            // prepare BinaryFileResponse   	
            $response = new BinaryFileResponse($filepath);
            $response->trustXSendfileTypeHeader();
            $response->setContentDisposition(  			
                        ResponseHeaderBag::DISPOSITION_INLINE,
                        $filename,
                        iconv('UTF-8', 'ASCII//TRANSLIT', $filename)
                    );


            return $response;
        }    	
    }

}
