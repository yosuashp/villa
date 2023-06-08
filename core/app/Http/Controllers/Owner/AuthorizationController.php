<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizationController extends Controller
{
    public function checkValidCode($owner, $code, $add_min = 10000)
    {
        if (!$code) return false;
        if (!$owner->ver_code_send_at) return false;
        if ($owner->ver_code_send_at->addMinutes($add_min) < Carbon::now()) return false;
        if ($owner->ver_code !== $code) return false;
        return true;
    }


    public function authorizeForm()
    {
        if (auth()->guard('owner')->check()) {
            $owner = auth()->guard('owner')->user();
            if (!$owner->status) {
                Auth::guard('owner')->logout();
            }elseif (!$owner->ev) {
                if (!$this->checkValidCode($owner, $owner->ver_code)) {
                    $owner->ver_code = verificationCode(6);
                    $owner->ver_code_send_at = Carbon::now();
                    $owner->save();
                    sendEmail($owner, 'EVER_CODE', [
                        'code' => $owner->ver_code
                    ]);
                }
                $pageTitle = 'Email verification form';
                return view('owner.auth.authorization.email', compact('owner', 'pageTitle'));
            }elseif (!$owner->sv) {
                if (!$this->checkValidCode($owner, $owner->ver_code)) {
                    $owner->ver_code = verificationCode(6);
                    $owner->ver_code_send_at = Carbon::now();
                    $owner->save();
                    sendSms($owner, 'SVER_CODE', [
                        'code' => $owner->ver_code
                    ]);
                }
                $pageTitle = 'SMS verification form';
                return view('owner.auth.authorization.sms', compact('owner', 'pageTitle'));
            }elseif (!$owner->tv) {
                $pageTitle = 'Google Authenticator';
                return view('owner.auth.authorization.2fa', compact('owner', 'pageTitle'));
            }else{
                return redirect()->route('owner.dashboard');
            }

        }

        return redirect()->route('owner.login');
    }

    public function sendVerifyCode(Request $request)
    {
        $owner = Auth::guard('owner')->user();


        if ($this->checkValidCode($owner, $owner->ver_code, 2)) {
            $target_time = $owner->ver_code_send_at->addMinutes(2)->timestamp;
            $delay = $target_time - time();
            throw ValidationException::withMessages(['resend' => 'Please Try after ' . $delay . ' Seconds']);
        }
        if (!$this->checkValidCode($owner, $owner->ver_code)) {
            $owner->ver_code = verificationCode(6);
            $owner->ver_code_send_at = Carbon::now();
            $owner->save();
        } else {
            $owner->ver_code = $owner->ver_code;
            $owner->ver_code_send_at = Carbon::now();
            $owner->save();
        }



        if ($request->type === 'email') {
            sendEmail($owner, 'EVER_CODE',[
                'code' => $owner->ver_code
            ]);

            $notify[] = ['success', 'Email verification code sent successfully'];
            return back()->withNotify($notify);
        } elseif ($request->type === 'phone') {
            sendSms($owner, 'SVER_CODE', [
                'code' => $owner->ver_code
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
        $owner = Auth::guard('owner')->user();

        if ($this->checkValidCode($owner, $email_verified_code)) {
            $owner->ev = 1;
            $owner->ver_code = null;
            $owner->ver_code_send_at = null;
            $owner->save();
            return redirect()->route('owner.dashboard');
        }
        throw ValidationException::withMessages(['email_verified_code' => 'Verification code didn\'t match!']);
    }

    public function smsVerification(Request $request)
    {
        $request->validate([
            'sms_verified_code' => 'required',
        ]);


        $sms_verified_code =  str_replace(' ','',$request->sms_verified_code);

        $owner = Auth::guard('owner')->user();
        if ($this->checkValidCode($owner, $sms_verified_code)) {
            $owner->sv = 1;
            $owner->ver_code = null;
            $owner->ver_code_send_at = null;
            $owner->save();
            return redirect()->route('owner.dashboard');
        }
        throw ValidationException::withMessages(['sms_verified_code' => 'Verification code didn\'t match!']);
    }
    public function g2faVerification(Request $request)
    {
        $owner = auth()->guard('owner')->user();
        $request->validate([
            'code' => 'required',
        ]);
        $code = str_replace(' ','',$request->code);
        $response = verifyG2fa($owner,$code);
        if ($response) {
            $notify[] = ['success','Verification successful'];
        }else{
            $notify[] = ['error','Wrong verification code'];
        }
        return back()->withNotify($notify);
    }
}
