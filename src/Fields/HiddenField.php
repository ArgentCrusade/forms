<?php

namespace ArgentCrusade\Forms\Fields;

use ArgentCrusade\Forms\FormField;

class HiddenField extends FormField
{
    protected $type = 'hidden';

    /**
     * HiddenField constructor.
     */
    public function __construct()
    {
        parent::__construct('');
    }

    /**
     * Determines whether the field is using its own markup.
     *
     * @return bool
     */
    public function usingOwnMarkup()
    {
        return true;
    }
}
