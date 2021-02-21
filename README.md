# What is KanaToRoma?
Create Romaji string from Katakana of Japanese

ひらがなの入力をローマ字に変換するPHPのライブラリ

他のMITライセンスの情報を起点に作らせて頂いています。

https://tenderfeel.xsrv.jp/mootools/382/

https://gist.github.com/kijtra/984256/07ebd33785c409138c9126c1a144f984798a893e

# How to install / どうインストールするか
```
composer require hikarine3/roma2kana;
```

そしてcomposer.jsonのautoloadのセクションに追加してからcomposer dump-autoloadと打って下さい
```

    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        },
        "classmap": [
            "vendor/hikarine3/csv-parser/src",
            "vendor/hikarine3/kana2roma/src"
        ]
    },
```

# How to use / どう使うか

```
use Hikarine3\Kana2Roma;
$hiragana = 'ぼく';
$k2r = Kana2Roma;
print( $k2r->convert($hiragana) );
```

Result
```
boku
```

処理としては

にーな => niina

にな => nina

と長音有無を区別する処理をしています。

# How to test

Install phpunit first. Then under root directory of this library,

```
phpunit tests;
```

# Partially supported
カタカナは部分的にサポートしています
(「ヴ」の処理が未対応)


# License / ライセンス / 执照

MIT

# Author / 作者

## Name / 名前 / 全名
Hajime Kurita

## Twitter
- EN: https://twitter.com/hajimekurita
- JP: https://twitter.com/hikarine3

## Technical web services / 提供してる技術関連Webサービス / 技术网络服务
### VPS & Infra comparison / VPS比較 / VPS比较
- EN: https://vpsranking.com/en/
- CN: https://vpsranking.com/zh/
- JP: https://vpshikaku.com/

### Programming Language Comparison / プログラミング言語比較 / 编程语言比较
- EN: https://programminglang.com/en/
- CN: https://programminglang.com/zh/
- JP: https://programminglang.com/ja/

### OSS
- Docker: https://hub.docker.com/u/1stclass/
- Github: https://github.com/hikarine3
- NPM: https://www.npmjs.com/~hikarine3
- Perl: http://search.cpan.org/~hikarine/
- PHP: https://packagist.org/packages/hikarine3/
- Python: https://pypi.org/user/hikarine3/
