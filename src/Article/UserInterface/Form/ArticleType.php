<?php

declare(strict_types=1);

namespace App\Article\UserInterface\Form;

use App\Article\Domain\Model\Enum\ArticleStatus;
use App\Article\UserInterface\DTO\ArticleDTO;
use App\Taxonomy\Domain\Model\Entity\Taxonomy;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('content', TextareaType::class)
            ->add('taxonomies', EntityType::class, [
                'class' => Taxonomy::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
            ->add('status', ChoiceType::class, [
                'choices' => ArticleStatus::cases(),
                'expanded' => true,
                'multiple' => false,
                'choice_label' => fn(ArticleStatus $status) => $status->name,
                'choice_value' => fn(?ArticleStatus $status) => $status?->value
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArticleDTO::class,
        ]);
    }
}
