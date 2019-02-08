<?php

namespace ArgentCrusade\Forms\Fields;

class PhoneField extends TextField
{
    /**
     * Get field subtype.
     *
     * @return string
     */
    public function subtype()
    {
        return 'tel';
    }
}
