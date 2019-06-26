<?php

namespace App\Repositories;

use Carbon\Carbon;
use DB;
use App\Imprest;
use App\PettyCash;
class ImprestRepository
{
    public static function processImprest($request,$account, $imprestNumber, $payment)
    {
        $imprestDetails = [
            'module' => 1,
            'account' => $account,
            'imprestNumber' => $imprestNumber,
            'payment' => $payment,
            'nature_of_duty' => $request->nature_of_duty,
            'deposit' => 0
        ];

        DB::table('_btblJrBatchLines')->insert(self::mapCashBook($imprestDetails));
       PettyCash::insert([
            'reference' =>$imprestNumber,
            'batch_id' =>$account,
            'transaction_type' =>PettyCash::NEGATE,
            'account' =>0,
            'description' =>$request->nature_of_duty,
            'amount' =>$payment,
            'type' =>1,
            ]);
    }

    public static function processReturnImprest($imprest,$amount,$account)
    {

        DB::transaction(function () use ($imprest, $amount ,$account) {

            $totalAccounted = 0;

                $cashbookDetails=[
                    'module' => 0,
                    'account' => $account,
                    'imprestNumber' => $imprest->imprest_number,
                    'payment' => 0,
                    'nature_of_duty' => $imprest->nature_of_duty,
                    'deposit' => (int)$amount,
                    'project' => $imprest->project_id,
                    ];

                DB::table('_btblJrBatchLines')->insert(self::mapCashBookSurenders($cashbookDetails));

                    $totalAccounted += (int)$amount;
            
            $getData=Imprest::where('imprests.imprest_number',$imprest->imprest_number)
                           ->first();
            $imprestDetails = [
                    'iBatchesID' => env('CASHBOOK_ID', 1),
                    'dTxDate' => Carbon::now()->format('Y-m-d'),
                    // 'iModule' => 1,
                    'iAccountID' => $getData->applicant_id,
                    //description use the defined description in the receipt
                    'cDescription' => 'reconciled pettycash',
                    'cReference' => $imprest->imprest_number,
                    'fDebit' => 0,
                    'fCredit' => $totalAccounted,
                    'fTaxAmount' => 0,
                    'iTaxTypeID' => 0,
                    'iTaxAccountID' => 0,
                    'iProjectID' => $imprest->project_id,
                ];

                DB::table('_btblJrBatchLines')->insert($imprestDetails);
            });
      
    }

    private static function mapCashBook($cashbookDetails)
    {
        return [
           // 'idBatchLines' => env('CASHBOOK_ID', 1),
            'iBatchesID' => env('CASHBOOK_ID', 1),
            'dTxDate' => Carbon::now()->format('Y-m-d'),
            // 'iModule' => $cashbookDetails['module'],
            'iAccountID' => $cashbookDetails['account'],
            'cDescription' => substr($cashbookDetails['nature_of_duty'],0,99),
            'cReference' => $cashbookDetails['imprestNumber'],
            'fDebit' => $cashbookDetails['deposit'],
            'fCredit' => $cashbookDetails['payment'],
            //'bReconcile' => 0,
            //'bPostDated' => 0,
            //'bPrintCheque' => 0,
            //'bChequePrinted' => 0,
            'fTaxAmount' => 0,
            'iTaxTypeID' => 0,
            'iTaxAccountID' => 0
        ];
    }

    private static function mapCashBookSurenders($cashbookDetails)
    {
        return [
            'iBatchesID' => env('CASHBOOK_ID', 1),
            'dTxDate' => Carbon::now()->format('Y-m-d'),
            // 'iModule' => $cashbookDetails['module'],
            'iAccountID' => $cashbookDetails['account'],
            'cDescription' => $cashbookDetails['nature_of_duty'],
            'cReference' => $cashbookDetails['imprestNumber'],
            'fDebit' => $cashbookDetails['deposit'],
            'fCredit' => 0,
            'fTaxAmount' => 0,
            'iTaxTypeID' => 0,
            'iTaxAccountID' => 0,
            'iProjectID' =>$cashbookDetails['project']
        ];
    }
}
