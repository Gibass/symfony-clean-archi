<?php

namespace App\UserInterface\Form;

use App\Domain\Category\Gateway\CategoryGatewayInterface;
use App\Domain\Tag\Gateway\TagGatewayInterface;
use App\Infrastructure\Doctrine\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ArticleType extends AbstractType
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly TagGatewayInterface $tagGateway,
        private readonly CategoryGatewayInterface $categoryGateway
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('content', TextareaType::class, [
                'required' => false,
            ])
            ->add('category', AutocompleteChoiceType::class, [
                'find_callback' => $this->categoryGateway->getById(...),
                'invalid_message' => 'Only one category can be selected',
                'attr' => [
                    'data-api' => $this->urlGenerator->generate('api_category'),
                    'placeholder' => 'Add Category',
                ],
            ])
            ->add('tags', AutocompleteChoiceType::class, [
                'find_callback' => $this->tagGateway->getByIds(...),
                'multiple' => true,
                'attr' => [
                    'data-api' => $this->urlGenerator->generate('api_tags'),
                    'placeholder' => 'Add Tags',
                ],
            ])
            ->add('status', CheckboxType::class, [
                'label' => 'Publish',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
