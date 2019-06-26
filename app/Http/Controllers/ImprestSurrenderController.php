<?php

namespace App\Http\Controllers;

use App\CurrencyHistory;
use App\Department;
use Illuminate\Http\Request;
use DB;
use App\Imprest;
use App\SurrenderAttachment;
use App\User;
use App\Repositories\ImprestRepository;
use Auth;
use Mail;
use App\Mail\DeclineImprestLine;
use App\Mail\HodNotification;
use Image;

class ImprestSurrenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $accounts = DB::table('Accounts')->select('AccountLink', 'Account', 'Description')->where('iAccountType',2)->get();
         $role="checks";

         if(Auth::user()->role_id == 1){
             $imprests = Imprest::join('Accounts', 'Accounts.AccountLink', '=', 'imprests.applicant_id')
                    ->join('Project', 'Project.ProjectLink', '=', 'imprests.project_id', 'left')
                    ->select(['imprests.*', 'Accounts.Description', 'Project.ProjectCode'])
                    ->where('status', '=', Imprest::STATUS_ISSUED)
                    ->where('is_oversurrender','!=',1)
                    ->where('Accounts.AccountLink',Auth()->user()->sage_id)
                ->get(['imprests.*', 'Accounts.Description' ,'Project.ProjectName']);

          }elseif (Auth::user()->role_id == 2) {
            // hod 
           $imprests = Imprest::join('users', 'users.sage_id', '=' , 'imprests.applicant_id')
                ->join('Accounts', 'Accounts.AccountLink', '=', 'users.sage_id')
                ->join('Project','Project.ProjectLink','=','imprests.project_id')
               
                ->where('imprests.officer_id',Auth::user()->id)
                    ->where('status', '=', Imprest::STATUS_ISSUED)
               ->where('is_oversurrender','!=',1)
                ->distinct('imprests.imprest_no')
                ->with(['currency.denomination'])
                ->get(['imprests.*','Accounts.Description','Project.ProjectName']);

          }elseif(Auth::user()->role_id==3){

            //finance 
        $imprests = Imprest::join('Accounts', 'Accounts.AccountLink', '=', 'imprests.applicant_id') 
                ->leftJoin('users', 'users.id', '=' , 'imprests.requester_id')
                ->join('Project','Project.ProjectLink','=','imprests.project_id')
                ->distinct('imprests.imprest_no')
                ->where('status', '=', Imprest::STATUS_ISSUED)
                ->where('is_oversurrender','!=',1)
                ->with(['currency.denomination'])
                ->get(['imprests.*', 'Accounts.Description','Project.ProjectName']);
          }
          else{
            // petty cash admin
            $imprestaothers = Imprest::join('Accounts','Accounts.AccountLink','=','imprests.applicant_id')
                ->where('status', '=', Imprest::STATUS_ISSUED)
                ->join('Project','Project.ProjectLink','=','imprests.project_id')
                ->distinct('imprests.imprest_no')
                ->where('advance_amount','<', 5000)
                ->where('is_oversurrender','!=',1)
                ->with(['currency.denomination'])
                ->get();
            $imprestsmine = Imprest::join('Accounts','Accounts.AccountLink','=','imprests.applicant_id')
                ->where('imprests.applicant_id', Auth::user()->sage_id)
                ->join('Project','Project.ProjectLink','=','imprests.project_id')
                ->distinct('imprests.imprest_no')
                ->where('advance_amount','<', 5000)
                ->with(['currency.denomination'])
                ->get();
            $imprests = $imprestaothers->merge($imprestsmine);


          }
       
        return view('new-surrender.index',['imprests' => $imprests]);
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

        $this->validate($request,[

            'amount' => 'required',
            'id' => 'required'
        ]);
         $surrender_amount =0;
        $imprests = Imprest::where('id',$request->id)->first();

        $keys[] = [];
        foreach ($request->description as $key => $value) {
            
            $keys[$key]['description'] =$value[0];
        }

        foreach($request->amount as $key => $value){

           $keys[$key]['amount'] =$value[0];
           $surrender_amount +=$value[0];
        }


        if($request->file){

            foreach($request->file as $key => $file) {
                $file_name = str_random(10) .date('Y-m-d: H:is').'.' . $file[0]->getClientOriginalExtension();
                $destinationPath = 'images/imprest/';
                Image::make($file[0])->save(public_path($destinationPath.$file_name));
                $keys[$key]['avatar'] = $file_name;


            }
        }

        unset($keys[0]);
        if($this->checkSurrenderedAmount($keys,$imprests)){

          session()->flash("warning","Amount Your are trying to surrender is less than the amount issued");
          session()->flash("error","Surrender Failed !!");
            return redirect()->back();
        }

        foreach($keys as $key){

            $key['imprest_id'] = (int)$request->id;
            $key['avatar'] = isset($key['avatar']) ? $key['avatar'] :'null';
            $key['status'] = SurrenderAttachment::INITIATED;
            
            SurrenderAttachment::create($key);         
        }

        $num = Imprest::count();

        $imprestnum = "IMP".''.$num;
        $imprestNumber= $this->getUniqueImprestNumber($imprestnum);
        $officer = Department::where('dep_code',Auth::user()->department_id)
            ->first();
        $hodDetails=User::where('id',$officer->user_id)->first();
        $data = $request->all();
        $imp=new  Imprest();
        $imp->requester_id = Auth::user()->sage_id;
        $imp->applicant_id = Auth::user()->sage_id;
        $imp->process = 0;
        $imp->officer_id = $imprests->officer_id?:$imprests->user_id;
        $imp->imprest_number=$imprestNumber;
        $imp->currency =$imprests->currency;

        if($imprests->currency != 0){
            $currency_hist=CurrencyHistory::where('iCurrencyID',$imprests->currency)
                ->orderBy('idCurrencyHist','DESC')
                ->first();
            //$amount= $amount * $currency_hist->fSellRate;
            $imp->currency_link_id = $currency_hist->idCurrencyHist;
        }

        $imp->advance_amount = $surrender_amount-$imprests->advance_amount;
        $imp->status = Imprest::STATUS_UNPROCESSED;
        $imp->project_id=$imprests->project_id;
        $imp->nature_of_duty='An Oversurrender of '. $imprests->imprest_number;
        $imp->imprest_type=$imprests->imprest_type;
        $imp->is_oversurrender=1;

        $imp->save();
        $id = $imp->id;
        Imprest::where('id',$num)->update(['surrendered_amount' =>$surrender_amount-$imprests->advance_amount]);
        if(count($hodDetails)>0){
            Mail::to($hodDetails)->send(new HodNotification(Imprest::where('id',$id)->first(),'Admin'));
        }

        $imprests->update(['status' => Imprest::USER_INITIATED_SURRENDER]);

        $hod =Imprest::with(['officer'])->where('id',$request->id)->first();

        $hodmail = $hod->officer->email;

        Mail::to($hodmail)->send(new HodNotification($imprests ,'surrender'));

        flash('Imprest Surrendered initiated successfully','success');
        
        return redirect()->route('surrender.index');



    }
    public function getUniqueImprestNumber($imprest){
        $checkImprest=Imprest::where('imprest_number',$imprest)->first();

        if( count($checkImprest) < 1 ){
            return $imprest;
        }else{

            $position = explode('P', $imprest);
            $imprest = 'IMP'.($position[1] + 1);

            return self::getUniqueImprestNumber($imprest);
        }
    }

    public function checkSurrenderedAmount($keys,$imprest)
    {

        $total_amount = 0;
        foreach($keys as $amount){
            $total_amount += $amount['amount'];
        }

        $getDBamount = SurrenderAttachment::where('status',SurrenderAttachment::INITIATED)->get();
        foreach($getDBamount as $amount){
            $total_amount +=$amount->amount;
        }

        if($imprest->advance_amount > $total_amount ){
            return true;
        }

        return  false;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $imprest = Imprest::with(['surrenderlines','applicant'])->find($id);

        if(Auth::user()->role_id == 2){
            
            return view('new-surrender.approve',['imprest' => $imprest]);
        }else if(Auth::user()->role_id == 0 or Auth::user()->role_id == 3){

      $accounts = DB::table('Accounts')->select('AccountLink', 'Account', 'Description')->where('iAccountType',2)->get();

            return view('new-surrender.final',['imprest' => $imprest,'accounts'=>$accounts]);
        }
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
        $this->validate($request,[
            'imprest_id' =>'required'
        ]);

        $imprest = Imprest::where('id',$id)->first();
        $imprest->update(['status'=>Imprest::STATUS_SURRENDERED]);

        foreach(array_combine($request->amount,$request->account) as $amount => $account){

            ImprestRepository::processReturnImprest($imprest,$amount,$account);

         }

         return redirect()->route('surrender.index');

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

    public function declineItem($id,$imprest_id)
    {

            $status = Auth::user()->role_id == 2?SurrenderAttachment::HOD_CANCELLED:SurrenderAttachment::FINAL_CANCELLED;
        $line = SurrenderAttachment::where('id',$id)->first();
        $line->update(['status' => $status]);

         $remaing= SurrenderAttachment::where('imprest_id' ,$imprest_id)
                ->where('status',SurrenderAttachment::INITIATED)
                ->get();

        $imprest = Imprest::where('id',$imprest_id)->with(['applicant'])->first();

        $imprest->update(['status' => Imprest::USER_INITIATED_SURRENDER]);

            if(count($remaing) < 1 ){

                return $this->declineImprest($imprest_id);
            } 

        Mail::to($imprest->applicant->email)->send(new DeclineImprestLine($imprest,$line,'partial'));

        return redirect()->back();
    }
    public function declineImprest($id){

        SurrenderAttachment::where('imprest_id',$id)->update(['status' => Auth::user()->role_id==2?SurrenderAttachment::HOD_CANCELLED:SurrenderAttachment::FINAL_CANCELLED]);

        $imprest =Imprest::where('id',$id)->with(['applicant'])->first();

        $imprest->update(['status' => Imprest::STATUS_ISSUED]);

        Mail::to($imprest->applicant->email)->send(new DeclineImprestLine($imprest));

        return redirect()->route('surrender.index');

    }

    public function approveImprest($id){
        

    Imprest::where('id',$id)->update(['status' => Imprest::HOD_APPROVED_SURRENDER]);

    SurrenderAttachment::where('imprest_id',$id)
            ->where('status',SurrenderAttachment::INITIATED)
            ->update(['status' => SurrenderAttachment::HOD_APPROVED]);

        return redirect()->route('surrender.index');
    }




}
