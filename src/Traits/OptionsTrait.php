<?php

namespace ArgentCrusade\Forms\Traits;

use ArgentCrusade\Forms\FormField;

trait OptionsTrait
{
    /**
     * OptionsTrait constructor.
     *
     * @param string $label
     * @param array  $options
     */
    public function __construct(string $label, array $options = [])
    {
        parent::__construct($label);

        $this->withOptions($options);
    }

    /**
     * Set options list.
     *
     * @param array $options
     *
     * @return FormField
     */
    public function withOptions(array $options)
    {
        return $this->withParameter('options', $options);
    }

    /**
     * Get options list.
     *
     * @return array
     */
    public function options()
    {
        return $this->getParameter('options', []);
    }
}
