<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class NuevaNoticiaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('titulo', TextType::class,array('label' => 'Titulo'))
        	->add('contenidoBreve', TextType::class,array('label' => 'Descipción Breve'))
        	->add('fecha', DateType::class, array('label' => 'Fecha', 'data' => new \DateTime()))
            ->add('imagen', FileType::class, array('label' => 'Ruta Imagen'))
            ->add('video', TextType::class, array('label' => 'URL Video', 'required' => 'false'))
            ->add('docAdjunto', FileType::class, array('label' => 'Documento', 'required' => 'false'))
            ->add('contenido',TextareaType::class,array('label' => 'Contenido'))
            ->add('seccion', EntityType::class, array(
                'class' => 'AppBundle:Seccion',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u');
                },
                'choice_label' => 'Titulo',
                ))
//             ->add('save', SubmitType::class, array('label' => 'Guardar'))
        ;
    }
}
