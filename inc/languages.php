<?php
global $ap_langs, $ap_langin;
$ap_langs = array();
$ap_langs['english'] = array();
$ap_langs['russian'] = array('А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ь', 'Ю','Я' );
$ap_langs['korean'] = array('ㄱ','ㄴ','ㄷ','ㄹ','ㅁ','ㅂ','ㅅ','ㅇ','ㅈ','ㅊ','ㅋ','ㅌ','ㅍ','ㅎ' );
$ap_langs['hungarian'] = array('A','Á','B','C','CS','D','E','É','F','G','H','I','Í','J','K','L','Ly','O','Ó','Ö','Ő','P','R','S','Sz','T','Ty','U','Ú','Ü','Ű','V','Z','Zs' );
$ap_langs['greek'] = array('α','β','γ','δ','ε','ζ','η','θ','ι','κ','λ','μ','ν','ξ', 'ο', 'π', 'ρ', 'σ', 'τ', 'υ', 'φ', 'χ', 'ψ', 'ω' );

if(!empty($ap_langs)){
	foreach($ap_langs as $k=>$v){
		$i = substr($k, 0, 2);
		$ap_langin[$i] = $k;
	}
}