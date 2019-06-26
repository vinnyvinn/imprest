<?php

namespace App\Http\Controllers;
use App\Applicant;
use App\Imprest;
use DB;
use Auth;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use App\PettyCash;
use App\User;
use Session;

class ImprestController extends Controller
{
    public function unprocessed()
    {
        //dd(DB::table('Accounts')->get());

      //dd(Auth::user()->role_id);
        $runinngBalances=PettyCash::where('transaction_type',PettyCash::POSITIVE)
                    ->orWhere('transaction_type',PettyCash::NEGATE)
                    ->get();

      if(Auth::user()->role_id == 1){
        //user


        $imprests = Imprest::join('Accounts', 'Accounts.AccountLink', '=', 'imprests.applicant_id')
                ->join('Project','Project.ProjectLink','=','imprests.project_id')
                ->whereIn('status',[Imprest::STATUS_APPROVED,Imprest::STATUS_UNPROCESSED,Imprest::STATUS_CANCELLED])
                ->where('imprests.requester_id', Auth::user()->sage_id)

                 ->orderBy('imprests.created_at','desc')
                ->with(['currency.denomination'])
                ->get(['imprests.*','Accounts.Description','Project.ProjectName']);


          }elseif (Auth::user()->role_id == 2) {
            // hod

           $imprests = Imprest::join('users', 'users.sage_id', '=' , 'imprests.applicant_id')
                ->join('Accounts', 'Accounts.AccountLink', '=', 'users.sage_id')
                ->join('Project','Project.ProjectLink','=','imprests.project_id')
                // ->where('users.department_id', Auth::user()->department_id) //anybody with role 2 and head of department.

                //->where('imprests.officer_id',Auth::user()->id)
               //->where('users.role_id',Auth::user()->role_id)
                ->whereIn('status',[Imprest::STATUS_UNPROCESSED,Imprest::STATUS_CANCELLED])
               //->whereNotIn('status', [Imprest::STATUS_SURRENDERED,Imprest::USER_INITIATED_SURRENDER])

                ->distinct('imprests.imprest_no')
                ->with(['currency.denomination'])
                ->orderBy('imprests.created_at','desc')
                ->get(['imprests.*','Accounts.Description','Project.ProjectName']);
      //dd($imprests);

          }elseif(Auth::user()->role_id==3){
      //dd('wowwww');
            //finance
        $imprests = Imprest::join('Accounts', 'Accounts.AccountLink', '=', 'imprests.applicant_id')
                ->leftJoin('users', 'users.id', '=' , 'imprests.requester_id')
                ->join('Project','Project.ProjectLink','=','imprests.project_id')
                //->distinct('imprests.imprest_no')
                ->orderBy('imprests.created_at','desc')
                ->where('status', Imprest::STATUS_APPROVED)
                 ->where('advance_amount','>=',5000)
                 ->orWhere('currency','=',1)->where('status',Imprest::STATUS_APPROVED)
                  ->orWhere('status','=',111)
                  ->with(['currency.denomination'])
                ->get(['imprests.*', 'Accounts.Description','Project.ProjectName']);

          }

          else if(Auth::user()->role_id == User::SYSTEM_ADMIN_ROLE ){

            $imprests = Imprest::join('Accounts','Accounts.AccountLink','=','imprests.applicant_id')
                ->whereIn('imprests.status',[Imprest::STATUS_APPROVED,Imprest::STATUS_UNPROCESSED,Imprest::STATUS_PROCESSED])
                ->orWhere('status','=',111)
                ->join('Project','Project.ProjectLink','=','imprests.project_id')
                ->distinct('imprests.imprest_no')
                ->with(['currency.denomination'])
                ->get();

          }
          else{

            // petty cash admin
         //dd('petty cash admin');

            $imprests = Imprest::join('Accounts','Accounts.AccountLink','=','imprests.applicant_id')
                ->where('imprests.status',Imprest::STATUS_APPROVED)
                ->where('advance_amount','<',5000)
                ->where('currency','!=',1)
                ->orWhere('status','=',111)
                ->join('Project','Project.ProjectLink','=','imprests.project_id')
                ->distinct('imprests.imprest_no')
                ->orderBy('imprests.created_at','desc')
                ->with(['currency.denomination'])
                ->get();

            //dd($imprestaothers);
//            $imprestsmine = Imprest::join('Accounts','Accounts.AccountLink','=','imprests.applicant_id')
//                ->where('imprests.applicant_id', Auth::user()->sage_id)
//                ->join('Project','Project.ProjectLink','=','imprests.project_id')
//                ->distinct('imprests.imprest_no')
//                ->where('advance_amount','<', 5000)
//                ->orderBy('imprests.created_at','desc')
//                ->with(['currency.denomination'])
//                ->get();
            ///$imprests = $imprestaothers->merge($imprestsmine);


          }

//dd($imprests);
        return view('imprests.index',['runinngBalances'=>$runinngBalances])->with('imprests', $imprests)->withTitle('Unprocessed');
    }
    public function processed()    {

                $imprests = Imprest::join('Accounts', 'Accounts.AccountLink', '=', 'imprests.applicant_id')
                ->join('Project','Project.ProjectLink','=','imprests.project_id')
                ->where('status',Imprest::STATUS_ISSUED)
                //->where('imprests.requester_id', Auth::user()->sage_id)
               // ->where('imprests.advance_amount','<',5000)
                   ->with(['currency.denomination'])
                ->get(['imprests.*', 'Accounts.Description','Project.ProjectName']);

        return view('imprests.index')->with('imprests', $imprests)->withTitle('Processed');
    }
    public function myunprocessed()
    {


        $imprests = Imprest::join('users', 'users.sage_id', '=' , 'imprests.applicant_id')
            ->join('Accounts', 'Accounts.AccountLink', '=', 'users.sage_id')
            ->join('Project','Project.ProjectLink','=','imprests.project_id')
            // ->where('users.department_id', Auth::user()->department_id) //anybody with role 2 and head of department.

            //->where('imprests.officer_id',Auth::user()->id)
            ->where('users.role_id',Auth::user()->role_id)
             ->distinct('imprests.imprest_no')
            ->with(['currency.denomination'])
            ->orderBy('imprests.created_at','desc')
            ->get(['imprests.*','Accounts.Description','Project.ProjectName']);

        return view('imprests.index2')->with('imprests', $imprests)->withTitle('My');
    }

