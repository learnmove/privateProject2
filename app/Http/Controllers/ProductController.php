<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use Auth;
use JWTAuth;
use App\Entities\Product;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;
use DB;
use Redis;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     protected $productRepository;
     protected $productService;
     protected $userID;
     public function __construct(ProductService $productService,ProductRepository $productRepository){
     $this->productRepository=$productRepository;
     $this->productService=$productService;
     $this->middleware(['jwt.auth'])
     ->except(
         'index',
         'show',
         'getSellerStore',
         'getSchoolList','getCategoryList');

       try{
      if(JWTAuth::getToken()){
     $this->userID=JWTAuth::parseToken()->authenticate()->id;
        // }
        }}catch(\Tymon\JWTAuth\Eceptions\JWTException $e){
        return response()->json(['token_expired'], $e->getStatusCode());


      }
     }
    public function index()
    {
        return $this->productRepository->withUserAndPage(10);
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {   

        $product = $request->all();
        $path=$this->productService->storeImg($request->img);
        if($path){
            $product['img']=$path;
        }

        $product['user_id'] = JWTAuth::parseToken()->authenticate()->id;
        $product['school_id'] = JWTAuth::parseToken()->authenticate()->school_id;
        $product=  Product::create($product);
        $product->categories()->attach($request->category_id,['school_id' => $product['school_id']]);

        return response()->json(['上傳成功']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product=$this->productRepository->with(['categories'])->find($id);
        return response()->json($product);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $imgpath=$this->productService->storeImg($request->img);
        if($imgpath){
        $request['img']=$imgpath;
        }
        $updateMessage=$this->productRepository->updateProduct($id,$request);
    return response()->json([$updateMessage]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $deleteStatus=$this->productRepository->destroypProduct($id);
        // 改成有visible欄位 軟刪
        $softDeleteStatus=$this->productRepository->softDeleteStatus($id);
        return response()->json([$softDeleteStatus]);
    }
    public function getMyStore(){
        return response()->json($this->productRepository->withMeAndPage(10,$this->userID));
    }
    public function getSellerStore(Request $request,$user_account){
        $data= $this->productRepository->withInfoAndPageOfUser(10,$user_account);
         return response()->json( $data);
    }
    public function getSchoolList(){
       $schools= DB::table('school')->get();
     return response()->json($schools );
    }
     public function getCategoryList(){

        $categories= DB::table('categories')->get();

        return response()->json($categories);

    }

}
