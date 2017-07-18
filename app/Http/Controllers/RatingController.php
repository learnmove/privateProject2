<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RatingRepository;
use App\Repositories\RatingCommentRepository;
use JWTAuth;
class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     protected $userID;
     protected $ratingRepository;
     protected $ratingCommentRepository;
     public function __construct(RatingRepository $ratingRepository,RatingCommentRepository $ratingCommentRepository){
         $this->ratingRepository=$ratingRepository;
         $this->ratingCommentRepository=$ratingCommentRepository;
         if(JWTAuth::getToken()){
     $this->userID=JWTAuth::parseToken()->authenticate()->id;
     }
     }

    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->ratingRepository->updateOrCreate(['item_id'=>$request->item['id']],['item_id'=>$request->item['id'],'level'=>$request->level,'user_id'=>$this->userID]);
        return response()->json($request->all());
        //
    }
    public function ItemfFeedBack(Request $request){
        $this->ratingCommentRepository->updateOrCreate(['item_id'=>$request->item['id']],['item_id'=>$request->item['id'],'feedback'=>$request->item['feedback'],'user_id'=>$this->userID]);
        return  response()->json('ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_account,Request $rq)
    {
       $rating= $this->ratingRepository->getUserRating($user_account,$rq->method_name);
         return response()->json( $rating);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
