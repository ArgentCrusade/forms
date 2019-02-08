<?php

namespace ArgentCrusade\Forms\Fields;

use ArgentCrusade\Forms\FormField;
use ArgentCrusade\Forms\Traits\OptionsTrait;

class RadioField extends FormField
{
    use OptionsTrait;

    protected $type = 'radio';
}
