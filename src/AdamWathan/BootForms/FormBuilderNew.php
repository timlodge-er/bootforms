<?php

namespace AdamWathan\BootForms;

use AdamWathan\BootForms\Elements\Number;
use AdamWathan\BootForms\Elements\Hidden;
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
    public function hidden($name, $value = null)
    {
        $hidden = new Hidden($name);

        if (!is_null($value)) {
            $hidden->value($value);
        }

        return $hidden;
    }

}