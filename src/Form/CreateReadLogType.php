<?php

declare(strict_types=1);

namespace Bookshelf\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateReadLogType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('book', BookType::class)
            ->add('author', AuthorType::class)
            ->add('comment', TextareaType::class)
            ->add('dateRead', DateType::class, [
                'widget' => 'choice',
                'format' => 'yyyy-MM-dd',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => CreateReadLogModel::class,
        ]);
    }
}
