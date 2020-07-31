<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Session;
use App\ContactUs;


class ContactUsController  extends Controller
{

    public function __construct()
    {
    }
    
    public function contactUs() {
      return view('front.contact-us.index'); 
    }
    
    public function contactUsStore(Request $request) {  
        try{
            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'phone_number' => 'required',
                'message' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect('contact-us')
                            ->withErrors($validator)
                            ->withInput();
            }
            $contactUs = new ContactUs();
            $contactUs->name = $request->full_name;
            $contactUs->email = $request->email;
            $contactUs->subject = $request->subject;
            $contactUs->phone = $request->phone_number;
            $contactUs->message = $request->message;
            $contactUs->save();
            
            Session::flash('success', 'Your message sent successfully.');
            return Redirect::to('contact-us');
        }catch(Exception $e){
            Session::flash('error',  'Something is wrong.Please try again!');
            return Redirect::to('contact-us');
        }
    }
    
   
}
