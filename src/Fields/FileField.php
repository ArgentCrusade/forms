<?php

namespace ArgentCrusade\Forms\Fields;

use ArgentCrusade\Forms\FormField;

class FileField extends FormField
{
    protected $type = 'file';

    /** @var mixed|null */
    protected $upload;

    /**
     * FileField constructor.
     *
     * @param string $label
     * @param mixed  $upload = null
     */
    public function __construct(string $label, $upload = null)
    {
        parent::__construct($label);

        $this->upload = $upload;
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

    /**
     * Get uploaded file instance.
     *
     * @return mixed
     */
    public function getUpload()
    {
        return $this->upload;
    }

    /**
     * Mark field as removable.
     *
     * @param bool $state
     *
     * @return FileField
     */
    public function asRemovable(bool $state = true)
    {
        return $this->withParameter('removable', $state);
    }

    /**
     * Determines whether the field is removable.
     *
     * @return bool
     */
    public function removable()
    {
        return $this->getParameter('removable', false) === true;
    }

    /**
     * Set upload type.
     *
     * @param string $uploadType
     *
     * @return FileField
     */
    public function withUploadType(string $uploadType)
    {
        return $this->withParameter('upload_type', $uploadType);
    }

    /**
     * Get upload type.
     *
     * @return string
     */
    public function uploadType()
    {
        return $this->getParameter('upload_type');
    }

    /**
     * Set upload URL.
     *
     * @param string $url
     *
     * @return FileField
     */
    public function withUploadUrl(string $url)
    {
        return $this->withParameter('upload_url', $url);
    }

    /**
     * Get upload URL.
     *
     * @return string
     */
    public function uploadUrl()
    {
        return $this->getParameter('upload_url');
    }

    /**
     * Get uploadede file's display name.
     *
     * @param string $name
     *
     * @return FileField
     */
    public function withDisplayName(string $name)
    {
        return $this->withParameter('display_name', $name);
    }

    /**
     * Get uploaded file's display name.
     *
     * @return string|null
     */
    public function displayName()
    {
        return $this->getParameter('display_name');
    }
}
