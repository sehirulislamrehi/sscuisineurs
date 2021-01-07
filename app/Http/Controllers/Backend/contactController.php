<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use App\Mail\ReplyMail;
use Illuminate\Http\Request;
use App\Models\contact;
use App\Models\ContactFormModel;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class contactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = contact::orderBy('id','desc')->get();
        return view('backend.pages.contact.manage',compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'info' => 'required',
        ]);
        $contact = new contact();
        $contact->address=$request->address;
        $contact->phone=$request->phone;
        $contact->email=$request->email;
        $contact->website=$request->website;
        $contact->facebook=$request->facebook;
        $contact->twitter=$request->twitter;
        $contact->instagram	=$request->instagram;
        $contact->youtube	=$request->youtube;
        $contact->info	=$request->info; 

        $contact->save();
        Toastr::success('contact Created');

        return redirect()->route('contactShow');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(contact $contact,Request $request)
    {
        $request->validate([
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'info' => 'required',
        ]);
        $contact->address=$request->address;
        $contact->phone=$request->phone;
        $contact->email=$request->email;
        $contact->website=$request->website;
        $contact->facebook=$request->facebook;
        $contact->twitter=$request->twitter;
        $contact->instagram	=$request->instagram;
        $contact->youtube	=$request->youtube;
        $contact->info	=$request->info; 

        $contact->save();
        Toastr::success('Contact Updated');

        return redirect()->route('contactShow');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(contact $contact)
    {
        $contact->delete();
        Toastr::error('contact Deleted');
        return redirect()->route('contactShow');
    }

    public function all_message(){
        $messages = ContactFormModel::all();
        return view('backend.pages.contact.message',compact('messages'));
    }

    public function delete_message(Request $request){
        
        $request->validate([
            'delete_message' => 'required',
        ]);

        foreach( $request->delete_message as $message ):
            $messages = ContactFormModel::find($message);
            $messages->delete();
        endforeach;

        Toastr::error('Message Deleted');
        return back();

    }
    
    public function reply_message(Request $request, $id){
        $request->validate([
            'email' => 'required',
            'message' => 'required'
        ]);
        
        $message = ContactFormModel::find($id);
        $message->is_replied = true;
        $message->reply_message = $request->message;
        
        if($message->save()){
            Mail::to($request->email)->send(new ReplyMail($message,'Reply Mail From SSCuisineurs'));
            Toastr::success('Reply Send');
            return back();
        }
        
        
    }
}
