<?php namespace Ixudra\Translation;


use Illuminate\Support\Facades\Lang;

class LanguageHelperTest extends \PHPUnit_Framework_TestCase {

    protected $languageHelper;


    public function setUp()
    {
        parent::setUp();

        $this->languageHelper = new LanguageHelper();
    }


    /**
     * @covers LanguageHelper::get()
     */
    public function testGet_returnsApplicationValueIfExists()
    {
        Lang::shouldReceive('has')->once()->with('Foo')->andReturn(true);
        Lang::shouldReceive('get')->once()->with('Foo', array())->andReturn('Baz');

        $this->assertEquals('Baz', $this->languageHelper->get('Foo'));
    }

    /**
     * @covers LanguageHelper::get()
     */
    public function testGet_returnsPackageValueIfApplicationValueDoesNotExist()
    {
        Lang::shouldReceive('has')->once()->with('Foo')->andReturn(false);
        Lang::shouldReceive('has')->once()->with('translation::Foo')->andReturn(true);
        Lang::shouldReceive('get')->once()->with('translation::Foo', array())->andReturn('Baz');

        $this->assertEquals('Baz', $this->languageHelper->get('Foo'));
    }

    /**
     * @covers LanguageHelper::get()
     */
    public function testGet_returnsKeyIfNoTranslationsExist()
    {
        Lang::shouldReceive('has')->once()->with('Foo')->andReturn(false);
        Lang::shouldReceive('has')->once()->with('translation::Foo')->andReturn(false);

        $this->assertEquals('Foo', $this->languageHelper->get('Foo'));
    }

    /**
     * @covers LanguageHelper::get()
     */
    public function testHas_returnsTrueIfApplicationValueExists()
    {
        Lang::shouldReceive('has')->once()->with('Foo')->andReturn(true);

        $this->assertTrue( $this->languageHelper->has('Foo') );
    }

    /**
     * @covers LanguageHelper::get()
     */
    public function testHas_returnsTrueIfPackageValueExists()
    {
        Lang::shouldReceive('has')->once()->with('Foo')->andReturn(false);
        Lang::shouldReceive('has')->once()->with('translation::Foo')->andReturn(true);

        $this->assertTrue( $this->languageHelper->has('Foo') );
    }

    /**
     * @covers LanguageHelper::get()
     */
    public function testHas_returnsFalseIfValueDoesNotExist()
    {
        Lang::shouldReceive('has')->once()->with('Foo')->andReturn(false);
        Lang::shouldReceive('has')->once()->with('translation::Foo')->andReturn(false);

        $this->assertFalse( $this->languageHelper->has('Foo') );
    }

}