<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use Auth;
use JWTAuth;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     protected $productRepository;
     protected $productService;
     public function __construct(ProductService $productService,ProductRepository $productRepository){
     $this->productRepository=$productRepository;
     $this->productService=$productService;
     $this->middleware('jwt.auth')->except('index','show');
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
        $path=$this->productService->storeImg($request->img);
        if($path){
        $request['img']=$path;
        }
        $product=$this->productRepository->createProduct($request->all());
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
        $product=$this->productRepository->find($id);

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
        $updateMessage=$this->productRepository->updateProduct($id,$request->all());
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
        $deleteStatus=$this->productRepository->destroypProduct($id);
        return response()->json([$deleteStatus]);
    }
}
