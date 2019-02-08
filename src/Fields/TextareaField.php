<?php

namespace ArgentCrusade\Forms\Fields;

use ArgentCrusade\Forms\FormField;

class TextareaField extends FormField
{
    protected $type = 'textarea';

    /**
     * Set rows count.
     *
     * @param int $rows
     *
     * @return TextareaField
     */
    public function withRows(int $rows)
    {
        return $this->withAttribute('rows', $rows);
    }

    /**
     * Get rows count.
     *
     * @return int|null
     */
    public function rows()
    {
        return $this->getAttribute('rows');
    }

    /**
     * Set columns count.
     *
     * @param int $cols
     *
     * @return TextareaField
     */
    public function withCols(int $cols)
    {
        return $this->withAttribute('cols', $cols);
    }

    /**
     * Get columns count.
     *
     * @return int|null
     */
    public function cols()
    {
        return $this->getAttribute('cols');
    }
}