    public function surrendered()
    {
        
        //&& (($imprest->status == App\Imprest::USER_INITIATED_SURRENDER ) || ($imprest->status == App\Imprest::HOD_APPROVED_SURRENDER )))
        $imprests = Imprest::join('Accounts', 'Accounts.AccountLink', '=', 'imprests.applicant_id')
            ->with(['currency.denomination'])
            ->whereIn('status', [Imprest::STATUS_SURRENDERED,Imprest::USER_INITIATED_SURRENDER])
            ->orderBy('updated_at','desc')
            ->get(['imprests.*', 'Accounts.Description']);

           // dd($imprests);
         if(Auth::user()->role_id == 2){

         $imprestaothers = Imprest::join('Accounts', 'Accounts.AccountLink', '=', 'imprests.applicant_id')
                        ->join('Project','Project.ProjectLink','=','imprests.project_id')
                        ->whereIn('status',[Imprest::USER_INITIATED_SURRENDER])
                        ->where('imprests.officer_id', Auth::user()->id)
                        ->orderBy('updated_at','desc')
                        ->get();

            $imprests = $imprestaothers->merge($imprests); 
         }elseif(Auth::user()->role_id == 3 || Auth::user()->role_id == 0){    

            $role =Auth::user()->role_id ==3?"finance":"imprestadmin";

            $imprestaothers = Imprest::join('Accounts', 'Accounts.AccountLink', '=', 'imprests.applicant_id')
                        ->join('Project','Project.ProjectLink','=','imprests.project_id')
                        ->whereIn('status',[Imprest::HOD_APPROVED_SURRENDER])
                        ->when($role , function($query) use ($role){
                            if($role =='finance'){
                              return  $query->where('advance_amount','>=',5000);
                            }else{
                              return  $query->where('advance_amount','<',5000);

                            }

                        })
                        ->get();
            $imprests = $imprestaothers->merge($imprests); 
         }

        return view('imprests.index')->with('imprests', $imprests)->withTitle('Surrendered');
    }

    public function closed()
    {
        $imprests = Imprest::join('Accounts', 'Accounts.AccountLink', '=', 'imprests.applicant_id')
            ->where('status', Imprest::STATUS_CLOSED)
            ->with(['currency.denomination'])
            ->get(['imprests.*', 'Accounts.Description']);

        return view('imprests.index')->with('imprests', $imprests)->withTitle('Closed');
    }

