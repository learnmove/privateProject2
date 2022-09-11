<?php 
namespace Lib;
class Mix{
	public function email_to_star($s){
		$a = explode('@', $s);
		$b = str_pad(substr($a[0], 0, 2), strlen($a[0]), '*');
		return $b . '@' . $a[1];
	}

	public function phone_to_star($s){
		$b = str_pad(substr($s, -3), strlen($s), '*', STR_PAD_LEFT);
		return $b;
	}
}