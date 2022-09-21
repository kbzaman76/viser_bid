<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailLog;
use App\Models\Transaction;
use App\Models\UserLogin;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function userTransaction()
    {
        $pageTitle = 'User Transactions';
        $transactions = Transaction::where('user_id', '!=', 0)->with('user')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No transactions.';
        return view('admin.reports.user_transactions', compact('pageTitle', 'transactions', 'emptyMessage'));
    }

    public function userTransactionSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $pageTitle = 'User Transactions Search - ' . $search;
        $emptyMessage = 'No transactions.';

        $transactions = Transaction::with('user')->whereHas('user', function ($user) use ($search) {
            $user->where('username', 'like',"%$search%");
        })->orWhere('trx', $search)->orderBy('id','desc')->paginate(getPaginate());

        return view('admin.reports.user_transactions', compact('pageTitle', 'transactions', 'emptyMessage','search'));
    }

    public function merchantTransaction()
    {
        $pageTitle = 'Merchant Transactions';
        $transactions = Transaction::where('merchant_id', '!=', 0)->with('merchant')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No transactions.';
        return view('admin.reports.merchant_transactions', compact('pageTitle', 'transactions', 'emptyMessage'));
    }

    public function merchantTransactionSearch(Request $request)
    {
        $request->validate(['search' => 'required']);
        $search = $request->search;
        $pageTitle = 'Merchant Transactions Search - ' . $search;
        $emptyMessage = 'No transactions.';

        $transactions = Transaction::with('merchant')->whereHas('merchant', function ($merchant) use ($search) {
            $merchant->where('username', 'like',"%$search%");
        })->orWhere('trx', $search)->orderBy('id','desc')->paginate(getPaginate());

        return view('admin.reports.merchant_transactions', compact('pageTitle', 'transactions', 'emptyMessage','search'));
    }

    public function userLoginHistory(Request $request)
    {
        if ($request->search) {
            $search = $request->search;
            $pageTitle = 'User Logins Search - ' . $search;
            $emptyMessage = 'No search result found.';
            $login_logs = UserLogin::where('user_id', '!=', 0)->whereHas('user', function ($query) use ($search) {
                $query->where('username', $search);
            })->orderBy('id','desc')->with('user')->paginate(getPaginate());
            return view('admin.reports.user_logins', compact('pageTitle', 'emptyMessage', 'search', 'login_logs'));
        }
        $pageTitle = 'User Logins';
        $emptyMessage = 'No users login found.';
        $login_logs = UserLogin::where('user_id', '!=', 0)->orderBy('id','desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.user_logins', compact('pageTitle', 'emptyMessage', 'login_logs'));
    }

    public function userLoginIpHistory($ip)
    {
        $pageTitle = 'Login By - ' . $ip;
        $login_logs = UserLogin::where('user_ip',$ip)->where('user_id', '!=', 0)->orderBy('id','desc')->with('user')->paginate(getPaginate());
        $emptyMessage = 'No users login found.';
        return view('admin.reports.user_logins', compact('pageTitle', 'emptyMessage', 'login_logs','ip'));

    }

    public function merchantLoginHistory(Request $request)
    {
        if ($request->search) {
            $search = $request->search;
            $pageTitle = 'Merchant Login History Search - ' . $search;
            $emptyMessage = 'No search result found.';
            $login_logs = UserLogin::where('merchant_id', '!=', 0)->whereHas('merchant', function ($query) use ($search) {
                $query->where('username', $search);
            })->orderBy('id','desc')->with('merchant')->paginate(getPaginate());
            return view('admin.reports.merchant_logins', compact('pageTitle', 'emptyMessage', 'search', 'login_logs'));
        }
        $pageTitle = 'Merchant Login History';
        $emptyMessage = 'No merchants login found.';
        $login_logs = UserLogin::where('merchant_id', '!=', 0)->orderBy('id','desc')->with('merchant')->paginate(getPaginate());
        return view('admin.reports.merchant_logins', compact('pageTitle', 'emptyMessage', 'login_logs'));
    }

    public function merchantLoginIpHistory($ip)
    {
        $pageTitle = 'Login By - ' . $ip;
        $login_logs = UserLogin::where('user_ip',$ip)->where('merchant_id', '!=', 0)->orderBy('id','desc')->with('merchant')->paginate(getPaginate());
        $emptyMessage = 'No merchants login found.';
        return view('admin.reports.merchant_logins', compact('pageTitle', 'emptyMessage', 'login_logs','ip'));

    }

    public function userEmailHistory(){
        $pageTitle = 'User Email history';
        $logs = EmailLog::where('user_id', '!=', 0)->with('user')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No data found';
        return view('admin.reports.user_email_history', compact('pageTitle', 'emptyMessage','logs'));
    }

    public function merchantEmailHistory(){
        $pageTitle = 'Merchant Email history';
        $logs = EmailLog::where('merchant_id', '!=', 0)->with('merchant')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No data found';
        return view('admin.reports.merchant_email_history', compact('pageTitle', 'emptyMessage','logs'));
    }
}
