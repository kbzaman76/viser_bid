<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizationController extends Controller
{
    public function checkValidCode($merchant, $code, $add_min = 10000)
    {
        if (!$code) return false;
        if (!$merchant->ver_code_send_at) return false;
        if ($merchant->ver_code_send_at->addMinutes($add_min) < Carbon::now()) return false;
        if ($merchant->ver_code !== $code) return false;
        return true;
    }


    public function authorizeForm()
    {
        if (auth()->guard('merchant')->check()) {
            $merchant = auth()->guard('merchant')->user();
            if (!$merchant->status) {
                Auth::guard('merchant')->logout();
            }elseif (!$merchant->ev) {
                if (!$this->checkValidCode($merchant, $merchant->ver_code)) {
                    $merchant->ver_code = verificationCode(6);
                    $merchant->ver_code_send_at = Carbon::now();
                    $merchant->save();
                    sendEmail($merchant, 'EVER_CODE', [
                        'code' => $merchant->ver_code
                    ]);
                }
                $pageTitle = 'Email verification form';
                return view('merchant.auth.authorization.email', compact('merchant', 'pageTitle'));
            }elseif (!$merchant->sv) {
                if (!$this->checkValidCode($merchant, $merchant->ver_code)) {
                    $merchant->ver_code = verificationCode(6);
                    $merchant->ver_code_send_at = Carbon::now();
                    $merchant->save();
                    sendSms($merchant, 'SVER_CODE', [
                        'code' => $merchant->ver_code
                    ]);
                }
                $pageTitle = 'SMS verification form';
                return view('merchant.auth.authorization.sms', compact('merchant', 'pageTitle'));
            }elseif (!$merchant->tv) {
                $pageTitle = 'Google Authenticator';
                return view('merchant.auth.authorization.2fa', compact('merchant', 'pageTitle'));
            }else{
                return redirect()->route('merchant.dashboard');
            }

        }

        return redirect()->route('merchant.login');
    }

    public function sendVerifyCode(Request $request)
    {
        $merchant = Auth::guard('merchant')->user();


        if ($this->checkValidCode($merchant, $merchant->ver_code, 2)) {
            $target_time = $merchant->ver_code_send_at->addMinutes(2)->timestamp;
            $delay = $target_time - time();
            throw ValidationException::withMessages(['resend' => 'Please Try after ' . $delay . ' Seconds']);
        }
        if (!$this->checkValidCode($merchant, $merchant->ver_code)) {
            $merchant->ver_code = verificationCode(6);
            $merchant->ver_code_send_at = Carbon::now();
            $merchant->save();
        } else {
            $merchant->ver_code = $merchant->ver_code;
            $merchant->ver_code_send_at = Carbon::now();
            $merchant->save();
        }



        if ($request->type === 'email') {
            sendEmail($merchant, 'EVER_CODE',[
                'code' => $merchant->ver_code
            ]);

            $notify[] = ['success', 'Email verification code sent successfully'];
            return back()->withNotify($notify);
        } elseif ($request->type === 'phone') {
            sendSms($merchant, 'SVER_CODE', [
                'code' => $merchant->ver_code
            ]);
            $notify[] = ['success', 'SMS verification code sent successfully'];
            return back()->withNotify($notify);
        } else {
            throw ValidationException::withMessages(['resend' => 'Sending Failed']);
        }
    }

    public function emailVerification(Request $request)
    {
        $request->validate([
            'email_verified_code'=>'required'
        ]);


        $email_verified_code = str_replace(' ','',$request->email_verified_code);
        $merchant = Auth::guard('merchant')->user();

        if ($this->checkValidCode($merchant, $email_verified_code)) {
            $merchant->ev = 1;
            $merchant->ver_code = null;
            $merchant->ver_code_send_at = null;
            $merchant->save();
            return redirect()->route('merchant.dashboard');
        }
        throw ValidationException::withMessages(['email_verified_code' => 'Verification code didn\'t match!']);
    }

    public function smsVerification(Request $request)
    {
        $request->validate([
            'sms_verified_code' => 'required',
        ]);


        $sms_verified_code =  str_replace(' ','',$request->sms_verified_code);

        $merchant = Auth::guard('merchant')->user();
        if ($this->checkValidCode($merchant, $sms_verified_code)) {
            $merchant->sv = 1;
            $merchant->ver_code = null;
            $merchant->ver_code_send_at = null;
            $merchant->save();
            return redirect()->route('merchant.dashboard');
        }
        throw ValidationException::withMessages(['sms_verified_code' => 'Verification code didn\'t match!']);
    }
    public function g2faVerification(Request $request)
    {
        $merchant = auth()->guard('merchant')->user();
        $request->validate([
            'code' => 'required',
        ]);
        $code = str_replace(' ','',$request->code);
        $response = verifyG2fa($merchant,$code);
        if ($response) {
            $notify[] = ['success','Verification successful'];
        }else{
            $notify[] = ['error','Wrong verification code'];
        }
        return back()->withNotify($notify);
    }
}
