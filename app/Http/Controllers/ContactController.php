<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;

class ContactController extends Controller
{

    public function index()
    {
        return view('front-end/contact');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:80',
            'phone' => 'required|numeric|digits_between:11,14',
            'subject' => 'required|min:3|max:200',
            'message' => 'required|min:3'
        ]);
        

        $Contact = Contact::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        
        if ($Contact) {
            return response()->json([
                'status' => 'success',
                'message' => 'Message submitted successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to submit message',
            ]);
        }


    }


    public function Contact()
    {
        return view('back-end.pages.contact.contact');
    }
    
    // All contact messages
    public function ContactData()
    {

        // all query in one
        $contacts = Contact::get();

        // echo "<pre>";
        // print_r($contacts);
        // echo "</pre>";
        // exit();
        
        $this->i = 1;

        return DataTables::of($contacts)  // Variable will change

            ->addColumn('id', function ($data) {
                // return $this->i++;
                return $data->id;
            })

            ->addColumn('action', function ($data) {
                $htmlData = '';
                $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-info btn-sm tableDetails"><i class="fa fa-eye"></i></a>&nbsp;';
                $htmlData .='<a href="javascript:void(0)" data-id="'.$data->id.'" class="btn btn-danger btn-sm tableDelete"><i class="fa fa-trash"></i></a>';
                return $htmlData;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

        // Message details
        public function ContactDetails(Request $request)
        {
            $query = Contact::find($request->id);
    
            if (!$query) {
                return response()->json([
                    'status' => "error",
                    'message' => "Not Found, Please Try Again..."
                ], 404);
            }
    
            return response()->json([
                'status' => "success",
                'data' => $query,
    
            ]);
        }
        
        // Delete message
        public function ContactDelete(Request $request)
        {
    
            if($request->has('delete')){
                $query = Contact::find($request->delete); // Model will changed
                $query->delete();
    
                return response()->json([
                    'status' => "success",
                    'message' => "Message Deleted Successfully!",
                ]);
                
            } else {
                return response()->json([
                    'status' => "error",
                    'message' => "Not Found, Please Try Again..."
                ], 404);
            }
            
        }


        
    // End
 
}