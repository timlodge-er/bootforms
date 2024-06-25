<?php namespace AdamWathan\BootForms;

use AdamWathan\BootForms\Elements\CheckGroup;
use AdamWathan\BootForms\Elements\FormGroup;
use AdamWathan\BootForms\Elements\GroupWrapper;
use AdamWathan\BootForms\Elements\HelpBlock;
use AdamWathan\BootForms\Elements\InputGroup;
use AdamWathan\Form\FormBuilder;

class BasicFormBuilder
{
    protected $builder;

    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    protected function formGroup($label, $name, $control)
    {
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

    public function text( $name, $label, $value = null)
    {
        $control = $this->builder->text($name)->value($value);

        return $this->formGroup($label, $name, $control);
    }
    public function number($label, $name, $value = null)
    {
        $control = $this->builder->number($name)->value($value);

        return $this->formGroup( $name, $label, $control);
    }


    public function password($label, $name)
    {
        $control = $this->builder->password($name);

        return $this->formGroup($label, $name, $control);
    }

    public function button($value, $name = null, $type = "btn-default")
    {
        return $this->builder->button($value, $name)->addClass('btn')->addClass($type);
    }

    public function submit($value = "Submit", $type = "btn-default")
    {
        return $this->builder->submit($value)->addClass('btn')->addClass($type);
    }

    public function select($name,$label, $options = [])
    {
        $control = $this->builder->select($name, $label, $options);

        return $this->formGroup($label, $name, $control);
    }

    public function checkbox($name,$label)
    {
        $control = $this->builder->checkbox($name);

        return $this->checkGroup($label, $name, $control);
    }

    public function inlineCheckbox( $name, $label)
    {
        return $this->checkbox($label, $name)->inline();
    }

    protected function checkGroup($name, $label,$control)
    {
        $checkGroup = $this->buildCheckGroup($label, $name, $control);
        return $this->wrap($checkGroup->addClass('checkbox'));
    }

    protected function buildCheckGroup( $name,$label, $control)
    {
        $label = $this->builder->label($label, $name)->after($control)->addClass('control-label');

        $checkGroup = new CheckGroup($label);

        if ($this->builder->hasError($name)) {
            $checkGroup->helpBlock($this->builder->getError($name));
            $checkGroup->addClass('has-error');
        }
        return $checkGroup;
    }

    public function radio( $name,$label, $value = null)
    {
        if (is_null($value)) {
            $value = $label;
        }

        $control = $this->builder->radio($name, $value);

        return $this->radioGroup($label, $name, $control);
    }

    public function inlineRadio( $name,$label, $value = null)
    {
        return $this->radio($label, $name, $value)->inline();
    }

    protected function radioGroup($name, $label, $control)
    {
        $checkGroup = $this->buildCheckGroup($label, $name, $control);
        return $this->wrap($checkGroup->addClass('radio'));
    }

    public function textarea(  $name,$label,$value = null, $attributes = [])
    {
        $control = $this->builder->textarea($name)->value($value);

        foreach ($attributes as $key => $value) {
            $control->setAttribute($key, $value);
        }

        return $this->formGroup($name, $label, $control);
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

    public function file( $name,$label, $value = null)
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

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->builder, $method], $parameters);
    }
}
