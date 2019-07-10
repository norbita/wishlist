<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Wishlist;
use Auth;

class SendEmailController extends Controller
{
    //
    function index() {
        return view('sendemail.send_email');
    }

    function send(Request $request)
    {
        if (!Auth::guest()) {
            $this->validate($request, [
                'friend_name'  => 'required',
                'friend_email' => 'required|email',
                'message' => 'required'
            ]);

            $wishlist = Wishlist::where('user_id', '=', Auth::user()->id)->get();
            $contador_wishlist = count($wishlist);
            if ($contador_wishlist > 0) {
                
                $data = array(
                    'friend_name'=>$request->friend_name,
                    'friend_email'=>$request->friend_email,
                    'message'=>$request->message,
                    'wishlist'=>$wishlist
                    
                );           

                Mail::to($request->friend_email)->send(new SendMail($data));
                return back()->with('success', 'Your wishlist was emailed');
            } else {
                return back()->with('error', 'Your wishlist is empty, please, select some products');
            }
        } else {
            return back()->with('error', 'You are not logged in');
        }
    }
}
