<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Contact;
use Mail;
class ContactController extends Controller
{
    public function contactForm()
    {
        return view('contactForm');
    }
    public function storeContactForm(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'phone' => 'required|digits:10|numeric',
            'subject' => 'required',
            'message' => 'required',
        ]);
        $input = $request->all();
        Contact::create($input);
        //  Send mail to admin
        \Mail::send('contactMail', array(
            'fname' => $input['fname'],
            'lname' => $input['lname'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'subject' => $input['subject'],
            'message' => $input['message'],
        ), function($message) use ($request){
            $message->from($request->email);
            $message->to('krys@longleafagency.com');
        });
        return back()->with(['success' => 'Contact Form Submit Successfully']);
    }
}
