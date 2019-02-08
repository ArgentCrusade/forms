<?php

namespace ArgentCrusade\Forms\Fields;

class PasswordField extends TextField
{
    /**
     * Get field subtype.
     *
     * @return string
     */
    public function subtype()
    {
        return 'password';
    }
}
