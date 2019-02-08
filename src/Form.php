<?php

namespace ArgentCrusade\Forms;

use Illuminate\Support\Str;

abstract class Form
{
    const DEFAULT_LABEL_COLUMN_SIZE = 2;
    const DEFAULT_INPUT_COLUMN_SIZE = 10;

    /**
     * @var array
     */
    protected $excludeFromExtra = [
        'method', 'action', 'class', 'enctype',
    ];

    /** @var string */
    protected $formId;

    /** @var string */
    protected $redirectUrl;
    protected $cachedValues = [];
    protected $cachedFields = [];

    /**
     * Get the form's HTTP method.
     *
     * @return string
     */
    abstract public function method();

    /**
     * Get the form's action URL.
     *
     * @return string
     */
    abstract public function action();

    /**
     * Get the form's fields.
     *
     * @return array
     */
    abstract public function fields();

    /**
     * Get the cancel button URL.
     *
     * @return string
     */
    public function cancelUrl()
    {
        return '';
    }

    /**
     * Additional form options.
     *
     * @return array
     */
    public function options()
    {
        return [];
    }

    /**
     * Determines if current form contains file fields.
     *
     * @return bool
     */
    public function withUploads()
    {
        return false;
    }

    /**
     * Form values (editing mode).
     *
     * @return array
     */
    public function values()
    {
        return [];
    }

    /**
     * Unique form ID.
     *
     * @return string
     */
    public function id()
    {
        if (!is_null($this->formId)) {
            return $this->formId;
        }

        return $this->formId = 'abstract-form-'.rand();
    }

    /**
     * Get the submit button label.
     *
     * @return string
     */
    public function submitLabel()
    {
        return 'Submit';
    }

    /**
     * Get the cancel button label.
     *
     * @return string
     */
    public function cancelLabel()
    {
        return 'Cancel';
    }

    /**
     * Get the label column size.
     *
     * @return int
     */
    public function labelColumnSize()
    {
        return static::DEFAULT_LABEL_COLUMN_SIZE;
    }

    /**
     * Get the input column size.
     *
     * @return int
     */
    public function inputColumnSize()
    {
        return static::DEFAULT_INPUT_COLUMN_SIZE;
    }

    /**
     * Get the form option value.
     *
     * @param string $path
     * @param null   $default
     *
     * @return mixed
     */
    public function get(string $path, $default = null)
    {
        return array_get($this->options(), $path, $default);
    }

    /**
     * Form's extra attributes.
     *
     * @param array $attributes
     *
     * @return string
     */
    public function extraAttributes(array $attributes = [])
    {
        return collect($this->onlyExtraAttributes($attributes))
            ->map(function (string $value, string $attribute) {
                return $attribute.'="'.$value.'"';
            })
            ->implode(' ');
    }

    /**
     * Get only extra form attributes.
     *
     * @param array $attributes
     *
     * @return array
     */
    public function onlyExtraAttributes(array $attributes = [])
    {
        $attributes = $attributes ?: $this->get('attributes', []);

        foreach ($this->excludeFromExtra as $attribute) {
            if (isset($attributes[$attribute])) {
                unset($attributes[$attribute]);
            }
        }

        return $attributes;
    }

    /**
     * Get the cached form values.
     *
     * @return array
     */
    protected function cachedValues()
    {
        if ($this->cachedValues) {
            return $this->cachedValues;
        }

        return $this->cachedValues = $this->values();
    }

    /**
     * Get the cached form fields.
     *
     * @return array
     */
    protected function cachedFields()
    {
        if ($this->cachedFields) {
            return $this->cachedFields;
        }

        return $this->cachedFields = $this->fields();
    }

    /**
     * Set redirect URL.
     *
     * @param string $url
     *
     * @return $this
     */
    public function setRedirectUrl(string $url)
    {
        $this->redirectUrl = $url;

        return $this;
    }

    /**
     * Get the redirect URL.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * Get the form field by name.
     *
     * @param string $name
     *
     * @return FormField
     */
    public function getField(string $name)
    {
        return array_get($this->cachedFields(), $name);
    }

    /**
     * Generates ID for given input element.
     *
     * @param string $name
     *
     * @return string
     */
    public function inputId(string $name)
    {
        return Str::camel($this->id().'_input_'.Str::lower($name));
    }

    /**
     * Get the field value.
     *
     * @param string $name
     * @param null   $default
     *
     * @return mixed|string
     */
    public function fieldValue(string $name, $default = null)
    {
        $value = array_get($this->cachedValues(), $name, $default);
        $oldValue = old($name);

        if ($oldValue && method_exists($this, $mutatorMethod = Str::camel('get_'.$name.'_value'))) {
            return call_user_func([$this, $mutatorMethod], $oldValue);
        }

        return $oldValue ?? $value;
    }
}
