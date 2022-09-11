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
         'getSchoolList','getCategoryList', 'fetchRecommandProducts', 'getSubCategoryList');

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
        $request=request();
        $p = Product::with('user','category','school')
        ->withCount('questions')
                 ->where('quantity','>','0')
                 ->where('is_visible','<>','0');
        if($request->selectSchoolID){
            $p =$p->where('school_id', $request->selectSchoolID);
        }

        if($request->category_id){
            $category = \DB::table('categories')->find($request->category_id);

            if($category->parent_id == 0){
                $categories = \DB::table('categories')->where('parent_id', $category->id)->pluck('id');
                $categories[] = $category->id;
                $p = $p->whereIn('category_id', $categories);

            }else{
                $p = $p->where('category_id', $category->id);
            }

        }
        
        if($request->keyword){
            $p = $p->search($request->keyword);
        }
        $p = $p->orderBy('updated_at','desc');
        return $p->paginate(10);

    }

    public function fetchRecommandProducts(){
        $request = request();
        $products = \DB::table('products')->select(\DB::raw('SUBSTRING(name, 1, 20) as name,id, img,price'))->where('user_id', $request->user_id)->inRandomOrder()->take(4)->get();
        return $products;
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
        $product = Product::with('user', 'category', 'school')->where('id', $id)->first();
        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with('category')->find($id)->makeHidden(['user_id', 'school_id', 'updated_at', 'created_at']);
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
        $product = $request->all();
        $path=$this->productService->storeImg($request->img);
        if($path){
            $product['img']=$path;
        }
        $user_id=JWTAuth::parseToken()->authenticate()->id;
        $old_product = Product::find($id);
        $updateMessage = '更新成功';
        if($old_product->user_id == $user_id){
            $new_product = $old_product->update($product);
        }else{

            $updateMessage='更新失敗';
        }

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
        $product= Product::find($id);
        $product->is_visible=0;
        $product->save();
        $messages = '刪除成功';
        return response()->json([$messages]);
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
        $categories= DB::table('categories')->where('id', '<',100)->get();
        return response()->json($categories);
    }
     public function getSubCategoryList(){
        $categories = [];
        if((int)(request()->id)){
            $categories= DB::table('categories')->where('parent_id', request()->id)->get();
            
        }
        return response()->json($categories);
    }

}
