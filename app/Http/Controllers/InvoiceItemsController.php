<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\InvoiceItemCreateRequest;
use App\Http\Requests\InvoiceItemUpdateRequest;
use App\Repositories\InvoiceItemRepository;
use App\Validators\InvoiceItemValidator;
use App\Services\InvoiceItemService;
use JWTAuth;

class InvoiceItemsController extends Controller
{

    /**
     * @var InvoiceItemRepository
     */
    protected $invoiceItemRepository;

    /**
     * @var InvoiceItemValidator
     */
    protected $validator;
// sevcie
    protected $invoiceItemService;
    public function __construct(invoiceItemRepository $invoiceItemRepository, InvoiceItemValidator $validator,InvoiceItemService $invoiceItemService)
    {
        $this->invoiceItemRepository = $invoiceItemRepository;
        $this->validator  = $validator;
        $this->invoiceItemService=$invoiceItemService;
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
        $selloutItem=$this->invoiceItemRepository->with(['product','invoice.user','itemStatus'])->findByField('seller_id',$this->userID);
        return response()->json($selloutItem);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  InvoiceItemCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceItemCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $invoiceItem = $this->repository->create($request->all());

            $response = [
                'message' => 'InvoiceItem created.',
                'data'    => $invoiceItem->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
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
        $invoiceItem = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $invoiceItem,
            ]);
        }

        return view('invoiceItems.show', compact('invoiceItem'));
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

        $invoiceItem = $this->repository->find($id);

        return view('invoiceItems.edit', compact('invoiceItem'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  InvoiceItemUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {   
        $status=$this->invoiceItemService->changeItemStatus($request->status,$id,$this->userID);
        return response()->json($status);
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
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'InvoiceItem deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'InvoiceItem deleted.');
    }
}
