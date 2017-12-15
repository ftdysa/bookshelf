<?php

namespace Bookshelf\Form;

use Bookshelf\Entity\ReadLog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateReadLogType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('book', BookType::class)
            ->add('author', AuthorType::class)
            ->add('comment', TextType::class)
            ->add('dateRead', DateTimeType::class);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => CreateReadLogModel::class,
        ]);
    }
}