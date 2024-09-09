<?php

namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\FormControl;


class Select extends FormControl
{
    protected $options;

    protected $selected;

    public function __construct($name, $options = [])
    {
        $this->setName($name);
        $this->setOptions($options);
    }

    public function select($name, $label, $options = [], $selected = null, $attributes = [])
    {
        $control = $this->builder->select($name, $options, $selected);

        // Loop through the attributes to find 'class'
        $classFound = false;
        foreach ($attributes as $key => $value) {
            if ($key === 'class') {
                // Append the 'category-select2' class
                $attributes[$key] .= ' category-select2';
                $classFound = true;
                break;
            }
        }

        // If 'class' attribute is not found, add it
        if (!$classFound) {
            $attributes['class'] = 'category-select2';
        }

        // Add all attributes to the control
        foreach ($attributes as $key => $value) {
            $control->setAttribute($key, $value);
        }

        return $this->formGroup($label, $name, $control);
    }

    protected function setOptions($options)
    {
        $this->options = $options;
    }

    public function options($options)
    {
        $this->setOptions($options);

        return $this;
    }

    public function render()
    {
        return implode([
            sprintf('<select%s>', $this->renderAttributes()),
            $this->renderOptions(),
            '</select>',
        ]);
    }

    protected function renderOptions()
    {
        list($values, $labels) = $this->splitKeysAndValues($this->options);

        $tags = array_map(function ($value, $label) {
            if (is_array($label)) {
                return $this->renderOptGroup($value, $label);
            }
            return $this->renderOption($value, $label);
        }, $values, $labels);

        return implode($tags);
    }

    protected function renderOptGroup($label, $options)
    {
        list($values, $labels) = $this->splitKeysAndValues($options);

        $options = array_map(function ($value, $label) {
            return $this->renderOption($value, $label);
        }, $values, $labels);

        return implode([
            sprintf('<optgroup label="%s">', $label),
            implode($options),
            '</optgroup>',
        ]);
    }

    protected function renderOption($value, $label)
    {
        return vsprintf('<option value="%s"%s>%s</option>', [
            $this->escape($value),
            $this->isSelected($value) ? ' selected' : '',
            $this->escape($label),
        ]);
    }

    protected function isSelected($value)
    {
        return in_array($value, (array) $this->selected);
    }

    public function addOption($value, $label)
    {
        $this->options[$value] = $label;

        return $this;
    }

    public function defaultValue($value)
    {
        if (isset($this->selected)) {
            return $this;
        }

        $this->select($value);

        return $this;
    }

    public function multiple()
    {
        $name = $this->attributes['name'];
        if (substr($name, -2) != '[]') {
            $name .= '[]';
        }

        $this->setName($name);
        $this->setAttribute('multiple', 'multiple');

        return $this;
    }
}
