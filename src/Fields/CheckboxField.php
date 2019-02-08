<?php

namespace ArgentCrusade\Forms\Fields;

use ArgentCrusade\Forms\FormField;

class CheckboxField extends FormField
{
    protected $type = 'checkbox';

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
