<?php

namespace Crm\ApplicationModule\Criteria\Params;

use Crm\ApplicationModule\Criteria\CriteriaParam;

class StringLabeledArrayParam implements CriteriaParam
{
    protected $type = 'string_labeled_array';

    private $key;

    private $label;

    private $options;

    private $operator;

    public function __construct(string $key, string $label, array $options, $operator = 'or')
    {
        $this->options = array_map(function ($value) use ($options) {
            return (object) [
                'value' => $value,
                'label' => $options[$value],
            ];
        }, array_keys($options));
        $this->key = $key;
        $this->label = $label;
        $this->operator = $operator;
    }

    public function key(): string
    {
        return $this->key;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function blueprint(): array
    {
        $result = [
            'type' => $this->type(),
            'label' => $this->label(),
            'options' => $this->options,
            'operator' => $this->operator,
        ];
        return $result;
    }

    public function type(): string
    {
        return $this->type;
    }
}