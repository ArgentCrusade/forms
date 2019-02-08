<?php

namespace ArgentCrusade\Forms\Tests;

use ArgentCrusade\Forms\Fields\CheckboxField;
use ArgentCrusade\Forms\Fields\FileField;
use ArgentCrusade\Forms\Fields\HiddenField;
use ArgentCrusade\Forms\Fields\RadioField;
use ArgentCrusade\Forms\Fields\SelectField;
use ArgentCrusade\Forms\Fields\SummernoteField;
use ArgentCrusade\Forms\Fields\TextareaField;
use ArgentCrusade\Forms\Fields\TextField;
use ArgentCrusade\Forms\FormField;
use PHPUnit\Framework\TestCase;

class FormFieldsTest extends TestCase
{
    public function testLabel()
    {
        $this->assertSame('Example', (new FormField('Example'))->label());
        $this->assertSame('Second Example', (new FormField('Example'))->withLabel('Second Example')->label());
    }

    public function testType()
    {
        $this->assertSame('text', (new FormField('Example'))->withType('text')->type());
    }

    public function testValue()
    {
        $this->assertSame('value', (new FormField('Example'))->withValue('value')->value());
    }

    public function testHint()
    {
        $this->assertSame('hint', (new FormField('Example'))->withHint('hint')->hint());
        $this->assertFalse((new FormField('Example'))->hasHint());
        $this->assertTrue((new FormField('Example'))->withHint('hint')->hasHint());
    }

    public function testAttributes()
    {
        $field = new FormField('Example');
        $this->assertEmpty($field->attributes());

        $field->withAttribute('first', 'test');
        $this->assertTrue($field->hasAttribute('first'));
        $this->assertSame('test', $field->getAttribute('first'));
        $this->assertFalse($field->hasAttribute('second'));

        $field->withAttributes(['second' => 'test']);
        $this->assertTrue($field->hasAttribute('second'));

        $field->withAttributes(['third' => 'test'], true);
        $this->assertFalse($field->hasAttribute('first'));
        $this->assertFalse($field->hasAttribute('second'));
        $this->assertTrue($field->hasAttribute('third'));

        $this->assertSame('third="test"', $field->joinAttributes());
    }

    public function testParameters()
    {
        $field = new FormField('Example');
        $this->assertEmpty($field->parameters());

        $field->withParameter('first', 'test');
        $this->assertTrue($field->hasParameter('first'));
        $this->assertSame('test', $field->getParameter('first'));
        $this->assertFalse($field->hasParameter('second'));

        $field->withParameters(['second' => 'test']);
        $this->assertTrue($field->hasParameter('second'));

        $field->withParameters(['third' => 'test'], true);
        $this->assertFalse($field->hasParameter('first'));
        $this->assertFalse($field->hasParameter('second'));
        $this->assertTrue($field->hasParameter('third'));
    }

    public function testClasses()
    {
        $field = new FormField('Example');
        $this->assertEmpty($field->classes());

        $field->withClasses('first second');
        $this->assertInternalType('array', $field->classList());
        $this->assertSame(['first', 'second'], $field->classList());

        $field->withClasses('third fourth', true);
        $this->assertInternalType('array', $field->classList());
        $this->assertSame(['third', 'fourth'], $field->classList());

        $this->assertSame('third fourth', $field->classes());
        $this->assertSame('third fourth fifth', $field->classes('fifth'));
        $this->assertSame('third fourth fifth sixth', $field->classes(['fifth', 'sixth']));
    }

    public function testCheckboxField()
    {
        $field = new CheckboxField('Example');
        $this->assertSame('checkbox', $field->type());
        $this->assertTrue($field->usingOwnMarkup());
    }

    public function testFileField()
    {
        $field = (new FileField('Example'))
            ->withUploadUrl('https://example.org/upload')
            ->withUploadType('image')
            ->withDisplayName('example.jpg');

        $this->assertSame('file', $field->type());
        $this->assertSame('https://example.org/upload', $field->uploadUrl());
        $this->assertSame('image', $field->uploadType());
        $this->assertSame('example.jpg', $field->displayName());
    }

    public function testHiddenField()
    {
        $field = new HiddenField();
        $this->assertSame('hidden', $field->type());
        $this->assertTrue($field->usingOwnMarkup());
    }

    public function testRadioField()
    {
        $field = new RadioField('Example', [1 => 'First', 2 => 'Second']);
        $this->assertSame('radio', $field->type());
        $this->assertSame([1 => 'First', 2 => 'Second'], $field->options());

        $field->withOptions([3 => 'Third', 4 => 'Fourth']);
        $this->assertSame([3 => 'Third', 4 => 'Fourth'], $field->options());
    }

    public function testSelectField()
    {
        $field = new SelectField('Example', [1 => 'First', 2 => 'Second']);
        $this->assertSame('select', $field->type());
        $this->assertSame([1 => 'First', 2 => 'Second'], $field->options());

        $field->withOptions([3 => 'Third', 4 => 'Fourth']);
        $this->assertSame([3 => 'Third', 4 => 'Fourth'], $field->options());

        $this->assertFalse($field->multiple());
        $this->assertTrue($field->asMultiple()->multiple());
        $this->assertFalse($field->asMultiple(false)->multiple());
    }

    public function testSummernoteField()
    {
        $field = (new SummernoteField('Example'))
            ->withHeight(350)
            ->withUploadUrl('https://example.org/upload');

        $this->assertSame('summernote', $field->type());
        $this->assertSame(350, $field->height());
        $this->assertSame('https://example.org/upload', $field->uploadUrl());

        $this->assertSame(SummernoteField::DEFAULT_HEIGHT, (new SummernoteField('Example'))->height());
    }

    public function testTextareaField()
    {
        $field = (new TextareaField('Example'))
            ->withRows(10)
            ->withCols(20);

        $this->assertSame('textarea', $field->type());
        $this->assertSame(10, $field->rows());
        $this->assertSame(20, $field->cols());
    }

    public function testTextField()
    {
        $field = new TextField('Example');
        $this->assertSame('text', $field->type());
        $this->assertSame('text', $field->subtype());

        $this->assertSame('email', $field->asEmail()->subtype());
        $this->assertSame('password', $field->asPassword()->subtype());
        $this->assertSame('tel', $field->asPhone()->subtype());
        $this->assertSame('tel', $field->asTel()->subtype());
        $this->assertSame('datetime', $field->withSubtype('datetime')->subtype());
    }
}
