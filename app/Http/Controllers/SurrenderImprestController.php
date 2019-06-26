<?php

namespace App\Http\Controllers;

use App\Imprest;
use App\ImprestLine;
use App\Repositories\ImprestRepository;
use App\Repositories\InvoiceRepository;
use App\User;
use Illuminate\Foundation\Testing\Concerns\ImpersonatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Log;
use Response;

class SurrenderImprestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('imprest.surrendered');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return redirect()->route('imprest.surrendered');

        if (request()->header('Accept') == 'application/json') {
            return $this->surrenderimprestData();
        }
        if (! hasPermission(User::PERM_PROCESS_SURRENDER_IMPREST)) {
            abort(403);
        }

        return view('surrender-imprest.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! hasPermission(User::PERM_PROCESS_SURRENDER_IMPREST) &&
            ! hasPermission(User::PERM_EDIT_SURRENDER_IMPREST) &&
            ! hasPermission(User::PERM_FINALIZE_SURRENDER_IMPREST)
        ) {
            abort(403);
        }

        $data = $request->all();
        $details = json_decode($data['summary']);
        $imprest = Imprest::findOrFail($details->id);
        $imprest->status = $data['action'] == 'save' ? Imprest::STATUS_SURRENDERED : Imprest::STATUS_CLOSED;

        return DB::transaction(function () use ($data, $imprest, $details) {
            $imprest->fill([
                'surrender_cheque_number' => $data['cheque_number'],
                'surrender_cheque_date' => $data['cheque_date'],
                'surrender_cheque_amount' => $data['cheque_amount'],
                'surrender_cheque_remark' => $data['remark'],
            ]);
            $imprest->save();
            $imprest->lines()->delete();
            $allocatedLines = [];

            foreach ($details->accounted as $accounted) {
                ImprestLine::create([
                    'imprest_id' => $imprest->id,
                    'account_id' => $accounted->accountId,
                    'amount' => $accounted->amount
                ]);

                $allocatedLines[] = [
                    'account_id' => $accounted->accountId,
                    'amount' => $accounted->amount
                ];
            }

            $imprest->allocatedLines = $allocatedLines;

            if ($data['action'] == 'save') {
                /// insert to sage
                ImprestRepository::processReturnImprest($imprest);
                return redirect()->route('imprest.closed');
            }
            return redirect()->route('surrender.index');
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! hasPermission(User::PERM_EDIT_SURRENDER_IMPREST) && ! hasPermission(User::PERM_FINALIZE_SURRENDER_IMPREST)) {
            abort(403);
        }

        $imprest = Imprest::with(['lines' => function ($query) {
            $query->select('account_id', 'amount', 'imprest_id');
        }])->join('Accounts', 'Accounts.DCLink', '=', 'imprests.applicant_id')
            ->join('Project', 'Project.ProjectLink', '=', 'imprests.project_id', 'left')
            ->select(['imprests.*', 'Accounts.Name', 'Project.ProjectCode'])
            ->where('status', '=', Imprest::STATUS_SURRENDERED)
            ->where('id', $id)
            ->first();

        if (! $imprest) {
            abort(404);
        }

        return view('surrender-imprest.edit')->with('imprest', $imprest);
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

    public function surrenderimprestData()
    {
        $accounts = DB::table('Accounts')->select('AccountLink', 'Account', 'Description')->where('iAccountType',2)->get();
        $role=Auth::user()->role_id==3?"accounts":"others";

        $surrenderImprests = Imprest::join('Accounts', 'Accounts.DCLink', '=', 'imprests.applicant_id')
            ->join('Project', 'Project.ProjectLink', '=', 'imprests.project_id', 'left')
            ->select(['imprests.*', 'Accounts.Name', 'Project.ProjectCode'])
            ->when($role, function($query) use ($role){
                        if($role=="accounts"){
                            return $query->where('advance_amount','>=',5000);
                        }else{
                            return $query->where('advance_amount','<',5000);
                        }
                  })
              ->where('status', '=', Imprest::STATUS_ISSUED)
            ->get();
        return Response::json([
            'accounts' => $accounts,
            'imprests' => $surrenderImprests
        ]);
    }
}
