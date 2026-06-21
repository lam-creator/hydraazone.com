<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Yajra\Datatables\Datatables;

class AdminController extends Controller
{

    public function Admin()
    {
        return view('back-end.pages.admin.admins');
    }

    public function AdminEditData(Request $request)
    {
        $query = Admin::find($request->id);
        if(!$query){
            return response()->json([
            'status' => "error",
            'message' => "Not Found, Please Try Again..."
            ],422);
        }

        return response()->json([
        'status' => "success",
        'data' => $query,

        ]);

    }

    public function AdminInsert(Request $request)
    {

        if($request->has('delete')){
            $query = Admin::find($request->delete);

            if ($query->image != null) {
                unlink(public_path('uploads/admin/' . $query->image));
            }

            $query->delete();

            $message = 'Admin Deleted Successfully!';
        }else{

            $request->validate(array(
                'name'    =>  'required',
                'username'    =>  'required',
                'email'    =>  'required',
                'password'    =>  'required',
                'status'   => 'required|in:active,inactive',
            ));

            $message = 'Admin Create Successfully!';

            if($request->has('id')){
                $query = Admin::find($request->id);

                if ($request->hasFile('image')) {
                    if ($query->image != null) {
                        unlink(public_path('uploads/admin/' . $query->image));
                    }
                }

                $message = 'Admin Updated Successfully!';

                if(!$query){
                    return response()->json([
                    'status' => "error",
                    'message' => "Not Found, Please Try Again..."
                    ],422);
                }
            }else{
                $query = new Admin;
                $query->user_id = Auth::guard('admin')->id();
            }

            if ($request->hasFile('image')) {
                // image code By using image intervention package
                $file               = $request->file('image');
                $manager            = new ImageManager(new Driver());
                $extension          = Str::lower($file->getClientOriginalExtension());
                $filename           = Str::uuid() . Str::random(5) . '.' . $extension;
                $img                = $manager->read($file);
                $img                = $img->resize(128,128);
                $destinationPath    = public_path('uploads/admin/');
                $img->save($destinationPath.$filename);
                $query->image       = $filename;


                // image code manually
                // $image_name        = Str::uuid() . Str::random(5);
                // $ext               = Str::lower($request->file('image')->getClientOriginalExtension());
                // $image_full_name   = $image_name.'.'.$ext;
                // $upload_path       = "uploads/admin/";
                // $image_url         = $upload_path.$image_full_name;
                // $success           = $request->file('image')->move($upload_path,$image_full_name);
                // $query->image      = $image_full_name;

            }

            $query->name = $request->name;
            $query->username = $request->username;
            $query->email = $request->email;
            $query->password = $request->password;
            $query->status = $request->status;
            $query->user_id = Auth::guard('admin')->id();
            $query->save();
        }
        return response()->json([
            'status' => "success",
            'message' => $message,
        ]);
    }

    public function AdminData(Request $request)
    {
        $Admin = Admin::with('admin:id,name')->orderBy('id', 'desc')->get();
        $this->i=1;

        return DataTables::of($Admin)
        ->addColumn('user_id', function ($data){
				return $data->admin ? $data->admin->name:'';
			})
        ->addColumn('id', function ($data){
            return $this->i++;
        })
        // format date
            ->editColumn('created_at', function ($data) {
                return \Carbon\Carbon::parse($data->created_at)->format('Y-m-d');
            })
            
        ->addColumn('action', function ($data){
            $htmlData='';
            $htmlData .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="btn btn-info btn-sm tableEdit"><i class="fa fa-edit"></i></a>&nbsp;';
            $htmlData .='<a href="javascript:void(0)" data-id="'.$data->id.'" class="btn btn-danger btn-sm tableDelete"><i class="fa fa-trash"></i></a>';
            return $htmlData;
        })
        ->rawColumns(['action'])
        ->toJson();
    }

    // End
}
