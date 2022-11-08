<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    //admin contact list
    public function contactList(){
        $contact = Contact::orderBy('created_at','desc')->paginate(5);
        // dd($contact->toArray());
        return view('admin.contact.contactList',compact('contact'));
    }

    // user contact us
    public function userContact(){
        return view('user.contact.contact');
    }

    // user contact us
    public function userContactList(){
        $contact = Contact::where('user_id',Auth::user()->id)
                    ->orderBy('created_at','desc')
                    ->paginate(4);
        return view('user.contact.contactList',compact('contact'));
    }


    // user send contact
    public function sendContact(Request $request){
        $data = $this->requestContactInfo($request);
        // dd($data['user_id']);
        Contact::create($data);
        return redirect()->route('user#userContactList');
    }


    // request product info
    private function requestContactInfo($request){
        return [
            'user_id'=>Auth::user()->id ,
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message'=> $request->message,
        ];
    }
}
