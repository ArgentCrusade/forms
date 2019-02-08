<?php

namespace ArgentCrusade\Forms\Tests;

use PHPUnit\Framework\TestCase;
use ArgentCrusade\Forms\Tests\Stubs\ExampleForm;

class FormsTest extends TestCase
{
    /**
     * @var ExampleForm
     */
    protected $form;

    protected function setUp()
    {
        parent::setUp();

        $this->form = new ExampleForm();
        \OldValuesStorage::flush();
    }

    public function testFormShouldGenerateFieldIds()
    {
        $expected = 'exampleFormInputEmail';

        $this->assertSame($expected, $this->form->inputId('email'));
        $this->assertSame($expected, $this->form->inputId('EMAIL'));
    }

    public function testFieldClassesShouldBeMissingFromExtraAttributes()
    {
        $field = $this->form->getField('password');

        $this->assertFalse(isset($this->form->onlyExtraAttributes($field->attributes())['class']));
    }

    public function testFormShouldUseMutatorsWhenPossible()
    {
        $field = $this->form->getField('mutated_input');

        $this->assertSame('default value', $this->form->fieldValue('mutated_input', $field));

        \OldValuesStorage::set('mutated_input', 'mutated input');
        $this->assertSame('mutated from old value, old: "mutated input"', $this->form->fieldValue('mutated_input', $field));
    }

    public function testFormShouldUseRedirectUrls()
    {
        $this->assertNull($this->form->getRedirectUrl());
        $this->assertSame('/example', $this->form->setRedirectUrl('/example')->getRedirectUrl());
    }
}
