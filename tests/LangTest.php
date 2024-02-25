<?php
use Iwan07\Lang\Exception\NoMessageLangException;
use Iwan07\Lang\Exception\UnexpectedFormatLangException;
use Iwan07\Lang\Lang;
use PHPUnit\Framework\TestCase;

class LangTest extends TestCase
{
    public function testSlavic()
    {
        Lang::setLanguage('ru');
        $lang = new Lang;
        $this->assertEquals( "Главная страница",    $lang->main_page                );
        $this->assertEquals( "Главная страница",    $lang->msg('main_page')         );
        $this->assertEquals( "ссылка",              $lang->links                    );
        $this->assertEquals( "1 ссылка",            $lang->num(1, 'links')          );
        $this->assertEquals( "ссылка",              $lang->num(1, 'links', false)   );
        $this->assertEquals( "3 ссылки",            $lang->num(3, 'links')          );
        $this->assertEquals( "ссылки",              $lang->num(3, 'links', false)   );
        $this->assertEquals( "6 ссылок",            $lang->num(6, 'links')          );
        $this->assertEquals( "ссылок",              $lang->num(6, 'links', false)   );
    }

    public function testRoman()
    {
        Lang::setLanguage('en');
        $lang = new Lang;
        $this->assertEquals( "Main page",   $lang->main_page                );
        $this->assertEquals( "Main page",   $lang->msg('main_page')         );
        $this->assertEquals( "link",        $lang->links                    );
        $this->assertEquals( "1 link",      $lang->num(1, 'links')          );
        $this->assertEquals( "link",        $lang->num(1, 'links', false)   );
        $this->assertEquals( "3 links",     $lang->num(3, 'links')          );
        $this->assertEquals( "links",       $lang->num(3, 'links', false)   );
        $this->assertEquals( "6 links",     $lang->num(6, 'links')          );
        $this->assertEquals( "links",       $lang->num(6, 'links', false)   );
    }

    public function testNoMessageException()
    {
        $this->expectException(NoMessageLangException::class);
        $lang = new Lang;
        $lang->wrong_message_label;
    }

    public function testUnexpectedFormatException()
    {
        $this->expectException(UnexpectedFormatLangException::class);
        $lang = new Lang;
        $lang->wrong_format;
    }
}