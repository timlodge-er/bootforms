<?php namespace AdamWathan\BootForms;

use AdamWathan\BootForms\Elements\CheckGroup;
use AdamWathan\BootForms\Elements\FormGroup;
use AdamWathan\BootForms\Elements\GroupWrapper;
use AdamWathan\BootForms\Elements\HelpBlock;
use AdamWathan\BootForms\Elements\InputGroup;
use AdamWathan\BootForms\Elements\DivElement;
use AdamWathan\Form\FormBuilder;
use AdamWathan\Form\Elements\Element;


class BasicFormBuilder
{
    protected $builder;

    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    protected function formGroup($label, $name, $control)
    {
        $name = strtolower($name);
        $label = $this->builder->label($label)->addClass('control-label')->forId($name);
        $control->id($name)->addClass('form-control');

        $formGroup = new FormGroup($label, $control);

        if ($this->builder->hasError($name)) {
            $formGroup->helpBlock($this->builder->getError($name));
            $formGroup->addClass('has-error');
        }

        return $this->wrap($formGroup);
    }

    protected function wrap($group)
    {
        return new GroupWrapper($group);
    }

    public function text($name, $label, $value = null)
    {
        $control = $this->builder->text($name)->value($value);

        return $this->formGroup($label, $name, $control);
    }

    public function number($name, $label, $value = null)
    {
        $control = $this->builder->number($name)->value($value);

        return $this->formGroup($label, $name, $control);
    }

    public function password($name, $label)
    {
        $control = $this->builder->password($name);

        return $this->formGroup($label, $name, $control);
    }

    public function button($value, $name = null, $type = "btn-default")
    {
        return $this->builder->button($value, $name)->addClass('btn')->addClass($type);
    }


    public function submit($value = "Submit", $attributes = [])
    {
        if(!is_array($attributes)){
            return $this->builder->submit($value)->addClass('btn')->addClass($attributes);
        }
        $control = $this->builder->submit($value);

        // Ensure 'btn' class is always added
        $control->addClass('btn');

        // Loop through the attributes to set them
        foreach ($attributes as $key => $attrValue) {
            if ($key === 'class') {
                // Add the class to the control
                $control->addClass($attrValue);
            } else {
                // Set other attributes using the public 'attribute' method
                $control->attribute($key, $attrValue);
            }
        }

        return $control;
    }

    public function select($name, $label, $options = [], $selected = null, $attributes = [])
    {
        $control = $this->builder->select($name, $options, $selected);

        // Loop through the attributes to find 'class'
        foreach ($attributes as $key => $value) {
            if ($key === 'class') {
                $control->addClass($value);
            } else {
                $control->setAttribute($key, $value);
            }
        }


        return $this->formGroup($label, $name, $control);
    }

    public function checkboxes(string $name, ?string $label = null, array $choices = [], array $checkedValues = [], bool $inline = false, array $options = []): string
    {
        $elements = '';

        foreach ($choices as $value => $choiceLabel) {
            $checked = in_array($value, (array) $checkedValues);
            $checkbox = $this->builder->checkbox($name . '[]', $value)->checked($checked);
            if ($inline) {
                $checkbox->inline();
            }
            $elements .= '<div class="checkbox' . ($inline ? ' inline' : '') . '">' . (string)$this->wrapCheckbox($choiceLabel, $checkbox) . '</div>';
        }

        $labelElement = $this->builder->label($label)->addClass('control-label');
        $controlElement = new DivElement($elements);

        $formGroup = new FormGroup($labelElement, $controlElement);

        return (string) $this->wrap($formGroup);
    }

    protected function wrapCheckbox($label, Element $control)
    {
        return $this->builder->label($label)->after($control)->addClass('checkbox-inline');
    }

    public function checkbox($name, $label, $checked = false)
    {
        $control = $this->builder->checkbox($name)->checked($checked);

        return $this->checkGroup($label, $name, $control);
    }


