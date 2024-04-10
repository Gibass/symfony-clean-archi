<?php

namespace App\UserInterface\Form\DataTransformer;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class AutocompleteTransformer implements DataTransformerInterface
{
    /**
     * @var callable
     */
    private $findCallback;
    private bool $multiple;
    private string $name;

    public function __construct(callable $findCallback, string $name, bool $multiple = false)
    {
        $this->findCallback = $findCallback;
        $this->multiple = $multiple;
        $this->name = $name;
    }

    public function transform($value): array
    {
        if ($value === null) {
            return [
                'values' => '',
                'field' => '',
                'tmp' => '',
            ];
        }

        if ($this->multiple && !$value instanceof Collection) {
            throw new TransformationFailedException('Value must be an ArrayCollection.');
        }

        if (!$value instanceof Collection) {
            $value = [$value];
        }

        return [
            'values' => $this->getValues($value, 'getId'),
            'field' => $this->getValues($value, 'get' . ucfirst($this->name)),
            'tmp' => $this->getValues($value, 'get' . ucfirst($this->name)),
        ];
    }

    public function reverseTransform($value): mixed
    {
        if (!\is_array($value)) {
            throw new TransformationFailedException('Value must be an array.');
        }

        $ids = explode(',', $value['values'] ?? '');

        if (!$this->multiple && \count($ids) > 1) {
            throw new TransformationFailedException('Only one value can be selected.');
        }

        if (!$this->multiple) {
            $ids = (int) current($ids);
        }

        return ($this->findCallback)($ids);
    }

    private function getValues($value, string $method): string
    {
        $values = [];
        foreach ($value as $item) {
            if (method_exists($item, $method)) {
                $values[] = $item->$method();
            }
        }

        return implode(',', $values);
    }
}
