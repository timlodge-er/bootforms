<?php

namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Input;

class Hidden extends Input
{
    protected $attributes = [
        'type' => 'hidden',
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

    protected function hasValue()
    {
        return isset($this->attributes['value']);
    }
}
