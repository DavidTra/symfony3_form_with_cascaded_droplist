<?php

namespace TEST\RegistrationBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                'class'     =>  'TEST\RegistrationBundle\Entity\Province',
                'placeholder'   => '-- Choose a province --',
                'mapped'    =>  false
            ))
            ->add('name',       TextType::class)
            ->add('save',       SubmitType::class)
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event){
                $form = $event->getForm();

                $cities =  array();
                $form->add('City',   EntityType::class, array(
                    'class'     =>  'TEST\RegistrationBundle\Entity\City',
                    'placeholder'   => '-- Choose a province first --',
                    'choices'       => $cities
                ));
            }
        );

        $builder->get('Province')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event){
                $form = $event->getForm()->getParent();
                $province = $event->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!

                // Here we user a query_builder because the entity Account is not directly linked with Province
                // otherwise we could have used a command like :
                // $cites = null === $province ? array() : $province->getAvailableCities();
                // and add 'choices' => $cities,
                $form->add('City',   EntityType::class, array(
                    'class'     =>  'TEST\RegistrationBundle\Entity\City',
                    'placeholder'   => '-- Choose a province first --',
                    'query_builder' => function (EntityRepository $er) use ($province){
                        return $er->createQueryBuilder('city')
                            ->join('city.province', 'province')
                            ->andWhere('province.id = :Province_id')
                            ->setParameter('Province_id', $province)
                            ->orderBy('city.name', 'ASC');
                    },
                ));
            }
        );

    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TEST\RegistrationBundle\Entity\Account'
        ));
    }
}
