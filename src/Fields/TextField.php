<?php

namespace ArgentCrusade\Forms\Fields;

use ArgentCrusade\Forms\FormField;

class TextField extends FormField
{
    protected $type = 'text';

    /**
     * Get field value.
     *
     * @return mixed
     */
    public function value()
    {
        if ($this->subtype() === 'password') {
            return '';
        }

        return parent::value();
    }

    /**
     * Mark field as email.
     *
     * @return TextField
     */
    public function asEmail()
    {
        return $this->withSubtype('email');
    }

    /**
     * Mark field as password.
     *
     * @return TextField
     */
    public function asPassword()
    {
        return $this->withSubtype('password');
    }

    /**
     * Mark field as phone.
     *
     * @return TextField
     */
    public function asPhone()
    {
        return $this->asTel();
    }

    /**
     * Mark field as phone.
     *
     * @return TextField
     */
    public function asTel()
    {
        return $this->withSubtype('tel');
    }

    /**
     * Set field subtype.
     *
     * @param string $subtype
     *
     * @return TextField
     */
    public function withSubtype(string $subtype = 'text')
    {
        return $this->withAttribute('type', $subtype);
    }

    /**
     * Get field subtype.
     *
     * @return string
     */
    public function subtype()
    {
        return $this->getAttribute('type', 'text');
    }
}
