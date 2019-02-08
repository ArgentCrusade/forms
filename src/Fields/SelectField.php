<?php

namespace ArgentCrusade\Forms\Fields;

use ArgentCrusade\Forms\FormField;
use ArgentCrusade\Forms\Traits\OptionsTrait;

class SelectField extends FormField
{
    use OptionsTrait;

    protected $type = 'select';

    /**
     * Mark field as multiple.
     *
     * @param bool $state
     *
     * @return SelectField
     */
    public function asMultiple(bool $state = true)
    {
        return $this->withAttribute('multiple', $state);
    }

    /**
     * Determines whether the field is marked as multiple.
     *
     * @return bool
     */
    public function multiple()
    {
        return $this->getAttribute('multiple', false) === true;
    }
}
