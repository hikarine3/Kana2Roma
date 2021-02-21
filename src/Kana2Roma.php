<?php
/*
Official URL: https://github.com/hikarine3/Kana2Roma
Author: Hajime Kurita
*/
namespace Hikarine3;

class Kana2Roma
{
    private $charset='utf-8';
	private $mode_Krows  = 'k'; //か・く・こ(k or c)
	private $mode_XArows = 'l'; //小文字ぁ行と「っ」( L or X)
	private $mode_TYrows = 'ch'; //ち行＋小文字や行(ty or ch or cy)
	private $mode_SYrows = 'sh'; //し行＋小文字や行(sy or sh)
	private $mode_JYrows = 'j'; //じ行＋小文字や行(j or zy or jy)
	private $mode_Sstr   = 'sh'; //し(s or sh or c)
	private $mode_Jstr   = 'j'; //じ(j or z)
	private $mode_TUstr  = 'ts'; //つ(t or ts)
	private $mode_FUstr  = 'f'; //ふ(h or f)
	private $mode_TIstr  = 'ch'; //ち(t or ch)
	private $mode_Nstr   = 'n'; //ん(n or nn)
	private $strout = true; //配列でなく文字で返すかどうか
	private $chop = false; //ローマ字文字列をアルファベット１文字ごとに分解するかどうか
	private $vowel = ["a","i","u","e","o"];
	private $child = ["a","k","s","t","n","h","m","y","r","w","g","z","d","b","p","x","y","t"];
	private $symbol = ["!","?","-","'",","];
	private $number = ["0","1","2","3","4","5","6","7","8","9"];
	private $cols_H = [
		"A" => ["あ","か","さ","た","な","は","ま","や","ら","わ","が","ざ","だ","ば","ぱ","ぁ","ゃ"],
		"I" => ["い","き","し","ち","に","ひ","み","＠","り","＠","ぎ","じ","ぢ","び","ぴ","ぃ"],
		"U" => ["う","く","す","つ","ぬ","ふ","む","ゆ","る","ん","ぐ","ず","づ","ぶ","ぷ","ぅ","ゅ","っ"],
		"E" => ["え","け","せ","て","ね","へ","め","＠","れ","＠","げ","ぜ","で","べ","ぺ","ぇ"],
		"O" => ["お","こ","そ","と","の","ほ","も","よ","ろ","を","ご","ぞ","ど","ぼ","ぽ","ぉ","ょ"]
    ];
	private $const = NULL;

	public function show_help() 
	{
		print '[How to use]
$k2r = new Kana2Roma();
$romaji = $k2r->convert("とってもあいたいよ");
print($romaji);
';
	}

	public function __construct($txt=NULL){
		if(!empty($txt)){
			$this->const=$txt;
			return $this->convert($txt);
		}
	}

	public function convert($txt=NULL){
		if(empty($txt) && !empty($this->const)){
			$txt=$this->const;
		}
		if(empty($txt) && empty($this->const)){
			return NULL;
		}
		$txt=mb_convert_kana($txt,"c",$this->charset);
		$stack = $this->_TextSlice($txt);
		$out = array();

		for ($i = 0; $i <count($stack); $i++) {
			if(mb_strlen($stack[$i],$this->charset) == 1){
                $pre_char = '';
                if($i>0){
                    $pre_char = $stack[$i-1];
                }
				$str = $this->_baseOne($stack[$i], $pre_char);
				$out[]=$this->stringChopper($str);
			}else{
				$str2 = $this->_baseTwo($stack[$i]);
				$out[]=$this->stringChopper($str2);
			}
		}
		if ($this->strout) {
			return implode('',$out);
		}
		return $this->flatten($out);
	}


