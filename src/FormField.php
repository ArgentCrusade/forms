<?php

namespace ArgentCrusade\Forms;

use Illuminate\Support\Arr;

class FormField
{
    protected $label = '';
    protected $type = '';
    protected $value;
    protected $attributes = [];
    protected $classes = [];
    protected $parameters = [];

    /**
     * FormField constructor.
     *
     * @param string $label
     */
    public function __construct(string $label)
    {
        $this->withLabel($label)
            ->withClasses($this->classes);
    }

    /**
     * Determines whether the field is using its own markup.
     *
     * @return bool
     */
    public function usingOwnMarkup()
    {
        return false;
    }

    /**
     * Get the field's view name.
     *
     * @param string $prefix
     *
     * @return string
     */
    public function viewName(string $prefix = '')
    {
        return ($prefix ? $prefix.'.' : '').$this->type;
    }

    /**
     * Set field label.
     *
     * @param string $label
     *
     * @return FormField
     */
    public function withLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Set field type.
     *
     * @param string $type
     *
     * @return FormField
     */
    public function withType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set field value
     *
     * @param mixed $value
     *
     * @return FormField
     */
    public function withValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Set field hint.
     *
     * @param string $hint
     *
     * @return FormField
     */
    public function withHint(string $hint)
    {
        return $this->withParameter('hint', $hint);
    }

    /**
     * Add attributes to the field.
     *
     * @param array $attributes
     * @param bool  $replace
     *
     * @return FormField
     */
    public function withAttributes(array $attributes, bool $replace = false)
    {
        return $this->mergeOrReplace('attributes', $attributes, $replace);
    }

    /**
     * Set field attribute value.
     *
     * @param string $attribute
     * @param $value
     *
     * @return FormField
     */
    public function withAttribute(string $attribute, $value)
    {
        $this->attributes[$attribute] = $value;

        return $this;
    }

    /**
     * Add parameters to the field.
     *
     * @param array $parameters
     * @param bool  $replace
     *
     * @return FormField
     */
    public function withParameters(array $parameters, bool $replace = false)
    {
        return $this->mergeOrReplace('parameters', $parameters, $replace);
    }

    /**
     * Set field parameter.
     *
     * @param string $parameter
     * @param mixed  $value
     *
     * @return FormField
     */
    public function withParameter(string $parameter, $value)
    {
        $this->parameters[$parameter] = $value;

        return $this;
    }

    /**
     * Add CSS classes to the field.
     *
     * @param array|string $classes
     * @param bool         $replace
     *
     * @return FormField|FormField
     */
    public function withClasses($classes, bool $replace = false)
    {
        if (!$classes) {
            return $this;
        }

        $this->classes = $this->normalizeClasses($this->classes);
        $classes = $this->normalizeClasses($classes);

        return $this->mergeOrReplace('classes', $classes, $replace);
    }

    /**
     * Determines whether the field has given attribute.
     *
     * @param string $path
     *
     * @return bool
     */
    public function hasAttribute(string $path)
    {
        return Arr::has($this->attributes, $path);
    }

    /**
     * Get field attribute value.
     *
     * @param string $path
     * @param mixed  $default = null
     *
     * @return mixed
     */
    public function getAttribute(string $path, $default = null)
    {
        return Arr::get($this->attributes, $path, $default);
    }

    /**
     * Get all field attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return $this->attributes;
    }

    /**
     * Get string representation of attribute-value pairs.
     *
     * @return string
     */
    public function joinAttributes()
    {
        return collect($this->attributes())
            ->map(function (string $value, string $attribute) {
                return $attribute.'="'.$value.'"';
            })
            ->implode(' ');
    }

    /**
     * Determines whether the field has given parameter.
     *
     * @param string $path
     *
     * @return bool
     */
    public function hasParameter(string $path)
    {
        return Arr::has($this->parameters, $path);
    }

    /**
     * Get parameter value.
     *
     * @param string $path
     * @param mixed  $default = null
     *
     * @return mixed
     */
    public function getParameter(string $path, $default = null)
    {
        return Arr::get($this->parameters, $path, $default);
    }

    /**
     * Get all field parameters.
     *
     * @return array
     */
    public function parameters()
    {
        return $this->parameters;
    }

    /**
     * Get field's CSS classes list.
     *
     * @return array
     */
    public function classList()
    {
        return $this->classes;
    }

    /**
     * Get string representation of the field's CSS classes list.
     *
     * @param array|string $classes = null
     *
     * @return string
     */
    public function classes($classes = null)
    {
        $mergeWith = [];

        if (!is_null($classes)) {
            $mergeWith = $this->normalizeClasses($classes);
        }

        return implode(' ', array_merge($this->classList(), $mergeWith));
    }

    /**
     * Get field label.
     *
     * @return string
     */
    public function label()
    {
        return $this->label;
    }

    /**
     * Get field type.
     *
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * Get field value.
     *
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Determines whether the field has hint.
     *
     * @return bool
     */
    public function hasHint()
    {
        return $this->hasParameter('hint');
    }

    /**
     * Get field hint.
     *
     * @return mixed
     */
    public function hint()
    {
        return $this->getParameter('hint');
    }

    /**
     * Normalize given CSS classes & transform them to array.
     *
     * @param string|array $classes
     *
     * @return array
     */
    protected function normalizeClasses($classes)
    {
        if (!is_array($classes)) {
            $classes = explode(' ', $classes);
        }

        $classes = array_filter($classes, function ($value) {
            return is_string($value) && trim($value);
        });

        if (!count($classes)) {
            return [];
        }

        return array_map(function (string $class) {
            return trim($class);
        }, $classes);
    }

    /**
     * Set field class member's value.
     *
     * @param string $field
     * @param array  $values
     * @param bool   $replace
     *
     * @return FormField
     */
    protected function mergeOrReplace(string $field, array $values, bool $replace)
    {
        if ($replace) {
            $this->{$field} = $values;
        } else {
            $this->{$field} = array_merge($this->{$field}, $values);
        }

        return $this;
    }
}
