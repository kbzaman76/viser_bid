<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Lib\GoogleAuthenticator;
use App\Models\AdminNotification;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\WithdrawMethod;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class MerchantController extends Controller
{
    public function dashboard()
    {
        $pageTitle = 'Dashboard';
        $user = auth()->guard('merchant')->user();
        $widget['balance'] = $user->balance; 
        $widget['total_products'] = $user->products()->count();
        $widget['total_bids'] = $user->bids()->count();
        $widget['total_bid_amounts'] = $user->bids()->sum('amount');
        $emptyMessage = 'No transaction found';
        $transactions = Transaction::where('merchant_id', auth()->guard('merchant')->id())->latest()->limit(10)->get();
        $emptyMessage = 'No transaction found'; 

        return view('merchant.dashboard', compact('pageTitle', 'emptyMessage', 'widget', 'transactions'));
    }

    public function profile()
    {
        $pageTitle = 'Profile';
        $merchant = Auth::guard('merchant')->user();
        return view('merchant.profile', compact('pageTitle', 'merchant'));
    }

    public function profileUpdate(Request $request)
    {
        // return $request;
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => 'sometimes|required|max:80',
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|integer|min:1',
            'city' => 'sometimes|required|max:50',
            'social_links' => 'nullable|array',
            'image' => ['nullable','image',new FileTypeValidate(['jpg','jpeg','png'])],
            'cover_image' => ['nullable','image',new FileTypeValidate(['jpg','jpeg','png'])]
        ],[
            'firstname.required'=>'First name field is required',
            'lastname.required'=>'Last name field is required'
        ]);
        $merchant = Auth::guard('merchant')->user();

        $merchant->firstname= $request->firstname;
        $merchant->lastname= $request->lastname;
        $merchant->social_links = $request->social_links ?? null;

        $user = Auth::guard('merchant')->user();

        if ($request->hasFile('image')) {
            try {
                $old = $user->image ?: null;
                $user->image = uploadImage($request->image, imagePath()['profile']['merchant']['path'], imagePath()['profile']['merchant']['size'], $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('cover_image')) {
            try {
                $old = $user->cover_image ?: null;
                $user->cover_image = uploadImage($request->cover_image, imagePath()['profile']['merchant_cover']['path'], imagePath()['profile']['merchant_cover']['size'], $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$merchant->address->country,
            'city' => $request->city,
        ];

        $merchant->fill($in)->save();

        $notify[] = ['success', 'Profile updated successfully.'];
        return back()->withNotify($notify);

    }

    public function changePassword()
    {
        $pageTitle = 'Change password';
        $merchant = Auth::guard('merchant')->user();
        return view('merchant.password', compact('pageTitle', 'merchant'));
    }

    public function submitPassword(Request $request)
    {
        $password_validation = Password::min(6);
        $general = GeneralSetting::first();
        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required','confirmed',$password_validation]
        ]);
        

        try {
            $merchant = auth()->guard('merchant')->user();
            if (Hash::check($request->current_password, $merchant->password)) {
                $password = Hash::make($request->password);
                $merchant->password = $password;
                $merchant->save();
                $notify[] = ['success', 'Password changes successfully.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'The password doesn\'t match!'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    public function show2faForm()
    {
        $general = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $merchant = auth()->guard('merchant')->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($merchant->username . '@' . $general->sitename, $secret);
        $pageTitle = 'Two Factor';
        return view('merchant.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $merchant = auth()->guard('merchant')->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($merchant,$request->code,$request->key);
        if ($response) {
            $merchant->tsc = $request->key;
            $merchant->ts = 1;
            $merchant->save();
            $merchantAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($merchant, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$merchantAgent['ip'],
                'time' => @$merchantAgent['time']
            ], 'merchant');
            $notify[] = ['success', 'Google authenticator enabled successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }


    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $merchant = auth()->guard('merchant')->user();
        $response = verifyG2fa($merchant,$request->code);
        if ($response) {
            $merchant->tsc = null;
            $merchant->ts = 0;
            $merchant->save();
            $merchantAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($merchant, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$merchantAgent['ip'],
                'time' => @$merchantAgent['time']
            ], 'merchant');
            $notify[] = ['success', 'Two factor authenticator disable successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    /*
     * Withdraw Operation
     */

    public function withdrawMoney()
    {
        $withdrawMethod = WithdrawMethod::where('status',1)->get();
        $pageTitle = 'Withdraw Money';
        return view('merchant.withdraw.methods', compact('pageTitle','withdrawMethod'));
    }

    public function withdrawStore(Request $request)
    {
        $this->validate($request, [
            'method_code' => 'required',
            'amount' => 'required|numeric'
        ]);
        $method = WithdrawMethod::where('id', $request->method_code)->where('status', 1)->firstOrFail();
        $merchant = Auth::guard('merchant')->user();
        if ($request->amount < $method->min_limit) {
            $notify[] = ['error', 'Your requested amount is smaller than minimum amount.'];
            return back()->withNotify($notify);
        }
        if ($request->amount > $method->max_limit) {
            $notify[] = ['error', 'Your requested amount is larger than maximum amount.'];
            return back()->withNotify($notify);
        }

        if ($request->amount > $merchant->balance) {
            $notify[] = ['error', 'You do not have sufficient balance for withdraw.'];
            return back()->withNotify($notify);
        }


        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;
        $finalAmount = $afterCharge * $method->rate;

        $withdraw = new Withdrawal();
        $withdraw->method_id = $method->id; // wallet method ID
        $withdraw->merchant_id = $merchant->id;
        $withdraw->amount = $request->amount;
        $withdraw->currency = $method->currency;
        $withdraw->rate = $method->rate;
        $withdraw->charge = $charge;
        $withdraw->final_amount = $finalAmount;
        $withdraw->after_charge = $afterCharge;
        $withdraw->trx = getTrx();
        $withdraw->save();
        session()->put('wtrx', $withdraw->trx);
        return redirect()->route('merchant.withdraw.preview');
    }

    public function withdrawPreview()
    {
        $withdraw = Withdrawal::with('method','merchant')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id','desc')->firstOrFail();
        $pageTitle = 'Withdraw Preview';
        return view('merchant.withdraw.preview', compact('pageTitle','withdraw'));
    }


    public function withdrawSubmit(Request $request)
    {
        $general = GeneralSetting::first();
        $withdraw = Withdrawal::with('method','merchant')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id','desc')->firstOrFail();

        $rules = [];
        $inputField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($withdraw->method->user_data as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], new FileTypeValidate(['jpg','jpeg','png']));
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }

        $this->validate($request, $rules);
        
        $merchant = Auth::guard('merchant')->user();
        if ($merchant->ts) {
            $response = verifyG2fa($merchant,$request->authenticator_code);
            if (!$response) {
                $notify[] = ['error', 'Wrong verification code'];
                return back()->withNotify($notify);
            }   
        }


        if ($withdraw->amount > $merchant->balance) {
            $notify[] = ['error', 'Your request amount is larger then your current balance.'];
            return back()->withNotify($notify);
        }

        $directory = date("Y")."/".date("m")."/".date("d");
        $path = imagePath()['verify']['withdraw']['path'].'/'.$directory;
        $collection = collect($request);
        $reqField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($collection as $k => $v) {
                foreach ($withdraw->method->user_data as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory.'/'.uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $request[$inKey]];
                                    return back()->withNotify($notify)->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $withdraw['withdraw_information'] = $reqField;
        } else {
            $withdraw['withdraw_information'] = null;
        }


        $withdraw->status = 2;
        $withdraw->save();
        $merchant->balance  -=  $withdraw->amount;
        $merchant->save();

        $transaction = new Transaction();
        $transaction->merchant_id = $withdraw->merchant_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = $merchant->balance;
        $transaction->charge = $withdraw->charge;
        $transaction->trx_type = '-';
        $transaction->details = showAmount($withdraw->final_amount) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name;
        $transaction->trx =  $withdraw->trx;
        $transaction->save();

        $adminNotification = new AdminNotification();
        $adminNotification->merchant_id = $merchant->id;
        $adminNotification->title = 'New withdraw request from '.$merchant->username;
        $adminNotification->click_url = urlPath('admin.withdraw.details',$withdraw->id);
        $adminNotification->save();

        notify($merchant, 'WITHDRAW_REQUEST', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount),
            'amount' => showAmount($withdraw->amount),
            'charge' => showAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => showAmount($merchant->balance),
            'delay' => $withdraw->method->delay
        ], 'merchant');

        $notify[] = ['success', 'Withdraw request sent successfully'];
        return redirect()->route('merchant.withdraw.history')->withNotify($notify);
    }

    public function withdrawLog()
    {
        $pageTitle = "Withdraw Log";
        $emptyMessage = "No withdraw history found";
        $withdraws = Withdrawal::where('merchant_id', Auth::guard('merchant')->id())->where('status', '!=', 0)->with('method')->orderBy('id','desc')->paginate(getPaginate());
        $data['emptyMessage'] = "No Data Found!";
        return view('merchant.withdraw.log', compact('pageTitle', 'emptyMessage', 'withdraws'));
    }

    public function transactions(){
        $pageTitle    = 'All Transactions';
        $emptyMessage = 'No transactions found';
        $transactions = Transaction::where('merchant_id', auth()->guard('merchant')->id())->latest()->paginate(getPaginate());

        return view('merchant.transactions', compact('pageTitle', 'emptyMessage', 'transactions'));
    }
}
