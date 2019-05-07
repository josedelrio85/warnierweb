<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Description of UsuarioType
 *
 * @author jose
 */
class UsuarioType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $usaEmail = false;
        if(array_key_exists('data',$options)){
            $usaEmail = $options['data']['usaEmail'];
        }
        
        $builder
                ->add('username', TextType::class, array(
                    'label' => 'Usuario',
                    'attr' => array(
                        'placeholder' => 'Introduzca su nombre de usuario.'
            )))
                ->add('password', PasswordType::class, array(
                    'label' => 'Password',
                    'attr' => array(
                        'placeholder' => 'Introduzca su password.'
        )));
        //->add('login', SubmitType::class, array('label' => 'Login'));

        if($usaEmail){
            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $usuario = $event->getData();
                $form = $event->getForm();

                // check if the Product object is "new"
                // If no data is passed to the form, the data is "null".
                // This should be considered a new "Product"
                //if (!$usuario || null === $usuario->getId()) {
                if($usuario['usaEmail']){

                    $form->add('email', RepeatedType::class, array(
                        'type' => EmailType::class,
                        'invalid_message' => 'Los correos electrónicos deben coincidir.',
                        'options' => array('attr' => array('class' => 'form-control')),
                        'required' => true,
                        'first_options' => array('label' => 'Email'),
                        'second_options' => array('label' => 'Repite email'),
                    ));
                }
            });
        }
    }

    public function setDefaultOptions(OptionsResolver $resolver) {
        $collectionConstraint = new CollectionValidator(array(
            'username' => array(
                new NotBlank(array('message' => 'Debes indicar el nombre de usuario.')),
                new Length(array('max' => 30))
            ),
            'password' => array(
                new NotBlank(array('message' => 'Debes indicar un password.')),
                new Length(array('max' => 40))
            ),
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
    }

    public function getName() {
        return 'Login';
    }
}