    public function inlineCheckbox($name, $label)
    {
        return $this->checkbox($label, $name)->inline();
    }

    protected function checkGroup($name, $label, $control)
    {
        $checkGroup = $this->buildCheckGroup($label, $name, $control);
        return $this->wrap($checkGroup->addClass('checkbox'));
    }

    protected function buildCheckGroup($name, $label, $control)
    {
        $label = $this->builder->label($label, $name)->after($control)->addClass('control-label');

        $checkGroup = new CheckGroup($label);

        if ($this->builder->hasError($name)) {
            $checkGroup->helpBlock($this->builder->getError($name));
            $checkGroup->addClass('has-error');
        }
        return $checkGroup;
    }

    public function radio($name, $label, $value = null)
    {
        if (is_null($value)) {
            $value = $label;
        }

        $control = $this->builder->radio($name, $value);

        return $this->radioGroup($label, $name, $control);
    }

    public function inlineRadio($name, $label, $value = null)
    {
        return $this->radio($label, $name, $value)->inline();
    }

    protected function radioGroup($name, $label, $control)
    {
        $checkGroup = $this->buildCheckGroup($label, $name, $control);
        return $this->wrap($checkGroup->addClass('radio'));
    }

    public function textarea($name, $label, $value = null, $attributes = [])
    {
        $control = $this->builder->textarea($name)->value($value);

        foreach ($attributes as $key => $value) {
            if ($key === 'class') {
                $control->addClass($value);
            } else {
                $control->setAttribute($key, $value);
            }
        }

        return $this->formGroup($label, $name, $control);
    }

    public function date($name, $label, $value = null)
    {
        $control = $this->builder->date($name)->value($value);

        return $this->formGroup($label, $name, $control);
    }

    public function dateTimeLocal($label, $name, $value = null)
    {
        $control = $this->builder->dateTimeLocal($name)->value($value);

        return $this->formGroup($label, $name, $control);
    }

    public function email($name, $label, $value = null)
    {
        $control = $this->builder->email($name)->value($value);

        return $this->formGroup($label, $name, $control);
    }

    public function file($name, $label, $value = null)
    {
        $control = $this->builder->file($name)->value($value);
        $label = $this->builder->label($label, $name)->addClass('control-label')->forId($name);
        $control->id($name);

        $formGroup = new FormGroup($label, $control);

        if ($this->builder->hasError($name)) {
            $formGroup->helpBlock($this->builder->getError($name));
            $formGroup->addClass('has-error');
        }

        return $this->wrap($formGroup);
    }

    public function inputGroup($label, $name, $value = null)
    {
        $control = new InputGroup($name);
        if (!is_null($value) || !is_null($value = $this->getValueFor($name))) {
            $control->value($value);
        }

        return $this->formGroup($label, $name, $control);
    }
    public function hidden($name, $value = null)
    {
        return $this->builder->hidden($name)->value($value);
    }
    public function radios(string $name, ?string $label = null, array $choices = [], ?string $checkedValue = null, bool $inline = false, array $options = []): string
    {
        $elements = '';

        foreach ($choices as $value => $choiceLabel) {
            $checked = $value === $checkedValue;
            $radio = $this->builder->radio($name, $value)->checked($checked);
            if ($inline) {
                $radio->inline();
            }
            $elements .= '<div class="radio' . ($inline ? ' inline' : '') . '">' . (string)$this->wrapRadio($choiceLabel, $radio) . '</div>';
        }

        $labelElement = $this->builder->label($label)->addClass('control-label');
        $controlElement = new DivElement($elements);

        $formGroup = new FormGroup($labelElement, $controlElement);

        return (string) $this->wrap($formGroup);
    }

    protected function wrapRadio($label, Element $control)
    {
        return $this->builder->label($label)->after($control)->addClass('radio-inline');
    }


    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->builder, $method], $parameters);
    }
}