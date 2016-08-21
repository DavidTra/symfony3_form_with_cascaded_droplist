<?php

namespace TEST2\RegistrationBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TEST2\RegistrationBundle\Entity\Province;

class AccountType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('Province',   EntityType::class, array(
                'class'     =>  'TEST2\RegistrationBundle\Entity\Province',
                'placeholder'   => '-- Choose a province --',
                //'mapped'    =>  false
            ))
        ;

        $formModifier = function (FormInterface $form, Province $province = null) {

            $cities = null === $province ? array() : $province->getAvailableCities(); // only in a bidirectional relationship
            $placeholder = empty($cities) ? '-- Choose a province first --' : '';

            $form->add('City',  EntityType::class, array(
                'class' =>  'TEST2\RegistrationBundle\Entity\City',
                'placeholder'   => $placeholder,
                'choices' => $cities,
            ));

            $form->add('name',       TextType::class)
                 ->add('save',       SubmitType::class)
            ;
        };



        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) use ($formModifier){
                $form = $event->getForm();

                $formModifier($form, null);
            }
        );

        $builder->get('Province')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event) use ($formModifier) {
                $form = $event->getForm()->getParent();
                $province_id = $event->getData();
                $province = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($form, $province);

                $form->add('name',       TextType::class)
                    ->add('save',       SubmitType::class)
                ;
            }
        );

    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TEST2\RegistrationBundle\Entity\Account'
        ));
    }
}
