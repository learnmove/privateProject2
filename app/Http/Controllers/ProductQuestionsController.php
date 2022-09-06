<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ProductQuestionCreateRequest;
use App\Http\Requests\ProductQuestionUpdateRequest;
use App\Repositories\ProductQuestionRepository;
use JWTAuth;
use App\Entities\User;
class ProductQuestionsController extends Controller
{

    /**
     * @var ProductQuestionRepository
     */
    protected $repository;

    /**
     * @var ProductQuestionValidator
     */
    protected $validator;
    protected $user;
    public function __construct(ProductQuestionRepository $repository)
    {
        $this->repository = $repository;
        if(JWTAuth::getToken()){
            $this->user=JWTAuth::parseToken()->authenticate();
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductQuestionCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->repository->create($request->except('seller_id'));
        $seller=User::find($request->seller_id);
        if($this->user->id!=$request->seller_id){
       $seller->notify(new \App\Notifications\ProductQuestion($request->product_id,$request->account,$request->content));
            
        }
        return response()->json('留言成功');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($product_id)
    {
        $productQuestion = $this->repository->FindProductIdQuestion($product_id);

        if (request()->wantsJson()) {

            return response()->json(
               $productQuestion
        );
        }

        // return view('productQuestions.show', compact('productQuestion'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


    }


    /**
     * Update the specified resource in storage.
     *
     * @param  ProductQuestionUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(ProductQuestionUpdateRequest $request, $id)
    {

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
