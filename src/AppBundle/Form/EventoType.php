<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\CollectionValidator;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class EventoType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('nombre', TextType::class, array(
					'attr' => array(
							'placeholder' => 'Introduzca su nombre.'
					)
			))
			->add('apellidos', TextType::class, array(
			    'attr' => array(
			        'placeholder' => 'Introduzca su apellido.'
			    )
			))
			->add('empresa', TextType::class, array(
			    'attr' => array(
			        'placeholder' => 'Introduzca su empresa.'
			    )
			))
			->add('cargo', TextType::class)
			->add('direccion', TextType::class)
			->add('poblacion', TextType::class)
			->add('codigopostal',NumberType::class, array(
			    'label' => 'Código Postal'
			))
			->add('provincia', TextType::class)
			->add('telefono', TextType::class, array(
			    'attr' => array(
			        'placeholder' => 'Indique un número de teléfono de contacto.'
			    )
			))
			->add('email', EmailType::class, array(
					'attr' => array(
							'placeholder' => 'Indique una dirección de correo.'
					)
			));
	}
	
	public function setDefaultOptions(OptionsResolver $resolver)
	{
		$collectionConstraint = new CollectionValidator(array(
				'nombre' => array(
						new NotBlank(array('message' => 'Debes indicar un nombre.')),
						new Length(array('min' => 3))
				),
				'email' => array(
						new NotBlank(array('message' => 'Debes indicar un email.')),
						new EmailType(array('message' => 'Email inválido.'))
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
