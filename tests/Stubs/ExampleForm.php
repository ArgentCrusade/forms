<?php

namespace ArgentCrusade\Forms\Tests\Stubs;

use ArgentCrusade\Forms\Fields\EmailField;
use ArgentCrusade\Forms\Fields\FileField;
use ArgentCrusade\Forms\Fields\PasswordField;
use ArgentCrusade\Forms\Fields\TextField;
use ArgentCrusade\Forms\Form;

class ExampleForm extends Form
{
    public function id()
    {
        return 'ExampleForm';
    }

    public function method()
    {
        return 'POST';
    }

    public function action()
    {
        return 'https://example.org';
    }

    public function fields()
    {
        return [
            'name' => new TextField('Name'),
            'email' => new EmailField('Email'),
            'password' => (new PasswordField('Password'))->withClasses('password-visible'),
            'photo_file' => new FileField('Photo'),
            'mutated_input' => new TextField('Mutated'),
        ];
    }

    public function values()
    {
        return [
            'name' => 'John Doe',
            'email' => 'john@example.org',
            'password' => 'secret',
            'photo' => 'https://example.org/image.png',
            'mutated_input' => $this->getMutatedInputValue(),
        ];
    }

    public function getMutatedInputValue($old = null)
    {
        if (is_null($old)) {
            return 'default value';
        }

        return 'mutated from old value, old: "'.$old.'"';
    }
}
