<?php

declare(strict_types=1);

namespace Bookshelf\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateReadLogType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('book', TextType::class)
            // NOTE: authors are custom
            ->add('authors', TextType::class, [
                'mapped' => false,
            ])
            ->add('comment', TextareaType::class)
            ->add('dateRead', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'bulma-calendar'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => CreateReadLogModel::class,
        ]);
    }
}
