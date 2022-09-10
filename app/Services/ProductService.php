<?php
namespace App\Services;
class ProductService{
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