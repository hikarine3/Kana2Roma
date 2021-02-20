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
        $this->assertEquals( $k2r->convert('ぼく') , 'boku');
        $this->assertEquals( $k2r->convert('はっとり') , 'hattori');
        $this->assertEquals( $k2r->convert('なんば') , 'nanba'); // m is better
        $this->assertEquals( $k2r->convert('とっても') , 'tottemo');
        $this->assertEquals( $k2r->convert('にーな') , 'niina');
    }
}
