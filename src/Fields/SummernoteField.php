<?php

namespace ArgentCrusade\Forms\Fields;

use ArgentCrusade\Forms\FormField;

class SummernoteField extends FormField
{
    const DEFAULT_HEIGHT = 150;

    protected $type = 'summernote';

    /**
     * Set editor height.
     *
     * @param int $height
     *
     * @return SummernoteField
     */
    public function withHeight(int $height)
    {
        return $this->withParameter('height', $height);
    }

    /**
     * Get editor height.
     *
     * @return int
     */
    public function height()
    {
        return $this->getParameter('height', static::DEFAULT_HEIGHT);
    }

    /**
     * Set upload URL.
     *
     * @param string $url
     *
     * @return SummernoteField
     */
    public function withUploadUrl(string $url)
    {
        return $this->withParameter('upload_url', $url);
    }

    /**
     * Get upload URL.
     *
     * @return string|null
     */
    public function uploadUrl()
    {
        return $this->getParameter('upload_url');
    }
}
