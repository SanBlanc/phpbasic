<?php

// 执行
check_code();

/**
 * 生成验证码
 * @param  integer $width  [description]
 * @param  integer $height [description]
 * @param  integer $num    [description]
 * @param  string  $type   [description]
 * @return [type]          [description]
 */
function check_code($width = 100,$height = 50,$num = 4,$type='jpeg'){
	$img = imagecreate($width,$height);
	$string = '';

	// 生成四个字符
	for ($i=0; $i < $num; $i++) { 
		$rand = mt_rand(0,2);
		switch ($rand) {
			case 0:
				$ascii = mt_rand(48,57); // 0-9
				break;
			case 1:
				$ascii = mt_rand(65,90); // A-Z
				break;
			case 2:
				$ascii = mt_rand(97,112); // a-z
				break;
			default:
				break;
		}
		$string .= sprintf('%c',$ascii);
	}
	// 背景颜色
	imagefilledrectangle($img,0,0,$width,$height,randBg($img));

	// 画干扰元素
	for ($i=0; $i < 50; $i++) { 
		imagesetpixel($img,mt_rand(0,$width),mt_rand(0,$height),randPix($img));
	}

	// 写上文字
	for ($i=0; $i < $num; $i++) { 
		$x = floor($width / $num) * $i;
		$y = mt_rand(0,$height - 15);
		imagechar($img,5,$x,$y,$string[$i],randPix($img));
	}

	$func = 'image'.$type;
	$header = 'Content-type:image/'.$type;
	if(function_exists($func)){
		header($header);
		// 变为了 imagejpeg函数
		$func($img);
	}else{
		echo '图片类型不支持';
	}

	imagedestroy($img);
	return $string;

}



// 浅色背景函数
function randBg($img){
	return imagecolorallocate($img,mt_rand(130,255),mt_rand(130,255),mt_rand(130,255));
}

// 深色函数，深色的字或者干扰元素
function randPix($img){
	return imagecolorallocate($img,mt_rand(0,120),mt_rand(0,120),mt_rand(0,120));
}





?>