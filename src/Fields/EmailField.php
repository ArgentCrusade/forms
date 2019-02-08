<?php

namespace ArgentCrusade\Forms\Fields;

class EmailField extends TextField
{
    /**
     * Get field subtype.
     *
     * @return string
     */
    public function subtype()
    {
        return 'email';
    }
}
