<?php

namespace AdamWathan\BootForms;

use AdamWathan\BootForms\Elements\Number;
use AdamWathan\BootForms\Elements\Hidden;
use AdamWathan\BootForms\Elements\Select;
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
    public function select($name, $options = [], $selected = null)
    {
        // Create a new Select instance with the provided name and options
        $select = new Select($name, $options);

        // If $selected is null, get the value from the original method
        if ($selected === null) {
            $selected = $this->getValueFor($name);
        }

        // Set the selected value in the Select element
        $select->select($selected);

        return $select;
    }
}