	//文章を1文字単位に分割する
	//@param {Object} str　文章
	function _TextSlice($txt){
		$max = mb_strlen($txt,$this->charset);
		$n = 0;
		$array = [];
		for ($i = 0; $i <$max; $i++) {
			++$n;
			$str = mb_substr($txt,$i,1);//今の文字
			$nxt = mb_substr($txt,$n,1);//次の文字
			//隣接する１文字目が小文字や行なら
			if(preg_match("/(ゃ|ゅ|ょ)/",$nxt)){
				$array[]=$str.$nxt;
				$i++;
				$n++;
			}
            else if($str=="っ" && array_search($nxt,$this->symbol)===false ){
				if(array_search($nxt,$this->number)===false){
					$array[]=$str.$nxt;
					$i++;
					$n++;
				}else{
					$array[]=$str;
				}
			}
            else{
				$array[]=$str;
			}
		}
		return $array;
	}
	
    function stringChopper($str){
		$out = [];
		if ($this->chop && !$this->strout) {
			for ($n = 0; $n <mb_strlen($str,$this->charset); $n++) {
				$out[]=mb_substr($str,$n,1);
			}
			return $out;
		}else{
			return $str;
		}
	}

	//変換ベース（2文字）
	//小文字とセットで2文字になってる文字を判別して処理を分配する
	//@param {Object} str　変換する文字（小文字とセットで2文字）
	function _baseTwo($str){
		if (preg_match("/っ/",$str)) {
			if(mb_strlen($str,$this->charset)==2){
				$txt = $this->_baseOne(mb_substr($str,1,1));
				return mb_substr($txt,0,1).$txt;
			}else{
				return $this->_baseOne($str);
			}
		}
        else{
			switch($str){
				case "ちゃ":
					return $this->mode_TYrows.$this->vowel[0];
				break;
				case "ちゅ":
					return $this->mode_TYrows.$this->vowel[2];
				break;
				case "ちょ":
					return $this->mode_TYrows.$this->vowel[4];
				break;
				case "しゃ":
					return $this->mode_SYrows.$this->vowel[0];
				break;
				case "しゅ":
					return $this->mode_SYrows.$this->vowel[2];
				break;
				case "しょ":
					return $this->mode_SYrows.$this->vowel[4];
				break;
				case "じゃ":
					return $this->mode_JYrows.$this->vowel[0];
				break;
				case "じゅ":
					return $this->mode_JYrows.$this->vowel[2];
				break;
				case "じょ":
					return $this->mode_JYrows.$this->vowel[4];
				break;
				default:
					$first = $this->_baseOne(mb_substr($str,0,1));
					$second = $this->_baseOne(mb_substr($str,1,1));
					return mb_substr($first,0,1).$second;
			}
		}
	}

    public function _change_bar($char, $pre_char) {
		if(array_search($pre_char,$this->cols_H['A'])!==false){
			return 'a';
		}else if(array_search($pre_char,$this->cols_H['I'])!==false){
			return 'i';
		}else if(array_search($pre_char,$this->cols_H['U'])!==false){
			return 'u';
		}else if(array_search($pre_char,$this->cols_H['E'])!==false){
			return 'e';
        }else if(array_search($pre_char,$this->cols_H['O'])!==false){
            return 'o';
		}else if(array_search($pre_char,$this->symbol) !== false){
			return '';
		}else if(array_search($pre_char,$this->number) !== false){
			return '';
		}else{
			return '';
		}
    }
	
	//変換ベース（1文字）
	//あいうえお行の配列（cols_H,number,symbol）から文字が何かを判別して各関数へ処理を分配する
	//@param {Object} str　変換する文字（１文字のみ）
	function _baseOne($str, $prechar = ''){
        if($str == 'ー' || $str == '〜' || $str == '−') {
            return $this->_change_bar($str, $prechar);
        }
		else if(array_search($str,$this->cols_H['A'])!==false){
			return $this->_Change_A_Rows(array_search($str,$this->cols_H['A']));
		}
        else if(array_search($str,$this->cols_H['I'])!==false){
			return $this->_Change_I_Rows(array_search($str,$this->cols_H['I']));
		}
        else if(array_search($str,$this->cols_H['U'])!==false){
			return $this->_Change_U_Rows(array_search($str,$this->cols_H['U']));
		}
        else if(array_search($str,$this->cols_H['E'])!==false){
			return $this->_Change_E_Rows(array_search($str,$this->cols_H['E']));
		}
        else if(array_search($str,$this->cols_H['O'])!==false){
			return $this->_Change_O_Rows(array_search($str,$this->cols_H['O']));
		}
        else if(array_search($str,$this->symbol) !== false){//記号
			return $this->symbol[array_search($str,$this->symbol)];
		}
        else if(array_search($str,$this->number) !== false){//数字
			return $str;
		}
        else{
			return NULL;
		}
	}
	
