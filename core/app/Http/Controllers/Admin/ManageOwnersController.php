<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailLog;
use App\Models\GeneralSetting;
use App\Models\Owner;
use App\Models\Property;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\WithdrawMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageOwnersController extends Controller
{
    public function allOwners()
    {
        $pageTitle = 'Manage Owners';
        $emptyMessage = 'No owner found';
        $owners = Owner::orderBy('id','desc')->paginate(getPaginate());
        return view('admin.owners.list', compact('pageTitle', 'emptyMessage', 'owners'));
    }

    public function activeOwners()
    {
        $pageTitle = 'Manage Active Owners';
        $emptyMessage = 'No active owner found';
        $owners = Owner::active()->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.owners.list', compact('pageTitle', 'emptyMessage', 'owners'));
    }

    public function bannedOwners()
    {
        $pageTitle = 'Banned Owners';
        $emptyMessage = 'No banned owner found';
        $owners = Owner::banned()->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.owners.list', compact('pageTitle', 'emptyMessage', 'owners'));
    }

    public function emailUnverifiedOwners()
    {
        $pageTitle = 'Email Unverified Owners';
        $emptyMessage = 'No email unverified owner found';
        $owners = Owner::emailUnverified()->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.owners.list', compact('pageTitle', 'emptyMessage', 'owners'));
    }
    public function emailVerifiedOwners()
    {
        $pageTitle = 'Email Verified Owners';
        $emptyMessage = 'No email verified owner found';
        $owners = Owner::emailVerified()->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.owners.list', compact('pageTitle', 'emptyMessage', 'owners'));
    }


    public function smsUnverifiedOwners()
    {
        $pageTitle = 'SMS Unverified Owners';
        $emptyMessage = 'No sms unverified owner found';
        $owners = Owner::smsUnverified()->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.owners.list', compact('pageTitle', 'emptyMessage', 'owners'));
    }


    public function smsVerifiedOwners()
    {
        $pageTitle = 'SMS Verified Owners';
        $emptyMessage = 'No sms verified owner found';
        $owners = Owner::smsVerified()->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.owners.list', compact('pageTitle', 'emptyMessage', 'owners'));
    }

    
    public function ownersWithBalance()
    {
        $pageTitle = 'Owners with balance';
        $emptyMessage = 'No sms verified owner found';
        $owners = Owner::where('balance','!=',0)->orderBy('id','desc')->paginate(getPaginate());
        return view('admin.owners.list', compact('pageTitle', 'emptyMessage', 'owners'));
    }


    public function search(Request $request, $scope)
    {
        $search = $request->search;
        $owners = Owner::where(function ($owner) use ($search) {
            $owner->where('username', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        });
        $pageTitle = '';
        if ($scope == 'active') {
            $pageTitle = 'Active ';
            $owners = $owners->where('status', 1);
        }elseif($scope == 'banned'){
            $pageTitle = 'Banned';
            $owners = $owners->where('status', 0);
        }elseif($scope == 'emailUnverified'){
            $pageTitle = 'Email Unverified ';
            $owners = $owners->where('ev', 0);
        }elseif($scope == 'smsUnverified'){
            $pageTitle = 'SMS Unverified ';
            $owners = $owners->where('sv', 0);
        }elseif($scope == 'withBalance'){
            $pageTitle = 'With Balance ';
            $owners = $owners->where('balance','!=',0);
        }

        $owners = $owners->paginate(getPaginate());
        $pageTitle .= 'Owner Search - ' . $search;
        $emptyMessage = 'No search result found';
        return view('admin.owners.list', compact('pageTitle', 'search', 'scope', 'emptyMessage', 'owners'));
    }


    public function detail($id)
    {
        $pageTitle = 'Owner Detail';
        $owner = Owner::findOrFail($id);
        $totalWithdraw = Withdrawal::where('owner_id',$owner->id)->where('status',1)->sum('amount');
        $totalTransaction = Transaction::where('owner_id',$owner->id)->count();
        $totalProperties = Property::where('owner_id', $owner->id)->count();
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view('admin.owners.detail', compact('pageTitle', 'owner','totalWithdraw','totalTransaction', 'totalProperties', 'countries'));
    }


    public function update(Request $request, $id)
    {
        $owner = Owner::findOrFail($id);

        $countryData = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        $request->validate([
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'email' => 'required|email|max:90|unique:owners,email,' . $owner->id,
            'mobile' => 'required|unique:owners,mobile,' . $owner->id,
            'country' => 'required',
        ]);
        $countryCode = $request->country;
        $owner->mobile = $request->mobile;
        $owner->country_code = $countryCode;
        $owner->firstname = $request->firstname;
        $owner->lastname = $request->lastname;
        $owner->email = $request->email;
        $owner->address = [
                            'address' => $request->address,
                            'city' => $request->city,
                            'state' => $request->state,
                            'zip' => $request->zip,
                            'country' => @$countryData->$countryCode->country,
                        ];
        $owner->status = $request->status ? 1 : 0;
        $owner->ev = $request->ev ? 1 : 0;
        $owner->sv = $request->sv ? 1 : 0;
        $owner->ts = $request->ts ? 1 : 0;
        $owner->tv = $request->tv ? 1 : 0;
        $owner->save();

        $notify[] = ['success', 'Owner detail has been updated'];
        return redirect()->back()->withNotify($notify);
    }

    public function addSubBalance(Request $request, $id)
    {
        $request->validate(['amount' => 'required|numeric|gt:0']);

        $owner = Owner::findOrFail($id);
        $amount = $request->amount;
        $general = GeneralSetting::first(['cur_text','cur_sym']);
        $trx = getTrx();

        if ($request->act) {
            $owner->balance += $amount;
            $owner->save();
            $notify[] = ['success', $general->cur_sym . $amount . ' has been added to ' . $owner->username . '\'s balance'];

            $transaction = new Transaction();
            $transaction->owner_id = $owner->id;
            $transaction->amount = $amount;
            $transaction->post_balance = $owner->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Added Balance Via Admin';
            $transaction->trx =  $trx;
            $transaction->save();

            notify($owner, 'BAL_ADD', [
                'trx' => $trx,
                'amount' => showAmount($amount),
                'currency' => $general->cur_text,
                'post_balance' => showAmount($owner->balance),
            ], 'owner');

        } else {
            if ($amount > $owner->balance) {
                $notify[] = ['error', $owner->username . '\'s has insufficient balance.'];
                return back()->withNotify($notify);
            }
            $owner->balance -= $amount;
            $owner->save();

            $transaction = new Transaction();
            $transaction->owner_id = $owner->id;
            $transaction->amount = $amount;
            $transaction->post_balance = $owner->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '-';
            $transaction->details = 'Subtract Balance Via Admin';
            $transaction->trx =  $trx;
            $transaction->save();


            notify($owner, 'BAL_SUB', [
                'trx' => $trx,
                'amount' => showAmount($amount),
                'currency' => $general->cur_text,
                'post_balance' => showAmount($owner->balance)
            ], 'owner');
            $notify[] = ['success', $general->cur_sym . $amount . ' has been subtracted from ' . $owner->username . '\'s balance'];
        }
        return back()->withNotify($notify);
    }


    public function ownerLoginHistory($id)
    {
        $owner = Owner::findOrFail($id);
        $pageTitle = 'Owner Login History - ' . $owner->username;
        $emptyMessage = 'No owners login found.';
        $login_logs = $owner->login_logs()->orderBy('id','desc')->with('owner')->paginate(getPaginate());
        return view('admin.owners.logins', compact('pageTitle', 'emptyMessage', 'login_logs'));
    }



    public function showEmailSingleForm($id)
    {
        $owner = Owner::findOrFail($id);
        $pageTitle = 'Send Email To: ' . $owner->username;
        return view('admin.owners.email_single', compact('pageTitle', 'owner'));
    }

    public function sendEmailSingle(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:65000',
            'subject' => 'required|string|max:190',
        ]);

        $owner = Owner::findOrFail($id);
        sendGeneralEmail($owner->email, $request->subject, $request->message, $owner->username);
        $notify[] = ['success', $owner->username . ' will receive an email shortly.'];
        return back()->withNotify($notify);
    }

    public function transactions(Request $request, $id)
    {
        $owner = Owner::findOrFail($id);
        if ($request->search) {
            $search = $request->search;
            $pageTitle = 'Search Owner Transactions : ' . $owner->username;
            $transactions = $owner->transactions()->where('trx', $search)->with('owner')->orderBy('id','desc')->paginate(getPaginate());
            $emptyMessage = 'No transactions';
            return view('admin.reports.transactions', compact('pageTitle', 'search', 'owner', 'transactions', 'emptyMessage'));
        }
        $pageTitle = 'Owner Transactions : ' . $owner->username;
        $transactions = $owner->transactions()->with('owner')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No transactions';
        return view('admin.reports.transactions', compact('pageTitle', 'owner', 'transactions', 'emptyMessage'));
    }

    public function properties(Request $request, $id){
        $owner = Owner::findOrFail($id);
        $pageTitle = 'Owner Properties : ' . $owner->username;
        $properties = Property::with('propertyType', 'location', 'amenities', 'rooms', 'roomCategories' )->where('owner_id', $id)->orderBy('id', 'DESC')->paginate(getPaginate());
        $emptyMessage = 'No properties';
        return view('admin.property.index', compact('pageTitle', 'owner', 'properties', 'emptyMessage'));
    }


    public function withdrawals(Request $request, $id)
    {
        $owner = Owner::findOrFail($id);
        if ($request->search) {
            $search = $request->search;
            $pageTitle = 'Search Owner Withdrawals : ' . $owner->username;
            $withdrawals = $owner->withdrawals()->where('trx', 'like',"%$search%")->orderBy('id','desc')->paginate(getPaginate());
            $emptyMessage = 'No withdrawals';
            return view('admin.withdraw.withdrawals', compact('pageTitle', 'owner', 'search', 'withdrawals', 'emptyMessage'));
        }
        $pageTitle = 'Owner Withdrawals : ' . $owner->username;
        $withdrawals = $owner->withdrawals()->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No withdrawals';
        $ownerId = $owner->id;
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'owner', 'withdrawals', 'emptyMessage','ownerId'));
    }

    public  function withdrawalsViaMethod($method,$type,$ownerId){
        $method = WithdrawMethod::findOrFail($method);
        $owner = Owner::findOrFail($ownerId);
        if ($type == 'approved') {
            $pageTitle = 'Approved Withdrawal of '.$owner->username.' Via '.$method->name;
            $withdrawals = Withdrawal::where('status', 1)->where('owner_id',$owner->id)->with(['owner','method'])->orderBy('id','desc')->paginate(getPaginate());
        }elseif($type == 'rejected'){
            $pageTitle = 'Rejected Withdrawals of '.$owner->username.' Via '.$method->name;
            $withdrawals = Withdrawal::where('status', 3)->where('owner_id',$owner->id)->with(['owner','method'])->orderBy('id','desc')->paginate(getPaginate());

        }elseif($type == 'pending'){
            $pageTitle = 'Pending Withdrawals of '.$owner->username.' Via '.$method->name;
            $withdrawals = Withdrawal::where('status', 2)->where('owner_id',$owner->id)->with(['owner','method'])->orderBy('id','desc')->paginate(getPaginate());
        }else{
            $pageTitle = 'Withdrawals of '.$owner->username.' Via '.$method->name;
            $withdrawals = Withdrawal::where('status', '!=', 0)->where('owner_id',$owner->id)->with(['owner','method'])->orderBy('id','desc')->paginate(getPaginate());
        }
        $emptyMessage = 'Withdraw Log Not Found';
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'emptyMessage','method'));
    }

    public function showEmailAllForm()
    {
        $pageTitle = 'Send Email To All Owners';
        return view('admin.owners.email_all', compact('pageTitle'));
    }

    public function sendEmailAll(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:65000',
            'subject' => 'required|string|max:190',
        ]);

        foreach (Owner::where('status', 1)->cursor() as $owner) {
            sendGeneralEmail($owner->email, $request->subject, $request->message, $owner->username);
        }

        $notify[] = ['success', 'All owners will receive an email shortly.'];
        return back()->withNotify($notify);
    }

    public function login($id){
        $owner = Owner::findOrFail($id);
        Auth::guard('owner')->login($owner);
        return redirect()->route('owner.dashboard');
    }

    public function emailLog($id){
        $owner = Owner::findOrFail($id);
        $pageTitle = 'Email log of '.$owner->username;
        $logs = EmailLog::where('owner_id',$id)->with('owner')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No data found';
        return view('admin.owners.email_log', compact('pageTitle','logs','emptyMessage','owner'));
    }

    public function emailDetails($id){
        $email = EmailLog::findOrFail($id);
        $pageTitle = 'Email details';
        return view('admin.owners.email_details', compact('pageTitle','email'));
    }
}
