<?php
/**
 * Created by PhpStorm.
 * File: CommentType.php
 * User: Yuriy Tarnavskiy
 * Date: 27.01.14
 * Time: 14:57
 */

namespace Etheriq\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{
    public function getName()
    {
        return 'blogComment';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('textComment', 'textarea');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Etheriq\BlogBundle\Entity\Comments'
            )
        );
    }


} 