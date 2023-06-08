<?php

namespace App\Http\Controllers;

use App\Lib\GoogleAuthenticator;
use App\Models\GeneralSetting;
use App\Models\Property;
use App\Models\BookedProperty;
use App\Models\Review;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function home()
    {
        $pageTitle = 'Dashboard';
        $emptyMessage = 'No booking history found';
        $widget['total_tickets'] = SupportTicket::where('user_id', Auth::id())->count();
        $widget['total_booked'] = BookedProperty::where('user_id', Auth::id())->where('status', 1)->count();
        $widget['total_pending_review'] =  Property::with('bookedProperties')
            ->whereHas('bookedProperties', function($bookedProperty){
                $bookedProperty->where('user_id', Auth::id())->where('status', 1);
            })->whereDoesntHave('review')->count();
        $propertyBookings = BookedProperty::with('property', 'bookedRooms.room')->where('user_id', Auth::id())->orderBy('id', 'DESC')->limit(6)->get();

        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'emptyMessage', 'propertyBookings', 'widget'));
    }

    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = Auth::user();
        return view($this->activeTemplate. 'user.profile_setting', compact('pageTitle','user'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => 'sometimes|required|max:80',
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
        ],[
            'firstname.required'=>'First name field is required',
            'lastname.required'=>'Last name field is required'
        ]);

        $user = Auth::user();

        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
        ];

        $user->fill($in)->save();
        $notify[] = ['success', 'Profile updated successfully.'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
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
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
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

    public function propertyHistory()
    {
        $pageTitle = 'Booking History';
        $emptyMessage = 'No booking history found';
        $propertyBookings = BookedProperty::with('property', 'bookedRooms.room')->where('user_id', Auth::id())->where('status', 1)->latest()->paginate(getPaginate());

        return view($this->activeTemplate.'user.booking_history', compact('pageTitle', 'emptyMessage', 'propertyBookings'));

    }

    public function reviews()
    {
        $pageTitle = 'Reviews';
        $emptyMessage = 'No property found';

        $pendingReviewProperties = Property::with(['location', 'review','bookedProperties'=>function($bookedProperty){
            $bookedProperty->select('id');
        }
        ])->select('id', 'name', 'location_id', 'phone')->whereHas('bookedProperties', function($bookedProperty){
            $bookedProperty->where('user_id', Auth::id())->where('status', 1);
        })->whereDoesntHave('review')->limit(10)->get();

        $reviewedProperties = Property::with(['location', 'review'])->select('id', 'name', 'location_id', 'phone')->whereHas('review', function($reviewed){
            $reviewed->where('user_id', Auth::id());
        })->limit(10)->get();

        return view($this->activeTemplate.'user.review', compact('pageTitle', 'emptyMessage', 'pendingReviewProperties', 'reviewedProperties'));
    }

    public function saveReview(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|between:1,5'
        ]);
        $propertyId = $request->property_id;

        BookedProperty::where('property_id', $propertyId)->where('user_id', Auth::id())->firstOrFail();

        $review = Review::where('user_id', Auth::id())->where('property_id', $propertyId)->first();
        $property = Property::find($propertyId);
        if (!$review) {
            $review = new Review();
            $property->total_rating += $request->rating;
            $property->review += 1;
            
            $notify[] = ['success', 'Review given successfully'];
        }else{
            $property->total_rating = $property->total_rating - $review->rating + $request->rating;
            $notify[] = ['success', 'Review updated successfully'];
        }
        $property->rating = $property->total_rating / $property->review;
        $property->save();

        $review->rating = $request->rating;
        $review->description = $request->description;
        $review->user_id = Auth::id();
        $review->property_id = $propertyId;
        $review->save();

        return back()->withNotify($notify);

    }

   public function pendingReview()
   {
        $pageTitle = 'Pending Review';
        $emptyMessage = 'No pending review found';
        $pendingReviewProperties = Property::with(['location', 'review','bookedProperties'=>function($bookedProperty){
                $bookedProperty->select('id');
            }
            ])->select('id', 'name', 'location_id', 'phone')->whereHas('bookedProperties', function($bookedProperty){
                $bookedProperty->where('user_id', Auth::id())->where('status', 1);
        })->whereDoesntHave('review')->paginate(getPaginate());

        return view($this->activeTemplate.'user.pending_review', compact('pageTitle', 'emptyMessage', 'pendingReviewProperties'));
   }

    public function completedReview()
    {
        $pageTitle = 'Completed Review';
        $emptyMessage = 'No completed review found';
        $reviewedProperties = Property::with(['location', 'review'])->select('id', 'name', 'location_id', 'phone')->whereHas('review', function($reviewed){
            $reviewed->where('user_id', Auth::id());
        })->paginate(getPaginate());

        return view($this->activeTemplate.'user.completed_review', compact('pageTitle', 'emptyMessage', 'reviewedProperties'));
    }

    public function show2faForm()
    {
        $general = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->sitename, $secret);
        $pageTitle = 'Two Factor';
        return view($this->activeTemplate.'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user,$request->code,$request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
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

        $user = auth()->user();
        $response = verifyG2fa($user,$request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Two factor authenticator disable successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

}
