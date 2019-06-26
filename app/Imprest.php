<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imprest extends Model
{
    const STATUS_UNPROCESSED = 0;
    const STATUS_PROCESSED = 1;
    const STATUS_APPROVED = 2;
    const STATUS_ISSUED = 3;
    const STATUS_SURRENDERED = 4;
    const STATUS_CLOSED = 5;
    const STATUS_CANCELLED = 7;

    const USER_INITIATED_SURRENDER =8;
    const HOD_APPROVED_SURRENDER =9;

//    protected $dateFormat = 'Y-m-d H:i:s';
    protected $fillable = [
        'applicant_id', 'imprest_number', 'due_date', 'project_id', 'reference', 'imprest_type', 'requester_id', 'process',
        'number_of_days', 'date_of_issue', 'account_id', 'officer_id', 'cheque_number', 'cheque_date',
        'CB_number', 'CB_date', 'voucher_number', 'station_name', 'advance_amount', 'remark',
        'surrender_cheque_number', 'surrender_cheque_date', 'surrender_cheque_amount',
        'surrender_cheque_remark', 'proposed_itinerary', 'nature_of_duty', 'status','currency_link_id','currency','location',
        'return_cash','reason','is_oversurrender'
    ];

    public function lines()
    {
        return $this->hasMany(ImprestLine::class);
    }

    public function money(){
        return $this->belongsTo('App\CurrencyHistory','currency_link_id','idCurrencyHist');
    }
    public function currency(){
        return $this->belongsTo('App\CurrencyHistory','currency_link_id','idCurrencyHist');
    }

    public function surrenderlines()
    {

        return $this->hasMany(SurrenderAttachment::class);
    }

    public function applicant()
    {

        return $this->belongsTo(User::class ,'applicant_id','sage_id');
    }

    public function officer()
    {
        return $this->belongsTo(User::class,'officer_id','id');
    }
}
