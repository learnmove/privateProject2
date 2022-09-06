<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\InvoiceCreateRequest;
use App\Http\Requests\InvoiceUpdateRequest;
use App\Repositories\InvoiceRepository;
use App\Validators\InvoiceValidator;
use App\Repositories\InvoiceItemRepository;
use JWTAuth;

class InvoicesController extends Controller
{

    /**
     * @var InvoiceRepository
     */
    protected $invoiceRepository;

    /**
     * @var InvoiceValidator
     */
    protected $validator;
    protected $invoiceItemRepository;
    protected $userID;
    public function __construct(InvoiceItemRepository $invoiceItemRepository,InvoiceRepository $invoiceRepository, InvoiceValidator $validator)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->validator  = $validator;
        $this->middleware('jwt.auth')->except('index');
        $this->invoiceItemRepository=$invoiceItemRepository;
       if(JWTAuth::getToken()){
     $this->userID=JWTAuth::parseToken()->authenticate()->id;
     }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userItem=$this->invoiceRepository->findInvoiceOfItems($this->userID);
        // $userItem=$this->invoiceRepository->findByField('user_id',35);
        
        return response()->json($userItem);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  InvoiceCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['user_id']=$this->userID;
        $user = \DB::table('users')->where('id', $this->userID)->first();
    //       \Mail::raw('以購買', function ($message) use ($user){
    //     $message->from('dontsaygoodbyebecause520@gmail.com','ga');
    //     $message->to($user->email, 'test')->subject('訂單成立通知');
    // });
        $invoice=$this->invoiceRepository->createInvoice($request->except('items'));
        $this->invoiceItemRepository->createItem($invoice,$request['items'],$this->userID);
             return response()->json(
                   '已下訂單'
                );

        
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
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
     * @param  InvoiceUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(InvoiceUpdateRequest $request, $id)
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
