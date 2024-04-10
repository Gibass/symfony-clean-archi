<?php

namespace App\UserInterface\Form;

use App\UserInterface\Form\DataTransformer\AutocompleteTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutocompleteChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('values', HiddenType::class, ['attr' => ['class' => 'id-values']]);
        $builder->add('tmp', HiddenType::class, ['attr' => ['class' => 'tmp-values']]);
        $builder->add('field', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
                'class' => 'js-multi-autocomplete',
                'data-key' => $options['attr']['data-key'] ?? 'title',
                'data-api' => $options['attr']['data-api'] ?? null,
                'placeholder' => $options['attr']['placeholder'] ?? null,
            ],
        ]);

        $builder->addModelTransformer(new AutocompleteTransformer($options['find_callback'], $options['name'], $options['multiple']));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'find_callback' => null,
            'name' => 'title',
            'multiple' => false,
            'error_bubbling' => false,
            'invalid_message' => 'Invalid value',
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['attr'] = ['class' => 'autocomplete-container'];
    }
}
