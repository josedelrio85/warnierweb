<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ContactoType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('nombre', TextType::class, array(
					'attr' => array(
							'placeholder' => 'Introduce tu nombre'
					)
			))
			->add('email', EmailType::class, array(
					'attr' => array(
							'placeholder' => 'Email'
					)
			))
			->add('asunto', TextareaType::class, array(
					'attr' => array(
							'cols' => 90,
							'rows' => 10,
							'placeholder' => 'Mensaje'
					)
			))
			->add('save', SubmitType::class, array('label' => 'Enviar'));
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$collectionConstraint = new Collection(array(
				'nombre' => array(
						new NotBlank(array('message' => 'Debes indicar un nombre.')),
						new Length(array('min' => 3))
				),
				'email' => array(
						new NotBlank(array('message' => 'Debes indicar un email.')),
						new Email(array('message' => 'Email inválido.'))
				),
				'asunto' => array(
						new NotBlank(array('message' => 'El mensaje no puede estar vacío.')),
						new Length(array('min' => 5))
				)
		));
		
		$resolver->setDefaults(array(
				'constraints' => $collectionConstraint
		));
	}
	
	public function getName()
	{
		return 'Contacto';
	}
}
