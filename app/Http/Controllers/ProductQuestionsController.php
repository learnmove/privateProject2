<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ProductQuestionCreateRequest;
use App\Http\Requests\ProductQuestionUpdateRequest;
use App\Repositories\ProductQuestionRepository;


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

    public function __construct(ProductQuestionRepository $repository)
    {
        $this->repository = $repository;
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
    public function store(ProductQuestionCreateRequest $request)
    {
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