    public function printImprest($id)
    {
        
  $columns = [
            'imprests.*', 'Accounts.Description','Accounts.ucGLHRNO','Project.ProjectCode', '_rtblAgents.cAgentName','departments.name'
          
        ];
        // $columns[] = 'Accounts.' . env('DEPARTMENT_UDF');
        // $columns[] = 'Accounts.' . env('DESIGNATION_UDF');
        // $columns[] = 'Accounts.' . env('PERSONAL_NUMBER_UDF');


        $imprests = Imprest::join('Accounts', 'Accounts.AccountLink', '=', 'imprests.applicant_id')
            ->join('Project', 'Project.ProjectLink', '=', 'imprests.project_id', 'left')
            ->join('_rtblAgents', '_rtblAgents.idAgents', '=', 'imprests.officer_id', 'left')
            ->join('departments', 'departments.user_id', '=', 'imprests.officer_id','right')
            ->with(['currency.denomination'])
            ->where('imprests.id', $id)
            ->firstOrFail($columns);
        $view = view('report.warant')
            ->withDesignation(env('DESIGNATION_UDF'))
            ->withDepartment(env('DEPARTMENT_UDF'))
            ->withPersonal(env('PERSONAL_NUMBER_UDF'))
            ->withImprest($imprests)
            ->render();

        $dompdf = new Dompdf();
        $option = new Options([
            'tempDir' => storage_path(),
            'fontDir' => storage_path(),
            'fontCache' => storage_path(),
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true
        ]);
        $dompdf->setOptions($option);
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="warrant.pdf"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');

        $dompdf->stream('warrant.pdf', ['Attachment' => 0]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cashForm()
    {
        return view('imprests.cash')->with('imprests',Imprest::where('is_oversurrender','=',0)
                 ->where('status','!=',111)
                 ->orderBy('created_at','desc')->get());
    }

//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//        $applicants = DB::table('Client')->select('AccountLink', 'Account', 'Name')->get();
//        return view('create')->withImprest(Imprest::all())
//            ->withApplicants($applicants);
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function store(Request $request)
//    {
//        //
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function show($id)
//    {
//        //
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function edit($id)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy($id)
//    {
//        //
//    }
public function cash_amount($id){
        $ouput = Imprest::where('id','=',$id)->first()->advance_amount;
    return Response($ouput);
}

    public function updateMoney()
    {
        $imprest = Imprest::where('id',request()->get('imprest_number'))->first();
        $total_cash= ($imprest->advance_amount) -($imprest->return_cash + $imprest->surrendered_amount);
          if($total_cash < request()->get('return_cash')){
            Session::flash('warning','The amount entered is greater than the imprest amount.');
            return redirect()->route('imprest.cash-form');
        }
        Imprest::where('id',request()->get('imprest_number'))->update(['return_cash' => ($imprest->return_cash + request()->get('return_cash'))]);
        $imp_no = Imprest::count();

        $imprestNumber = $this->getUniqueImprestNumber(Imprest::where('id',$imp_no)->first()->imprest_number);

        $imp = new Imprest();
        $imp->requester_id = $imprest->requester_id ;
        $imp->applicant_id = $imprest->requester_id ;
        $imp->process = 0;
        $imp->officer_id = $imprest->officer_id ?: $imprest->user_id;
        $imp->imprest_number = $imprestNumber;
        $imp->currency = $imprest->currency;
        $imp->location = $imprest->location;
        $imp->currency_link_id = $imprest->currency_link_id;
        $imp->advance_amount = $imprest->advance_amount;
        $imp->status = 111;
        $imp->project_id = $imprest->project_id;
        $imp->nature_of_duty = $imprest->currency_link_id ? 'USD '.request()->get('return_cash').' returned for Imprest '.$imprest->imprest_number
        : 'KSH '.request()->get('return_cash').' returned for Imprest '.$imprest->imprest_number;
        $imp->imprest_type = $imprest->imprest_type;
        $imp->return_cash = request()->get('imprest_number');
        $imp->save();

//update returned cash


       return redirect()->route('imprest.unprocessed');
}
    public function getUniqueImprestNumber($imprest)
    {
        $checkImprest = Imprest::where('imprest_number', $imprest)->first();

        if (count($checkImprest) < 1) {
            return $imprest;
        } else {

            $position = explode('P', $imprest);
            $imprest = 'IMP' . ($position[1] + 1);

            return self::getUniqueImprestNumber($imprest);
        }
    }

    public function generateImprestNumber()
    {
        $number = mt_rand(1000000000, 9999999999); // better than rand()

        // call the same function if the barcode exists already
        if ($this->imprestNumberExists($number)) {
            return generateImprestNumber();
        }

        // otherwise, it's valid and can be used
        return $number;
    }

    public function imprestNumberExists($number)
    {
        // query the database and return a boolean
        // for instance, it might look like this in Laravel
        return Imprest::where('imprest_number', $number)->exists();
    }

}
