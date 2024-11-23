<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Config;
use App\Models\Admin\ProductCartItems;
use App\Models\Admin\Quote;
use App\Models\Admin\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use SebastianBergmann\Diff\Exception;
use PDF;
class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->actionAjaxIndex($request);
        }
        return view('admin.quotes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.quotes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $formType = $request->get('formType');
            $quoteStatus = Quote::ACTION_STATUS_CREATE;

            $customMessages = [
                'id_user.required' => 'The customer name is required.',
            ];

            $rules = [
                'id_user' => 'required',
                'currency_type' => 'required',
                'order_type' => 'required',
                'phone_number' => 'required',
                'delivery_type' => 'required',
                'email' => 'required',
            ];
            $validator = \Validator::make($request->all(), $rules, $customMessages);

            if ($validator->fails()) {
                return response()->json([
                    'statusCode' => 400,
                    'errors' => $validator->errors()
                ]);
            }
            if (array_key_exists('quote_no', $request->all())) {
                $quotes = Quote::where('quote_no', $request->input('quote_no'))->get()->first();
            } else {
                $quotes = new Quote();
                $quotes->created_at = date('Y-m-d h:i:s');
            }

            $customerEmail = $request->input('email');
            $quotes->cust_id = $request->input('id_user');
            $quotes->contact_person = $request->input('contact_person');
            $quotes->contact_person_email = $request->input('contact_person_email');
            $quotes->order_type = $request->input('order_type');
            $quotes->phone_number = $request->input('phone_number');
            $quotes->email = $request->input('email');
            $quotes->address = $request->input('address');
            $quotes->gst_no = $request->input('gst_no');
            $quotes->apt_no = $request->input('apt_no');
            $quotes->zipcode = $request->input('zipcode');
            $quotes->city = $request->input('city');
            $quotes->state = $request->input('state');
            $quotes->billing_option = (array_key_exists('billingChk', $request->all())) ? 1 : 0;
            $quotes->billing_address = $request->input('billing_address');
            $quotes->billing_apt_no = $request->input('billing_apt_no');
            $quotes->billing_zipcode = $request->input('billing_zipcode');
            $quotes->billing_city = $request->input('billing_city');
            $quotes->billing_state = $request->input('billing_state');
            $quotes->relation = $request->input('relation');
            $quotes->reference_from = $request->input('reference_from');
            $quotes->referral = $request->input('referral');
            $quotes->referral_agency = $request->input('referral_agency');
            $quotes->is_enquired = $request->input('is_enquired');
            $quotes->currency_type = $request->input('currency_type');
            $quotes->notes = $request->input('notes');
            $quotes->status = $quoteStatus;
            $quotes->delivery_type = $request->input('delivery_type');
            $quotes->created_by = Auth::user()->id;
            if ($request->get('order_type') == Quote::ORDER_TYPE_TENDOR) {
                $quotes->tendor_no = $request->get('tendor_no');
                $quotes->due_date = $request->get('due_date');
                $quotes->tender_quote_type = $request->get('bid_type');
            }
            $quotes->save();
            if ($quotes->wasRecentlyCreated) {
                $quoteNo = generateQuoteNo('Quote', $quotes->id);
                $quotes->quote_no = $quoteNo;
                $quotes->save();
                return response()->json([
                    "statusCode" => 200,
                    "quoteId" => $quotes->id,
                    "message" => "Proposal saved successfully."
                ]);
            }
//            else{
//                if($formType == 'saveNext'){
//                    $result = $this->actionCreateQuote($request,$quotes->id);
//                    return response()->json([
//                        "status" => 200,
//                        "quote_no" => $result['quote_no'],
//                        "token" => $result['token'],
//                        "message" => "Proposal updated successfully"
//                    ]);
//                }else{
//                    return response()->json([
//                        "status" => 200,
//                        "quoteId" => $quotes->id,
//                        "message" => "Proposal updated successfully"
//                    ]);
//                }
//            }
        } catch (\Exception $e) {
            return response()->json([
                "statusCode" => 400,
                "quoteId" => '',
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $quotes = Quote::where('id', $id)->with('user')->get()->first();
        return view('admin.quotes.edit', [
            'model' => $quotes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quote $quote)
    {
        $customerEmail = $request->input('email');
        $quote->cust_id = $request->input('id_user');
        $quote->contact_person = $request->input('contact_person');
        $quote->contact_person_email = $request->input('contact_person_email');
        $quote->order_type = $request->input('order_type');
        $quote->phone_number = $request->input('phone_number');
        $quote->email = $request->input('email');
        $quote->address = $request->input('address');
        $quote->apt_no = $request->input('apt_no');
        $quote->gst_no = $request->input('gst_no');
        $quote->zipcode = $request->input('zipcode');
        $quote->city = $request->input('city');
        $quote->state = $request->input('state');
        $quote->billing_option = (array_key_exists('billingChk', $request->all())) ? 1 : 0;
        $quote->billing_address = $request->input('billing_address');
        $quote->billing_apt_no = $request->input('billing_apt_no');
        $quote->billing_zipcode = $request->input('billing_zipcode');
        $quote->billing_city = $request->input('billing_city');
        $quote->billing_state = $request->input('billing_state');
        $quote->relation = $request->input('relation');
        $quote->reference_from = $request->input('reference_from');
        $quote->referral = $request->input('referral');
        $quote->referral_agency = $request->input('referral_agency');
        $quote->is_enquired = $request->input('is_enquired');
        $quote->currency_type = $request->input('currency_type');
        $quote->notes = $request->input('notes');
        $quote->created_by = Auth::user()->id;
        if ($request->get('order_type') == Quote::ORDER_TYPE_TENDOR) {
            $quote->tendor_no = $request->get('tendor_no', null);
            $quote->due_date = date('Y-m-d', strtotime($request->get('due_date')));
            $quote->tender_quote_type = $request->get('bid_type', null);
        } else {
            $quote->tendor_no = null;
            $quote->due_date = null;
            $quote->tender_quote_type = null;
        }
        if (array_key_exists('change_quote_no', $request->all()) && !empty($request->get('change_quote_no'))) {
            $quoteNo = explode('/', $quote->quote_no);
            $change_quote_no = $request->get('change_quote_no');
            $quoteNo[1] = $change_quote_no;
            $newQuoteNo = implode('/', $quoteNo);
            $quote->quote_no = $newQuoteNo;
        }
        if (array_key_exists('change_total_title', $request->all())) {
            $quote->total_title = $request->get('change_total_title');
        }
        $quote->status = $request->get('status');
        $quote->delivery_type = $request->get('delivery_type');
        $quote->save();

        if($quote->delivery_type){
            if($quote->delivery_type != Quote::INTER_STATE){
                if(!empty($quote->i_gst)){
                    $quote->i_gst = null;
                    $quote->save();
                }
            } else {
                if(!empty($quote->c_gst) && !empty($quote->s_gst)){
                    $quote->c_gst = null;
                    $quote->s_gst = null;
                    $quote->save();
                }
            }
        }


        return response()->json([
            "statusCode" => Response::HTTP_OK,
            "quoteId" => $quote->id,
            "message" => "Proposal updated successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quote = Quote::where('id', $id)->get()->first();
        if ($quote) {
            $quote->delete();
        } else {
            return redirect()->route('quotes')->with('quoteErrorMsg', "something went wrong.");
        }
        return redirect()->route('quotes')->with('quoteSuccessMsg', "Quote deleted successfully.");
    }


    /**
     * TO load data by ajax in datatable
     */

    public function actionAjaxIndex(Request $request)
    {
        $user = auth()->user();
        $columns = ['id','created_at','quote_no' ,'company_name','contact_person' ,'product','total_price','created_by' , 'status'];

        $sEcho = $request->get('sEcho', 1);

        $start = $request->get('iDisplayStart', 0);
        $limit = $request->get('iDisplayLength', 0);

        $quote_status = $request->get('quote_status', 'All');

        $colSort = $columns[(int)$request->get('iSortCol_0', 2)];
        $colSortOrder = strtoupper($request->get('sSortDir_0', 'asc'));
        $searchTerm = trim($request->get('sSearch', ''));

        $page = ($start / $limit) + 1;
        if ($page < 1) {
            $page = 1;
        }

        $currentPage = $page;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $tblQuote = Quote::getTableName();
//        $tblUser = 'users';
        $tblUser = User::getTableName();
        $tblQuoteBy = User::getTableName('quote_by');

        $selectColumns = [
            $tblQuote . '.id',
            $tblQuote . '.reference',
            $tblQuote . '.notes',
            $tblQuote . '.status',
            $tblQuote . '.quote_no',
            $tblQuote . '.token',
            $tblQuote . '.phone_number',
            $tblQuote . '.currency_type',
            $tblQuote . '.address',
            $tblQuote . '.apt_no',
            $tblQuote . '.zipcode',
            $tblQuote . '.city',
            $tblQuote . '.created_at',
            $tblQuote . '.created_by',
            $tblUser . '.id as id_user',
            $tblUser . '.first_name',
            $tblUser . '.last_name',
            'quote_by.first_name as e_first_name',
            'quote_by.last_name as e_last_name',
            $tblUser . '.email',
            $tblUser . '.company_name',
            $tblQuote . '.contact_person',
            $tblQuote . '.contact_person_email'
        ];
        $source = Quote::select($selectColumns)
            ->with('items')
            ->leftJoin($tblUser, $tblUser . '.id', '=', $tblQuote . '.cust_id')
            ->leftJoin($tblQuoteBy, 'quote_by.id', '=', $tblQuote . '.created_by');
        if (Auth::user()->role_id == Role::ROLE_EXECUTIVE) {
            $source->where('created_by', Auth::user()->id);
        } else if (Auth::user()->role_id == Role::ROLE_BUSINESS_HEAD) {
            $subordinates = $user->businessHeadSubordinates;
            $subordinateIds = $subordinates->pluck('id')->toArray();
            $source->whereIn('created_by', $subordinateIds);
        }
        if ($searchTerm !== '' && strlen($searchTerm) > 0) {
            $source->where(function ($query) use ($searchTerm, $tblQuote, $tblUser) {
                $query->where($tblQuote . '.quote_no', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere($tblQuote . '.token', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere($tblQuote . '.address', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere($tblQuote . '.apt_no', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere($tblQuote . '.zipcode', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere($tblQuote . '.city', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere($tblUser . '.email', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere($tblUser . '.first_name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere($tblUser . '.last_name', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        if ($quote_status != 'All') {
            $source->where($tblQuote . '.status', $quote_status);
        }

        if ($request->get('quote_type') == 'false') {
            $source->whereNotIn($tblQuote . '.status', [Quote::QUOTE_TEST]);
        }

//        $query = vsprintf(str_replace(array('?'), array('\'%s\''), $source->toSql()), $source->getBindings());
//        dd($query);

        switch ($colSort) {
            default:
                $source->orderBy($colSort, $colSortOrder);
                break;
        }

        $quotes = $source->paginate($limit, $columns);
        $aaData = [];
        $count = 1;
        foreach ($quotes as $key => $property) {
            $isProductPlaced = null;
            $href = '';

            $email_conversation = ' <a href="javascript:void(0);"><i data-toggle="tooltip" title="" class="fa fa-envelope-o" data-original-title="Email Conversations"></i></a>';
            $order_reference = '';
            $download_proposal = '';
            if ($property->status > Quote::PROPOSAL_CREATED) {
                $download_proposal = '<br> <a href="' . route('proposal.downloadProposa', ['token' => $property->token, 'type' => 'pdf', 'quoteNo' => $property->quote_no]) . '">Download Proposal</a>';
            }

            $client_name = $property->first_name . ' ' . $property->last_name;
            $created_by = $property->e_first_name . ' ' . $property->e_last_name;

            if ($property->backOrder && $property->backOrder->signedProposal && $property->backOrder->signedProposal->signed_document_path && $property->status == 8) {
                Quote::where('token', $property->token)->update(['status' => Quote::AGREEMENT_SIGNED]);
                $statusType = quote_status(Quote::AGREEMENT_SIGNED);
            } else {
                $statusType = quote_status($property->status);
            }

            $productDesc = '';
            $accesoriesCount = 0;
            if ($property->items) {
                foreach ($property->items as $key => $item) {
                    $productDesc .= '<u><i class="icon-lock"  onmouseover="document.getElementById(\'' . $count . '-' . $accesoriesCount . '\').style.display = \'block\'" onmouseleave="document.getElementById(\'' . $count . '-' . $accesoriesCount . '\').style.display = \'none\'">' . $item->product->name . '</i></u> <br /><br /><div class="form-popup" id=\'' . $count . '-' . $accesoriesCount . '\'><span class=\'desc-text\'>' . $item->product->short_description . '</span></div>';
                    $accesoriesCount++;
                }
            }

            $buttons = [
//                'view' => [
//                    'label' => 'View',
//                    'attributes' => [
////                        'id' => $property->id.'_view',
//                        'href' => $href,
//                    ]
//                ],
                'edit' => [
                    'label' => 'Edit',
                    'attributes' => [
                        'href' => route('quote.edit', ['id' => $property->id]),
                    ]
                ],
                'trash' => [
                    'label' => 'Delete',
                    'attributes' => [
                        'href' => route('quote.delete', ['id' => $property->id]),
                        'class' => 'ConfirmDelete',
                    ]
                ]
            ];

            if (Auth::user()->role_id != \App\Models\Admin\Role::ROLE_ADMIN) {
                unset($buttons['trash']);
            }
            $quoteDetails = Quote::getQuoteTotal($property->id);
            $finalTotal = isset(ProductCartItems::CURRENCY[$property->currency_type]) ? ProductCartItems::CURRENCY[$property->currency_type] . $quoteDetails['totalAmount'] : '$';
            $aaData[] = [
                'id' => $count++,
                'created_at' => $property->created_at,
                'quote_no' => $property->quote_no . $order_reference . $download_proposal,
//                'cust_info' => '<a href="" target="_blank">' . $client_name . '</a><br>' . $property->email . '<br>' . $property->phone_number,
//                'cust_info' => $property->contact_person . '<br>' . $property->contact_person_email,
                'company_info' => '<a href="" target="_blank">' . $property->company_name . '</a>',
                'contact_info' => $property->contact_person . '<br>' . $property->contact_person_email,
                'product_desc' => $productDesc,
                'total_price' => $finalTotal,
                'created_by' => $created_by,
                'status' => $statusType,
                'controls' => table_buttons($buttons, false)
            ];
        }

        $total = $quotes->total();
        $output = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => $total,
            "iTotalDisplayRecords" => $total,
            "aaData" => $aaData
        );
        return response()->json($output);
    }

    public function downloadQuote(Request $request, $quote_id)
    {
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', '2048M');
//        $quote_id = $request->get('id');
        $type = $request->get('type');
        $configs = Config::getVals(['IGST', 'CGST', 'SGST']);
        $quote = Quote::where('id', $quote_id)
            ->with('user')
            ->with('createdBy')
            ->with('items')
            ->get()
            ->first();
        $layout = true;
        if ($type == 'html') {
            $layout = false;
        }
        $var = [
            'title' => 'Testing Page Number In Body',
            'layout' => $layout,
            'model' => $quote,
            'configs' => $configs,
        ];
        $page = 'admin.pdf.proposal';
        $prefix = 'Quote';

        if ($type == 'pdf') {
            $pdf = \App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadView($page, $var);
            return $pdf->download($quote->quote_no . '.pdf');

        } else {
            return view($page, $var);
        }
    }

    public function changeStatus(Request $request, $quote_id)
    {
        $quoteNo = $quote_id;
        $quotes = Quote::where('id', $quoteNo)->get()->first();

        try {
            if ($quotes) {
                $quotes->action_type = $request->get('action_type');
                $quotes->action_by = Auth::id();
                $quotes->action_at = time();
                $quotes->action_note = $request->get('remark');;
                $quotes->save();

                $adminName = User::getApprover($quotes->action_by);
                return response()->json([
                    'statusCode' => 200,
                    'approvedMsg' => '<label>Quote Approved By: ' . $adminName . ' <br />Quote Approved On: ' . date('d-m-Y', $quotes->action_at) . '</span></label>',
                    'message' => "Proposal approved successfully.",
                ], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
//        return response()->json([
//            'statusCode' => 400,
//            'approvedMsg' => '',
//            'message' => "Something went wrong,Please try again.",
//        ], Response::HTTP_BAD_REQUEST);
    }

    public function getQuote(Request $request)
    {
        $searchTerm = trim($request->get('term', ''));
        $page = trim($request->get('page', 1));
        $limit = 10;
        if ($page < 1) {
            $page = 1;
        }

        $currentPage = $page;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        $userType = [];
        $tblQuote = Quote::getTableName();
        $source = Quote::where([$tblQuote . '.status' => 1]);


        if ($searchTerm !== '' && strlen($searchTerm) > 0) {
            $source->where(function ($query) use ($searchTerm, $tblQuote) {
                if (preg_match('/^[0-9]+$/', $searchTerm)) {
                    $query->where($tblQuote . '.id', '=', $searchTerm);
                } else {
                    $query->where($tblQuote . '.quote_no', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere($tblQuote . '.email', 'LIKE', '%' . $searchTerm . '%');
                }
            });
        }

        $source->orderBy($tblQuote . '.id', 'ASC');
        $result = $source->paginate($limit, ['quotes.id', 'quotes.quote_no', 'quotes.email']);

        return response()->json($result);
    }

    public function sendQuote(Request $request)
    {
        $quoteId = $request->get('quote_id');
        $quote = Quote::where('id', $quoteId)
            ->with('user')
            ->get()
            ->first();

        $pdf = $this->generateQuote($request, $quoteId, 'mail');
        $prefix = 'Quote';
        $attachmentName = strtoupper($prefix) . '-' . time() . '-' . $quote->quote_no;

        $attachment = [
            [
                'name' => $attachmentName . '.pdf',
                'data' => $pdf->output()
            ]
        ];

        $customer = $quote->user;
        try {
            sendMail(\App\Emailers\Quote::class, ['customer' => $customer, 'quotes' => $quote])->sendQuote($customer, $attachment, 'customer', $quote);

            return response()->json([
                'statusCode' => 200,
                'message' => "Quotation sent successfully to customer",
                'data' => '',
            ], Response::HTTP_OK);

        } catch (Exception $e) {

            return response()->json([
                'statusCode' => 400,
                'message' => $e->getMessage(),
                'data' => '',
            ], Response::HTTP_BAD_REQUEST);

        }

    }

    public function generateQuote(Request $request, $quoteId, $type = 'mail')
    {
        $configs = Config::getVals(['IGST', 'CGST', 'SGST']);
        $quote = Quote::where('id', $quoteId)
            ->with('user')
            ->with('items')
            ->get()
            ->first();
//        dd($quote);
        $layout = true;
        if ($type == 'html') {
            $layout = false;
        }
        $var = [
            'title' => 'Testing Page Number In Body',
            'layout' => $layout,
            'model' => $quote,
            'configs' => $configs,
        ];
        $page = 'admin.pdf.proposal';
        $prefix = 'Quote';

        if ($type == 'pdf' || $type == 'mail') {
            $pdf = \App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadView($page, $var);
//            $pdf = PDF::loadview($page, $var);
            return $pdf;

        } else {
            return view($page, $var);
        }
    }

    public function updateTermCondition(Request $request)
    {
        $quoteId = $request->get('quote_id');
        $iGST = $request->get('i_gst');
        $cGST = $request->get('c_gst');
        $sGST = $request->get('s_gst');
        $amended_on = $request->get('amended_on');
        $freight = $request->get('freight');
        $installation = $request->get('installation');
        $freightType = $request->get('freightType');
        $freightPercentage = $request->get('freightPercentage');
        $installationType = $request->get('installationType');
        $installationPercentage = $request->get('installationPercentage');
        $warrantyNote = $request->get('warranty_note');
        $paymentTerms = $request->get('payment_terms');
        $validity = $request->get('validity');

        $quote = Quote::where('id', $quoteId)->get()->first();

        if ($quote) {
            $quote->i_gst = $iGST;
            $quote->c_gst = $cGST;
            $quote->s_gst = $sGST;
            $quote->freight = $freight;
            $quote->installation = $installation;
            $quote->freight_type = $freightType;
            $quote->freight_percentage = $freightPercentage;
            $quote->installation_type = $installationType;
            $quote->installation_percentage = $installationPercentage;
            $quote->warranty_note = $warrantyNote;
            $quote->payment_terms = $paymentTerms;
            $quote->validity = $validity;
            if ($amended_on) {
                $quote->amended_on = date("Y-m-d");
            }
            $quote->save();
            return response()->json([
                'statusCode' => Response::HTTP_OK,
                'message' => 'Terms and Conditions updated successfully',
                'data' => '',
            ], Response::HTTP_OK);

        } else {
            return response()->json([
                'statusCode' => Response::HTTP_BAD_REQUEST,
                'message' => 'Something went wrong, please try again.',
                'data' => '',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getInstallationCharge(Request $request)
    {
        $quoteId = $request->get('quoteId');
        $type = $request->get('type');
        $val = $request->get('val');
//        $config = Config::get('INSTALLATION');
//        $installtion = $config['value'];
        $installtion = 0;
        if ($type == '%') {
            $finalTotal = Quote::getQuoteTotal($quoteId);
            $installtion = round($finalTotal['totalAmount'] * $val / 100);
        }
        return $installtion;
    }

    public function getDiscount(Request $request)
    {
        $quoteId = $request->get('quoteId');
        $type = $request->get('type');
        $val = $request->get('val');
//        $config = Config::get('INSTALLATION');
//        $installtion = $config['value'];
        $discount = 0;
        $finalTotal = 0;
        if ($type == '%') {
            $finalTotal = Quote::getQuoteTotal($quoteId);
            $discount = round($finalTotal['totalAmount'] * $val / 100);
        }
        return round(($discount), 2);
    }

    public function getFreightCharge(Request $request)
    {
        $quoteId = $request->get('quoteId');
        $type = $request->get('type');
        $val = $request->get('val');
//        $config = Config::get('FREIGHTCHARGE');
//        $freight = $config['value'];
        $freight = 0;
        if ($type == '%') {
            $finalTotal = Quote::getQuoteTotal($quoteId);
            $freight = round($finalTotal['totalAmount'] * $val / 100);
        }
        return $freight;
    }

    public function updateQuotePreview(Request $request)
    {
        $quoteId = $request->get('quoteId');
        $quote = Quote::where("id", $quoteId)->get()->first();
        if ($quote) {
            $quote->is_preview = true;
            $quote->save();
        }
        return response()->json([
            'statusCode' => Response::HTTP_OK
        ]);
    }
}
