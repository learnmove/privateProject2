<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\PrivateMessage;
use App\Entities\ChatList;
use App\Entities\User;
use JWTAuth;
class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public $user,$userID;
     public function __construct(){
        if( JWTAuth::getToken()){
            $this->userID=JWTAuth::parseToken()->authenticate()->id;
            $this->user=JWTAuth::parseToken()->authenticate();
            
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function addChatUser(Request $request){
        $request['user_id']=$this->userID;
        if( ChatList::where('user_id',$this->userID)->where('chat_id',$request->chat_id)->count()||ChatList::where('user_id',$request->chat_id)->where('chat_id',$this->userID)->count()){
        }else{
        ChatList::create(['user_id'=>$this->userID,'chat_id'=>$request->chat_id],$request->all());
            
        }
    }
    public function getChatUser(){
    
        // $chat_list=ChatList::with('user','chat_user')->where('user_id',$this->userID)->paginate(5);
        // $chat_list=User::with(['chat_user'=>function($q){$q->orderBy('chat_lists.created_at','desc')->take(50);}])->find($this->userID);
        $user=User::with([
            'chat_me','chat_user'
                ])->find($this->userID);
        $list=collect($user->have_chat())->sortByDesc('pivot.created_at')->values()->all();
        return response()->json($list);

    }
    public function getChatContent(Request $request){
      $messages=PrivateMessage::where('receiver_id',$this->userID)
        ->where('sender_id',$request->sender_id)
        ->orWhere(function($q) use ($request){
            $q->where('sender_id',$this->userID)
        ->where('receiver_id',$request->sender_id);
            
        })->latest()
        ->paginate(10);
        return response()->json($messages);
    }
    public function postMessage(Request $request){
      $message=  PrivateMessage::create($request->all());
      $user=User::find($this->userID);
      event(new \App\Events\MessagePosted( $user,$message));
      return response()->json($message);
        
    }


}
