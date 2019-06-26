<?php

namespace App\Http\Controllers;


use App\Project;
use App\VoucherType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\PettyCash;
use App\AccountSetting;
use App\CashRequest;
use Carbon\Carbon;

class PettyCashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $petty=PettyCash::all();

       return view('pettyCash.index',['petty'=>$petty]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts=DB::table('Accounts')->where('iAccountType',1)->get(['AccountLink','Description']);
        return view('pettyCash.add',['accounts'=>$accounts])->with('payments',VoucherType::all())->with('projects',Project::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     //dd($request->all());
        $pettyCash= new PettyCash();
        $pettyCash->batch_id  = $request->account ;
        $pettyCash->reference  = $request->reference ;
        $pettyCash->transaction_type  = PettyCash::PENDING;
        $pettyCash->account  = $request->account ;
        $pettyCash->description  = $request->description ;
        $pettyCash->amount  = $request->amount;
        $pettyCash->currency_type  = $request->currency_type;
        $pettyCash->payment_type  = $request->payment_type;
        $pettyCash->project_id  = $request->project_id;
        $pettyCash->type = 1;

        if($pettyCash->save()){
            flash('Reimbursement Petty cash successfull, Waiting approval','success');
            return redirect()->route('pettycash.index');
        }
            flash('Error Occured !!','danger');
            return redirect()->back();
      }

    /**
     * accept the pettycash rem..
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $cashData=PettyCash::where('id',$id)->first();
       // $glAccount=AccountSetting::where('account_id',AccountSetting::PETTYCASH)->first();

        $from_sage=VoucherType::where('iVoucherTypeID',$cashData['payment_type'])->first();

        $ref_no =$cashData['currency_type'] =='KSH' ? (strlen($from_sage->iDeftStartNo) <= $from_sage->iPad ? str_pad('KES', strlen($from_sage->iDeftStartNo), '0', STR_PAD_RIGHT) : 'KES') : '';
        $ref_no.=$cashData['currency_type'] =='USD' ? (strlen($from_sage->iDeftStartNo) <= $from_sage->iPad ?  str_pad('USD', strlen($from_sage->iDeftStartNo), '0', STR_PAD_RIGHT) : 'USD') : '';
        CashRequest::create([

                'Audit_No' => 0,
                'bIsReceipt' => 1,
                'iModule' => 0,
                'iCustSuppGLAccId' => 0,
                'iBankAccountID' => 0,
                'iAPAccId' => 0,
                'iARAccId' => 0,
                'iGrpId' => 0,
                'iTrAccId' => $from_sage->iTrCodeId,
                'iARTrAccId' => 0,
                'fAmount' => $cashData['amount'],
                'iTenderTypeId' => 2,
                'dExtraDate' => Carbon::now()->toDateTimeString(),
                'TxDate' => Carbon::now()->toDateTimeString(),
                'Reference' =>  $ref_no.''.$from_sage->iDeftStartNo.''.$from_sage->cSuffix,
                'Description' => '',
                'Username' => '',
                'cChequeNo' => '',
                'iBankLink' => 0,
                'cBankBranch' => '',
                'cBankRefNo' => '',
                'cEFTAccountNo' => '',
                'cAccountHolder' => '',
                'cCardNo' => '',
                'cCardType' => '',
                'dCardExpiryDate' => '',
                'cCardAuthCode' => '',
                'bProcessUnprocessed' => 'UnProcessed',
                'bApproved' => 0,
                'cCabNo' => '',
                'cOwnerLessee' => '',
                'cCurrencySymbol' => $cashData['currency_type'] =='KSH' ? 'KES' : '$',
                'fExchangeRate' => 0,
                'fHomeAmount' => $cashData['amount'],
                'fForeignAmount' => 0,
                'bIsHomeCurrency' => 0,
                'iCurrencyLink' => $cashData['currency_type'] =='KSH' ? '0' : '1',
                'iVoucherID' => $cashData['payment_type'],
                'cNarrative' => $cashData['reason'],
                'fk_iProjectID' => $cashData->project_id,
                'bSpiltTrans' => 0,
                'cAccountPayee' => '',
                'bPostDated' => 0,
                'bPostDatedChqCancelled' => 0,
                'bIsPrinted' => '',
                'PR_PmtRec_iBranchID' => 0,
                'iIncidentTypeId' => 0,
                'iIncidentID' => 0,


            ]
        );

        VoucherType::where('iVoucherTypeID',$cashData['payment_type'])->update(['iDeftStartNo'=> $from_sage->iDeftStartNo+1]);

          flash('Reimbursement Petty cash successfull','success');
            return redirect()->route('pettycash.index');
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
    public function rejectPettyCash($id){
        $petty=PettyCash::findorfail($id);
        if($petty->update(['transaction_type'=>PettyCash::REJECTED])){
            flash('Petty cash Reimbursement rejected' ,'success');
            return redirect()->back(); 
         }
            flash('un erreor occured' ,'danger');
            return redirect()->back(); 

    }
}
