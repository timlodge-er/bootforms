<?php namespace AdamWathan\BootForms;

class BootForm
{
    protected $builder;
    protected $basicFormBuilder;
    protected $horizontalFormBuilder;

    public function __construct(BasicFormBuilder $basicFormBuilder, HorizontalFormBuilder $horizontalFormBuilder)
    {
        $this->basicFormBuilder = $basicFormBuilder;
        $this->horizontalFormBuilder = $horizontalFormBuilder;
    }

    public function open()
    {
        $this->builder = $this->basicFormBuilder;
        return $this->builder->open();
    }

    public function openHorizontal($columnSizes)
    {
        $this->horizontalFormBuilder->setColumnSizes($columnSizes);
        $this->builder = $this->horizontalFormBuilder;
        return $this->builder->open();
    }

    public function __call($method, $parameters)
    {
        if (is_null($this->builder)) {
            throw new \BadMethodCallException("Builder is not initialized. Call open() or openHorizontal() first.");
        }

        if (!method_exists($this->builder, $method)) {
            throw new \BadMethodCallException("Method {$method} does not exist on the builder object.");
        }

        return call_user_func_array([$this->builder, $method], $parameters);
    }
}