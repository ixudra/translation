<?php namespace Ixudra\Translation;


use Illuminate\Support\Facades\Lang;
use PHPUnit\Framework\TestCase;

class TranslationServiceTest extends TestCase {

    /**
     * @covers TranslationService::message()
     */
    public function testMessage()
    {
        $languageHelperMock = \Mockery::mock('Ixudra\Translation\LanguageHelper');
        $languageHelperMock->shouldReceive('has')->once()->with('models.Foo.singular')->andReturn(false);
        $languageHelperMock->shouldReceive('get')->once()->with('Foo.Bar')->andReturn('Baz');

        $translationService = new TranslationService( $languageHelperMock );

        $this->assertEquals('Baz', $translationService->message('Foo.Bar'));
    }

    /**
     * @covers TranslationService::message()
     * @covers TranslationService::model()
     */
    public function testMessage_translatesModelMessageIfPossible()
    {
        $languageHelperMock = \Mockery::mock('Ixudra\Translation\LanguageHelper');
        $languageHelperMock->shouldReceive('has')->once()->with('models.Foo.singular')->andReturn(true);

        $languageHelperMock->shouldReceive('get')->once()->with('models.Foo.singular')->andReturn('Foz');
        $languageHelperMock->shouldReceive('get')->once()->with('models.Foo.article')->andReturn('Baz');
        $languageHelperMock->shouldReceive('get')->once()->with('model.Bar', array( 'model' => 'Foz', 'article' => 'Baz' ))->andReturn('FooBar');

        $translationService = new TranslationService( $languageHelperMock );

        $this->assertEquals('FooBar', $translationService->message('Foo.Bar'));
    }

    /**
     * @covers TranslationService::model()
     */
    public function testModel()
    {
        $languageHelperMock = \Mockery::mock('Ixudra\Translation\LanguageHelper');
        $languageHelperMock->shouldReceive('get')->once()->with('models.Foo.singular')->andReturn('Foz');
        $languageHelperMock->shouldReceive('get')->once()->with('models.Foo.article')->andReturn('Baz');
        $languageHelperMock->shouldReceive('get')->once()->with('model.Bar', array( 'model' => 'Foz', 'article' => 'Baz' ))->andReturn('FooBar');

        $translationService = new TranslationService( $languageHelperMock );

        $this->assertEquals('FooBar', $translationService->model('Foo.Bar'));
    }

    /**
     * @covers TranslationService::recursive()
     */
    public function testRecursive()
    {
        $languageHelperMock = \Mockery::mock('Ixudra\Translation\LanguageHelper');
        $languageHelperMock->shouldReceive('has')->once()->with('admin.menu.title.new')->andReturn(true);
        $languageHelperMock->shouldReceive('get')->once()->with('admin.menu.title.new')->andReturn('new ##models.:model.singular##');
        $languageHelperMock->shouldReceive('get')->once()->with('models.user.singular')->andReturn('user');

        $translationService = new TranslationService( $languageHelperMock );

        $this->assertEquals('New user', $translationService->recursive('admin.menu.title.new', array('model' => 'user')));
    }

    /**
     * @covers TranslationService::recursive()
     */
    public function testRecursive_translatesMultipleMarkers()
    {
        $languageHelperMock = \Mockery::mock('Ixudra\Translation\LanguageHelper');
        $languageHelperMock->shouldReceive('has')->once()->with('admin.menu.title.new')->andReturn(true);
        $languageHelperMock->shouldReceive('get')->once()->with('admin.menu.title.new')->andReturn('no ##models.:model.singular## for the ##models.:value.singular##');
        $languageHelperMock->shouldReceive('get')->once()->with('models.user.singular')->andReturn('rest');
        $languageHelperMock->shouldReceive('get')->once()->with('models.other.singular')->andReturn('wicked');

        $translationService = new TranslationService( $languageHelperMock );

        $this->assertEquals('No rest for the wicked', $translationService->recursive('admin.menu.title.new', array('model' => 'user', 'value' => 'other')));
    }

    /**
     * @covers TranslationService::recursive()
     */
    public function testRecursive_noUcFirstIfNotRequired()
    {
        $languageHelperMock = \Mockery::mock('Ixudra\Translation\LanguageHelper');
        $languageHelperMock->shouldReceive('has')->once()->with('admin.menu.title.new')->andReturn(true);
        $languageHelperMock->shouldReceive('get')->once()->with('admin.menu.title.new')->andReturn('new ##models.:model.singular##');
        $languageHelperMock->shouldReceive('get')->once()->with('models.user.singular')->andReturn('user');

        $translationService = new TranslationService( $languageHelperMock );

        $this->assertEquals('new user', $translationService->recursive('admin.menu.title.new', array('model' => 'user'), false));
    }

}
