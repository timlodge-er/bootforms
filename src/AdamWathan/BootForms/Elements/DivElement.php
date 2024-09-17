<?php

namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\FormControl;

class DivElement extends FormControl
{
    protected $content;

    public function __construct($content = null)
    {
        $this->setContent($content);
    }

    public function content($content)
    {
        $this->setContent($content);

        return $this;
    }

    protected function setContent($content)
    {
        $this->content = $content;
    }

    public function render()
    {
        return sprintf('<div%s>%s</div>', $this->renderAttributes(), $this->content);
    }

    public function addContent($newContent)
    {
        $this->content .= $newContent;

        return $this;
    }

    public function prependContent($newContent)
    {
        $this->content = $newContent . $this->content;

        return $this;
    }

    public function appendContent($newContent)
    {
        return $this->addContent($newContent);
    }
}