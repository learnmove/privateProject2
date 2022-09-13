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
	public function account_to_star($s){
		$b = str_pad(substr($s, 0, 2), strlen($s), '*', STR_PAD_RIGHT);
		return $b;
	}

	public function storeImg($img=null){
	    $imgpath = '';
	  if($img){
	        $imgArray=explode(',',$img);

	        if(str_contains($imgArray[0],['jpeg'])){
	            $extension='jpg';
	            $decode=base64_decode($imgArray[1]);
	            $file_name=str_random().'.'.$extension;
	            $path=public_path().'/image/products/'.$file_name;
	            $imgpath=asset('/image/products/'.$file_name);
	            file_put_contents($path,$decode);
	            return $imgpath;
	        }
	    }
	    return $imgpath;
	}
}