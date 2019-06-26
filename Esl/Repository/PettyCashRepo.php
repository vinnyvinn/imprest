<?php
/**
 * Created by PhpStorm.
 * User: vinnyvinny
 * Date: 10/26/18
 * Time: 1:29 PM
 */

namespace Esl\Repository;

class PettyCashRepo
{

    public function init(){
        return new self();
    }

    public function approveRequest($cashData,$project){
    dd($cashData);

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
                'iTenderTypeId' => 1,
                'dExtraDate' => '',
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
                'fk_iProjectID' => $project,
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
        return true;

    }
}
