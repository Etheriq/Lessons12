<?php
/**
 * Created by PhpStorm.
 * File: GuestType.php
 * User: Yuriy Tarnavskiy
 * Date: 02.01.14
 * Time: 16:02
 */

namespace Etheriq\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GuestType extends AbstractType
{
    public function getName()
    {
        return 'guest';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameGuest', 'text')
            ->add('emailGuest', 'email')
            ->add('bodyGuest', 'textarea')
            ->add('save', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Etheriq\BlogBundle\Entity\Guest'
            )
        );
    }
}
