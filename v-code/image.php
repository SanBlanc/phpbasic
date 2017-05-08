<?php 
header('content-type:image/png');
/**
 * 实现步骤
 * 1.函数创建一个100×30的底图
 * 2.对底图加入颜色区域
 * 3.设置内容和之间的距离
 * 4.添加干扰点数
 * 5.增加干扰线
 * 6.销毁图片
 * ----------------------
 * 1.数字验证码的制作
 * 2.数字加英文验证码的制作
 * 3.验证码的使用
 */
// 使用session存储验证信息
session_start();

$image = imagecreatetruecolor(100,30);
$bgcolor = imagecolorallocate($image,255,255,255);
imagefill($image,0,0,$bgcolor);

$captch_code = "";

for ($i=0; $i < 4; $i++) { 
	$fontsize = 6;
	$fontcolor = imagecolorallocate($image,rand(0,120),rand(1,120),rand(0,120));

	// 随机生成数字
	// $fontcontent = rand(0,9);

	// 根据字符串 $data，随机生成字符
	$data='abcdefghijklmnopqrstuvwxyz1234567890';
	$fontcontent = substr($data,rand(0,strlen($data)),1);

	$captch_code .= "$fontcontent";
	

	// 设置每个字符的坐标
	$x = ($i * 100/4)+rand(5,10);
	$y = rand(5,10);
	imagestring($image,$fontsize,$x,$y,$fontcontent,$fontcolor);
}

$_SESSION['code'] = $captch_code;


// 添加干扰元素
for ($i=0; $i < 200; $i++) { 
	$pointcolor = imagecolorallocate($image,rand(50,200),rand(50,200),rand(50,200));
	imagesetpixel($image,rand(1,99),rand(1,29),$pointcolor);
}
for ($i=0; $i < 5; $i++) { 
	$linecolor = imagecolorallocate($image,rand(60,220),rand(60,220),rand(60,220));
	imageline($image,rand(1,99),rand(1,29),rand(1,99),rand(1,29),$linecolor);
}

imagepng($image);
imagedestroy($image);
?>