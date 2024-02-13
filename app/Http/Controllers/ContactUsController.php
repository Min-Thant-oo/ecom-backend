<?php

namespace App\Http\Controllers;

use App\Jobs\SendContactUsEmail;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function contactus() {
        $formdata = request()->validate([
            'name'      =>  'required',
            'email'     =>  'email | required',
            'subject'   =>  'required',
            'message'   =>  'required',
        ]);

        $contactus = ContactUs::create($formdata);

        SendContactUsEmail::dispatch($contactus);
        
        return response()->json(['message' => 'Message Sent'], 200);
    }
}
