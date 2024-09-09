<?php

namespace AdamWathan\BootForms\Elements;

use AdamWathan\Form\Elements\Input;

class Hidden extends Input
{
    protected $attributes = [
        'type' => 'hidden',
    ];
}
