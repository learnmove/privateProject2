<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('parent_id')->nullable();
            $table->timestamps();
        });
        DB::table('categories')
        ->insert([
            ['id' => '1' , 'name'=>'服飾/飾品', 'parent_id' => '0'],
            ['id' => '2' , 'name'=>'雜物', 'parent_id' => '0'],
            ['id' => '3' , 'name'=>'電子產品', 'parent_id' => '0'],
            ['id' => '4' , 'name'=>'家用', 'parent_id' => '0'],
            ['id' => '5' , 'name'=>'小說', 'parent_id' => '0'],
            ['id' => '6' , 'name'=>'理工書', 'parent_id' => '0'],
            ['id' => '7' , 'name'=>'文組書', 'parent_id' => '0'],
            ['id' => '8' , 'name'=>'商管書', 'parent_id' => '0'],
            ['id' => '9' , 'name'=>'藝術書', 'parent_id' => '0'],
            ['id' => '10' , 'name'=>'程式書', 'parent_id' => '0'],
            ['id' => '11' , 'name'=>'專科書', 'parent_id' => '0'],
            ['id' => '12', 'name'=>'國考書', 'parent_id' => '0'],
            ['id' => '13', 'name'=>'課本', 'parent_id' => '0'],
            ['id' => '14', 'name'=>'課外讀物', 'parent_id' => '0'],
            ['id' => '15', 'name'=>'樂器', 'parent_id' => '0'],
            ['id' => '16', 'name'=>'租屋', 'parent_id' => '0'],
            ['id' => '17', 'name'=>'票券', 'parent_id' => '0'],
            ['id' => '18', 'name'=>'作業/疑問', 'parent_id' => '0'],
            ['id' => '19', 'name'=>'發問', 'parent_id' => '0'],
            ['id' => '20', 'name'=>'打工', 'parent_id' => '0'],
            ['id' => '21', 'name'=>'外包', 'parent_id' => '0'],
            ['id' => '22', 'name'=>'攝影設備', 'parent_id' => '0'],
            ['id' => '23', 'name'=>'跑腿外快', 'parent_id' => '0'],
            ['id' => '24', 'name'=>'免費', 'parent_id' => '0'],
            ['id' => '25', 'name'=>'維修', 'parent_id' => '0'],
            ['id' => '26', 'name'=>'家教', 'parent_id' => '0'],
            ['id' => '27', 'name'=>'揪團/聯誼', 'parent_id' => '0'],
            ['id' => '28', 'name'=>'校內活動', 'parent_id' => '0'],
            ['id' => '29', 'name'=>'搬家公司', 'parent_id' => '0'],




            ['id' => '100', 'name'=>'男生衣服/外套', 'parent_id' => '1'],
            ['id' => '101', 'name'=>'男生褲子', 'parent_id' => '1'],
            ['id' => '102', 'name'=>'女生衣服/外套', 'parent_id' => '1'],
            ['id' => '103', 'name'=>'女生褲裙', 'parent_id' => '1'],
            ['id' => '104', 'name'=>'男生鞋子', 'parent_id' => '1'],
            ['id' => '105', 'name'=>'女生鞋子', 'parent_id' => '1'],
            ['id' => '107', 'name'=>'其他', 'parent_id' => '1'],

            ['id' => '201', 'name'=>'筆電', 'parent_id' => '3'],
            ['id' => '202', 'name'=>'平板', 'parent_id' => '3'],
            ['id' => '203', 'name'=>'其他', 'parent_id' => '3'],

            ['id' => '300', 'name'=>'古典小說', 'parent_id' => '5'],
            ['id' => '301', 'name'=>'現代小說', 'parent_id' => '5'],
            ['id' => '302', 'name'=>'言情小說', 'parent_id' => '5'],
            ['id' => '303', 'name'=>'武俠小說', 'parent_id' => '5'],
            ['id' => '304', 'name'=>'其他', 'parent_id' => '5'],

            ['id' => '400' , 'name'=>'吉他', 'parent_id' => '15'],
            ['id' => '401' , 'name'=>'電吉他/用品', 'parent_id' => '15'],
            ['id' => '402' , 'name'=>'琴', 'parent_id' => '15'],
            ['id' => '403' , 'name'=>'鼓', 'parent_id' => '15'],
            ['id' => '404' , 'name'=>'其他', 'parent_id' => '15'],

            ['id' => '500' , 'name'=>'數學疑問/作業', 'parent_id' => '18'],
            ['id' => '501' , 'name'=>'英文疑問/作業', 'parent_id' => '18'],
            ['id' => '502' , 'name'=>'程式疑問/作業', 'parent_id' => '18'],
            ['id' => '503' , 'name'=>'設計疑問/作業', 'parent_id' => '18'],
            ['id' => '504' , 'name'=>'文組疑問/作業', 'parent_id' => '18'],
            ['id' => '505' , 'name'=>'商管疑問/作業', 'parent_id' => '18'],
            ['id' => '506' , 'name'=>'國考疑問/作業', 'parent_id' => '18'],
            ['id' => '507' , 'name'=>'專科疑問/作業', 'parent_id' => '18'],
            ['id' => '508' , 'name'=>'理工疑問/作業', 'parent_id' => '18'],
            ['id' => '509' , 'name'=>'高中疑問/作業', 'parent_id' => '18'],
            ['id' => '510' , 'name'=>'高職疑問/作業', 'parent_id' => '18'],
            ['id' => '511' , 'name'=>'國中疑問/作業', 'parent_id' => '18'],
            ['id' => '512' , 'name'=>'法律疑問/作業', 'parent_id' => '18'],



            ['id' => '600' , 'name'=>'程式外包', 'parent_id' => '21'],
            ['id' => '601' , 'name'=>'平面設計外包', 'parent_id' => '21'],
            ['id' => '602' , 'name'=>'編曲外包', 'parent_id' => '21'],
            ['id' => '603' , 'name'=>'翻譯外包', 'parent_id' => '21'],
            ['id' => '604' , 'name'=>'動畫外包', 'parent_id' => '21'],
            ['id' => '605' , 'name'=>'網頁設計外包', 'parent_id' => '21'],
            ['id' => '606' , 'name'=>'攝影外包', 'parent_id' => '21'],
            ['id' => '607' , 'name'=>'廣告設計外包', 'parent_id' => '21'],

            ['id' => '700' , 'name'=>'單眼', 'parent_id' => '22'],
            ['id' => '701' , 'name'=>'鏡頭', 'parent_id' => '22'],
            ['id' => '702' , 'name'=>'其他', 'parent_id' => '22'],

            ['id' => '800' , 'name'=>'水電', 'parent_id' => '25'],
            ['id' => '801' , 'name'=>'電腦', 'parent_id' => '25'],
            ['id' => '802' , 'name'=>'手機', 'parent_id' => '25'],
            ['id' => '803' , 'name'=>'電器', 'parent_id' => '25'],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
