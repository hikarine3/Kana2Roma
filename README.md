# KanaToRoma
Create Romaji string from Katakana of Japanese

ひらがなの入力をローマ字に変換するPHPのライブラリ

他のMITライセンスの情報を起点に作らせて頂いています。

https://tenderfeel.xsrv.jp/mootools/382/

https://gist.github.com/kijtra/984256/07ebd33785c409138c9126c1a144f984798a893e


# How to use / どう使うか

```
use Hikarine3\Kana2Roma;
$hiragana = 'ぼく';
$k2r = Kana2Roma;
$k2r-print($hiragana);
```

Result
```
boku
```

# How to test

Install phpunit first. Then under root directory of this library,

```
phpunit tests;
```


# Started from other MIT license repositories
