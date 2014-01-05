<?php
/**
 * Created by PhpStorm.
 * User: xeon
 * Date: 05.01.14
 * Time: 19:08
 */

namespace Etheriq\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BlogDetailType  extends AbstractType
{
    public function getName()
    {
        return 'blogDetailed';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titleBlog', 'text')
            ->add('textBlog', 'textarea')
            ->add('rate', 'hidden')
            ->add('save', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Etheriq\BlogBundle\Entity\Blog'
            )
        );
    }


} 