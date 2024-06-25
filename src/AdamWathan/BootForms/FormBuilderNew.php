<?php

namespace AdamWathan\BootForms;

use AdamWathan\BootForms\Elements\Number;
use AdamWathan\Form\FormBuilder;

class FormBuilderNew extends FormBuilder
{
    public function number($name)
    {
        $number = new Number($name);

        if (!is_null($value = $this->getValueFor($name))) {
            $number->value($value);
        }

        return $number;
    }

}