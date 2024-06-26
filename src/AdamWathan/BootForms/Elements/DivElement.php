<?php namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Element;
class DivElement extends Element
{
    protected $content;

    public function __construct($content = '')
    {
        $this->content = $content;
    }

    public function render()
    {
        return '<div' . $this->renderAttributes() . '>' . $this->content . '</div>';
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
}