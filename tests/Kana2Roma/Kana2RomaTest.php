<?php
require_once( __DIR__ . '/../../src/Kana2Roma.php' );
use PHPUnit\Framework\TestCase;
use Hikarine3\Kana2Roma;

class Kana2RomaTest extends TestCase
{
    private $parser;

    public function testConstruct() {
        $this->k2r = new Kana2Roma;
        $this->assertInstanceOf(
            "Hikarine3\Kana2Roma",
            $this->k2r
        );
    }

    public function testConvert() {
        $k2r = new Kana2Roma;
        $this->assertEquals( $k2r->convert('あいうえお') , 'aiueo');
        $this->assertEquals( $k2r->convert('アイウエオ') , 'aiueo');
        $this->assertEquals( $k2r->convert('にーな') , 'niina');
        $this->assertEquals( $k2r->convert('ニーナ') , 'niina');
        $this->assertEquals( $k2r->convert('なーなー') , 'naanaa');
        $this->assertEquals( $k2r->convert('ナーナー') , 'naanaa');
        $this->assertEquals( $k2r->convert('にな') , 'nina');
        $this->assertEquals( $k2r->convert('ニナ') , 'nina');
        $this->assertEquals( $k2r->convert('なな') , 'nana');
        $this->assertEquals( $k2r->convert('ナナ') , 'nana');
        $this->assertEquals( $k2r->convert('ぼく') , 'boku');
        $this->assertEquals( $k2r->convert('はっとり') , 'hattori');
        $this->assertEquals( $k2r->convert('なんば') , 'nanba'); // m is better
        $this->assertEquals( $k2r->convert('とっても') , 'tottemo');
        $this->assertEquals( $k2r->convert('きみを') , 'kimiwo');
        $this->assertEquals( $k2r->convert('ぐやじい') , 'guyajii');
        $this->assertEquals( $k2r->convert('ぱっぱらぱー') , 'papparapaa');
        $this->assertEquals( $k2r->convert('くりたはじめ') , 'kuritahajime');
        $this->assertEquals( $k2r->convert('しょうけんがいしゃ') , 'shoukengaisha');
        $this->assertEquals( $k2r->convert('ひゅうが') , 'hyuuga');
        $this->assertEquals( $k2r->convert('しょうが') , 'shouga');
        $this->assertEquals( $k2r->convert('こうた') , 'kouta');
        $this->assertEquals( $k2r->convert('おおた') , 'oota');
    }
}
