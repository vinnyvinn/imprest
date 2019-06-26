<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImprestFormRequest;
use App\Imprest;
use App\Repositories\ImprestRepository;
use App\Setting;
use App\User;
use App\Department;
use Mail;
use App\Mail\HodNotification;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\ImprestLimit;
use App\Currency, App\CurrencyHistory;
use Dompdf\Dompdf;
use Dompdf\Options;

class CreateImprestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return redirect()->route('imprest.unprocessed');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function create()
    {


        if (!hasPermission(User::PERM_PROCESS_IMPREST)) {
            abort(403);
        }

        $getLimit = ImprestLimit::get();
        $currencies = Currency::get();
        $unsurrenderd = Imprest::where('imprests.status', Imprest::STATUS_ISSUED)
            ->where('imprests.applicant_id', Auth::user()->sage_id)
            ->with('money')->get();
        if ($getLimit->first()->imprest_limit < count($unsurrenderd)) {
            flash('Surrender pedding imprests before make a new request', 'danger');
            return redirect()->back();
        }
        $projects = DB::table('Project')->select('ProjectLink', 'ProjectName', 'ProjectCode')->get();

        $imprestCount = 1;
        if (is_file(public_path('storage/imprestCount'))) {
            $imprestCount = file_get_contents(public_path('storage/imprestCount'));
        }

        $imprestNumber = date('Y/m/d') . '/' . $imprestCount;

        $columns = [
            'AccountLink', 'Account', 'description'
        ];

        $requiredSettings = [
            'department' => env('DEPARTMENT_UDF', 'Physical1'),
            'designation' => env('DESIGNATION_UDF', 'Physical2'),
            'personal_number' => env('PERSONAL_NUMBER_UDF', 'Physical3'),
        ];

        $num = Imprest::count();

        $imprestnum = "IMP" . '' . $num;

        $applicants = DB::table('Accounts')->select($columns)->get();

        $accounts = DB::table('Accounts')->select('AccountLink', 'Account', 'Description')->get();
        $officer = DB::table('users')->select('id', 'name')->where('department_id', Auth::user()->department_id)->where('role_id', 2)->first();

        $users = [];

        if (Auth::user()->role_id == 0) {
            $users = User::where('role_id', 2)->get();
        }
        return view('imprests.create', [
            'applicants' => $applicants,
            'imprestnum' => $imprestnum,
            'projects' => $projects,
            'settings' => $requiredSettings,
            'imprestNumber' => $imprestNumber,
            'currencies' => $currencies,
            'users' => $users
        ]);
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

    /**
     * Store a newly created resource in storage.
     *max:255
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->currency);
        $this->validate($request, [
            'advance_amount' => 'required',
            'nature_of_duty' => 'required',
        ]);
        if (!hasPermission(User::PERM_PROCESS_IMPREST) && !hasPermission(User::PERM_FINALIZE_IMPREST) && !hasPermission(User::PERM_EDIT_IMPREST)) {
            abort(403);
        }


        $imprestNumber = $this->getUniqueImprestNumber($request->imprest_number);

        $amount = $request->advance_amount;
        $officer = Department::where('dep_code', Auth::user()->department_id)
            ->first();
        $hodDetails = User::where('id', $officer->user_id)->first();
        $data = $request->all();
        $imp = new  Imprest();
        $imp->requester_id = Auth::user()->sage_id;
        $imp->applicant_id = Auth::user()->sage_id;
        $imp->process = 0;
        $imp->officer_id = $request->officer_id ?: $officer->user_id;
        $imp->imprest_number = $imprestNumber;
        $imp->currency = $request->currency;
        $imp->location = $request->location;


        if ($request->currency != 0) {
            $currency_hist = CurrencyHistory::where('iCurrencyID', $request->currency)
                ->orderBy('idCurrencyHist', 'DESC')
                ->first();
            //$amount= $amount * $currency_hist->fSellRate;
            $imp->currency_link_id = $currency_hist->idCurrencyHist;
        }

        $imp->advance_amount = $amount;
        // if($amount <=500 || $request->currency == 1 ){ // self creating imprest
        $imp->status = Imprest::STATUS_UNPROCESSED;
        //}

        $imp->project_id = $request->project_id;
        $imp->nature_of_duty = $request->nature_of_duty;
        $imp->imprest_type = $request->imprest_type;

        $imp->save();
        $id = $imp->id;

        if (count($hodDetails) > 0) {
            Mail::to($hodDetails)->send(new HodNotification(Imprest::where('id', $id)->first(), 'Admin'));
        }


        if (is_file(public_path('storage/imprestCount'))) {
            $imprestCount = intval(file_get_contents(public_path('storage/imprestCount')));
            $imprestCount += 1;
            file_put_contents(public_path('storage/imprestCount'), $imprestCount);
            return redirect()->route('imprest.index');
        } else if (!is_dir(public_path('storage'))) {
            mkdir(public_path('storage'));
        }
        file_put_contents(public_path('storage/imprestCount'), 2);
        if ($imp) {
            flash('Imprest Requested successfully ', 'success');

        } else {
            flash('Error Creating new Imprest', 'error');

        }
        return redirect()->route('imprest.unprocessed');
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
        $columns = [
            'imprests.*', 'Accounts.Description', 'Project.ProjectCode', 'Project.projectname', 'users.emp_payroll_no', 'departments.name'];
        // $columns[] = 'Accounts.' . env('DEPARTMENT_UDF');
        // $columns[] = 'Accounts.' . env('DESIGNATION_UDF');
        // $columns[] = 'Accounts.' . env('PERSONAL_NUMBER_UDF');


        $imprest = Imprest::join('users', 'users.sage_id', '=', 'imprests.applicant_id')
            ->join('Project', 'Project.ProjectLink', '=', 'imprests.project_id', 'left')
            ->join('departments', 'departments.id', '=', 'users.department_id', 'left')
            ->join('Accounts', 'Accounts.ucGLHRNO', '=', 'users.emp_payroll_no', 'left')
            ->where('imprests.id', $id)
            ->with(['currency.denomination'])
            ->firstOrFail($columns);

        return view('process-imprest.show')
            ->withDesignation(env('DESIGNATION_UDF'))
            ->withDepartment(env('DEPARTMENT_UDF'))
            ->withPersonal(env('PERSONAL_NUMBER_UDF'))
            ->with('imprest', $imprest);
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

        //dd('do you treated doingfdsf');

        if (!hasPermission(User::PERM_FINALIZE_IMPREST) && !hasPermission(User::PERM_EDIT_IMPREST)) {
            abort(403);
        }

        $columns = [
            'AccountLink', 'Account', 'Description',
        ];
        $imprest = Imprest::leftJoin('Accounts', 'Accounts.AccountLink', '=', 'imprests.applicant_id')
            ->join('Project', 'Project.ProjectLink', '=', 'imprests.project_id')
            ->with(['currency.denomination'])
            ->find($id);
        $departments = Department::all();
        $applicants = DB::table('Accounts')->select($columns)->get();
        $projects = DB::table('Project')->get();


        if (Auth::user()->role_id == 2) {
            //hod dd($imprest);
            return view('imprests.imprest_approve')
                ->with('imprest', $imprest)
                ->with('departments', $departments)
                ->with('projects', $projects)
                ->with('applicants', $applicants);
        } else {
            $Accounts = DB::table('Accounts')->where('iAccountType', 2)->get();
            $projects = DB::table('Project')->get();
            return view('process-imprest.edit', ['imprest' => $imprest, 'accounts' => $Accounts, 'projects' => $projects]);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {


        if (isset($request->decline)) {
            return redirect()->route('imprest.reason-form', ['id' => $request->id, 'rq_no' => $request->requester_id]);

        }

        $hodemail = Imprest::join('users', 'imprests.requester_id', '=', 'users.sage_id')
            ->where('users.sage_id', $request->requester_id)->first();
        $hodmail = $hodemail->email;
        $imprest = Imprest::where('id', $request->id)->with(['money'])->first();
//          if($imprest->money != null) {
//             $request->advance_amount *= $imprest->money->fSellRate;
//          }


        if (Auth::user()->role_id == 2 && $request->advance_amount < 5000 || $imprest->currency == 1) {

            $update = Imprest::where('imprest_number', $request->imprest_number)
                ->update(['status' => Imprest::STATUS_APPROVED, 'advance_amount' => $request->get('advance_amount'), 'nature_of_duty' => $request->get('nature_of_duty')]);
//            dd($update);
            $Accounts = User::where("role_id", 0)->get();
            foreach ($Accounts as $account) {
                Mail::to($account->email)->send(new HodNotification($request, "Admin"));
            }


        }

        elseif (Auth::user()->role_id == 0 && $request->advance_amount < 5000 && $imprest->currency != 1) {

            $update = Imprest::where('imprest_number', $request->imprest_number)
                ->update(['status' => Imprest::STATUS_ISSUED, 'advance_amount' => $request->get('advance_amount'), 'nature_of_duty' => $request->get('nature_of_duty')]);

            //call repo
            ImprestRepository::processImprest($request, $request->applicant_id, $request->imprest_number, $request->advance_amount);
            Mail::to($hodmail)->send(new HodNotification($request));


        } elseif (Auth::user()->role_id == 2 && $request->advance_amount >= 5000 || $imprest->currency == 1) {

            $update = Imprest::where('imprest_number', $request->imprest_number)
                ->update(['status' => Imprest::STATUS_APPROVED, 'advance_amount' => $request->get('advance_amount')]);

            $Users = User::where('role_id', 3)->first();

            Mail::to($Users->email)->send(new HodNotification($request, 'finance'));


        } elseif (Auth::user()->role_id == 3 && $request->advance_amount >= 5000 || $imprest->currency == 1) {

            $update = Imprest::where('imprest_number', $request->imprest_number)
                ->update(['status' => Imprest::STATUS_ISSUED, 'advance_amount' => $request->get('advance_amount')]);

            //call repo
            ImprestRepository::processImprest($request, $request->applicant_id, $request->imprest_number, $request->advance_amount);
            Mail::to($hodmail)->send(new HodNotification($request));


        }


        $input = $request->has('approve');

        if (isset($input)) {

            flash('Imprest Approved successfully ', 'success');

            return redirect()->route('imprest.index');
        }
        //print pdf


        //ImprestRepository::processImprest($imprest->applicant_id, $imprest->imprest_number, $imprest->advance_amount);

        return redirect()->route('imprest.processed');
    }

    public function Reason($id, $rq_no)
    {

        return view('imprests.decline-imprest')->with('id', $id)->with('requester_id', $rq_no);
    }

    public function ImprestChnage()
    {

//stt
        Imprest::where('id', request()->get('id'))->update(['reason' => request()->get('reason')]);
        $dec = Imprest::join('users', 'imprests.requester_id', '=', 'users.sage_id')
            //->select('imprests.id')
            ->where('users.sage_id', request()->get('requester_id'))->first();
        $imp = Imprest::where('id', request()->get('id'))->first();

//dd(request()->get('requester_id'));
        Mail::to($dec->email)->send(new HodNotification($imp, "user"));

        $decline = Imprest::where('imprest_number', $imp->imprest_number)->update(['status' => Imprest::STATUS_CANCELLED]);

        return redirect()->route('imprest.processed');

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
        //
    }

    private function prepareInsert($data)
    {
        //$data['date_of_issue'] = Carbon::parse($data['date_of_issue'])->format('Y-m-d');
        //$data['cheque_date'] = Carbon::parse($data['cheque_date'])->format('Y-m-d');
//        $data['CB_date'] = Carbon::parse($data['CB_date'])->format('Y-m-d');
        // $data['due_date'] = Carbon::parse($data['due_date'])->format('Y-m-d');
//         if (isset($data['officer_in_charge'])) {
//             $data['officer_id'] = $data['officer_in_charge'];
//             unset($data['officer_in_charge']);
//         }
// //        $data['CB_number'] = $data['CB_Number'];
//         $data['account_id'] = $data['account_number'];
//         unset($data['account_number']);
// //        unset($data['CB_Number']);

//         return $data;
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

    public function printImprest($id)
    {
        $columns = [
            'imprests.*', 'Accounts.Description', 'Accounts.ucGLHRNO', 'Project.ProjectCode', '_rtblAgents.cAgentName', 'departments.name'

        ];
        // $columns[] = 'Accounts.' . env('DEPARTMENT_UDF');
        // $columns[] = 'Accounts.' . env('DESIGNATION_UDF');
        // $columns[] = 'Accounts.' . env('PERSONAL_NUMBER_UDF');


        $imprests = Imprest::leftJoin('Accounts', 'Accounts.AccountLink', '=', 'imprests.applicant_id')
            ->join('Project', 'Project.ProjectLink', '=', 'imprests.project_id', 'left')
            ->join('_rtblAgents', '_rtblAgents.idAgents', '=', 'imprests.officer_id', 'left')
            ->join('departments', 'departments.user_id', '=', 'imprests.officer_id', 'right')
            ->with(['currency.denomination', 'officer'])
            ->where('imprests.id', $id)
            ->firstOrFail($columns);
        $view = view('report.approve_receipt')
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

        return $dompdf->stream('warrant.pdf', ['Attachment' => 0]);


    }
}