	//単音あ行文字をローマ字に
	//@param {Object} key　ひらがな配列のキー番号
	function _Change_A_Rows($key){
		if ($key == 1){//か行
			return $this->mode_Krows.$this->vowel[0];
		}else if($key == 15){//小文字ぁ行
			return $this->mode_XArows.$this->vowel[0];
		}else if($key == 0){
			return $this->vowel[0];
		}else{
			return $this->child[$key].$this->vowel[0];
		}
	}
	
	//単音い行文字をローマ字に　
	//@param {Object} key　ひらがな配列のキー番号
	function _Change_I_Rows($key){
		if ($key == 0){//母音
			return $this->vowel[1];
		}else if($key == 15){//小文字ぁ行
			return $this->mode_XArows.$this->vowel[1];
		}else if($key == 2){//し
			return $this->mode_Sstr.$this->vowel[1];
		}else if($key == 11){//じ
			return $this->mode_Jstr.$this->vowel[1];
		}else if($key == 3){//ち
			return $this->mode_TIstr.$this->vowel[1];
		}else{
			return $this->child[$key].$this->vowel[1];
		}
	}
	
	//単音う行文字をローマ字に　
	//@param {Object} key　ひらがな配列のキー番号
	function _Change_U_Rows($key){
		if ($key == 0){//母音
			return $this->vowel[2];
		}else if($key == 1){//く
			return $this->mode_Krows.$this->vowel[2];
		}else if($key == 15){//小文字ぁ行
			return $this->mode_XArows.$this->vowel[2];
		}else if($key == 3){//つ
			return $this->mode_TUstr.$this->vowel[2];
		}else if($key == 5){//ふ
			return $this->mode_FUstr.$this->vowel[2];
		}else if($key == 9){//ん
			return $this->mode_Nstr;
		}else if($key == 17){//っ
			return $this->mode_XArows.$this->mode_TUstr.$this->vowel[2];
		}else{
			return $this->child[$key].$this->vowel[2];
		}
	}
	
	//単音え行文字をローマ字に　
	//@param {Object} key　ひらがな配列のキー番号
	function _Change_E_Rows($key){
		if ($key == 0){//母音
			return $this->vowel[3];
		}else if($key == 15){//小文字ぁ行
			return $this->mode_XArows.$this->vowel[3];
		}else{
			return $this->child[$key].$this->vowel[3];
		}
	}
	
	//単音お行文字をローマ字に　
	//@param {Object} key　ひらがな配列のキー番号
	function _Change_O_Rows($key){
		if ($key == 0){//母音
			return $this->vowel[4];
		}else if($key == 1){//こ
			return $this->mode_Krows.$this->vowel[4];
		}else if($key == 15){//小文字ぁ行
			return $this->mode_XArows.$this->vowel[4];
		}else{
			return $this->child[$key].$this->vowel[4];
		}
	}
	
	function flatten($array) {
		$tmp = [];
		while (($v = array_shift($array)) !== null) {
			if (is_array($v)) {
				$array = array_merge($v, $array);
			} else {
				$tmp[] = $v;
			}
		}
		return $tmp;
	}
}

if (empty(debug_backtrace())) {
    $k2r = new Kana2Roma();
    $k2r->show_help();
}
