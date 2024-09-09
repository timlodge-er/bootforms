<?php

namespace AdamWathan\BootForms\Elements;
use AdamWathan\Form\Elements\Input;

class Number extends Input
{
    protected $attributes = [
        'type' => 'number',
    ];

    public function placeholder($placeholder)
    {
        $this->setAttribute('placeholder', $placeholder);

        return $this;
    }

    public function defaultValue($value)
    {
        if (! $this->hasValue()) {
            $this->setValue($value);
        }

        return $this;
    }

    public function min($minValue)
    {
        $this->setAttribute('min', $minValue);

        return $this;
    }

    public function max($maxValue)
    {
        $this->setAttribute('max', $maxValue);

        return $this;
    }

    public function step($stepValue)
    {
        $this->setAttribute('step', $stepValue);

        return $this;
    }

    protected function hasValue()
    {
        return isset($this->attributes['value']);
    }
}