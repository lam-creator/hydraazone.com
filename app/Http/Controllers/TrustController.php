<?php

namespace App\Http\Controllers;

use App\Models\Trust;
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


class TrustController extends Controller
{

    public function Trust()
    {
        return view('back-end.pages.trust.trust');
    }

    public function TrustEditData(Request $request)
    {
        $query = Trust::find($request->id); // Model will change
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

    public function TrustInsert(Request $request)
    {

        if($request->has('delete')){
            $query = Trust::find($request->delete); // Model will change

            if ($query->image != null) {
                unlink(public_path('uploads/trust/' . $query->image)); // image directory name will change
            }

            $query->delete();

            $message = 'Trust Deleted Successfully!'; // message will change
        }else{

            $id = $request->id ?? null; // If updating, get the ID, otherwise null
            $request->validate(array(  // All column field will change
                'title' => 'required|min:3',
                'slogan' => 'required|min:3',
                'image' => $id ? 'nullable' : 'required', // Required if creating, nullable if updating
                'status' => 'required|in:active,inactive',
            ));

            $message = 'Trust Created Successfully!'; // Message will change

            if($request->has('id')){
                $query = Trust::find($request->id);  // Model name will change

                if ($request->hasFile('image')) {
                    if ($query->image != null) {
                        unlink(public_path('uploads/trust/' . $query->image)); // Directory name will change
                    }
                }

                $message = 'Trust Updated Successfully!'; // Message will change

                if(!$query){
                    return response()->json([
                    'status' => "error",
                    'message' => "Not Found, Please Try Again..."
                    ],422);
                }
            }else{
                $query = new Trust;  // Model name will change
                $query->user_id = Auth::guard('admin')->id();
            }

            if ($request->hasFile('image')) {
                // image code By using image intervention package
                $file               = $request->file('image');
                $manager            = new ImageManager(new Driver());
                $extension          = Str::lower($file->getClientOriginalExtension());
                $filename           = Str::uuid() . Str::random(5) . '.' . $extension;
                $img                = $manager->read($file);
                $img                = $img->resize(32,32);
                $destinationPath    = public_path('uploads/trust/');  // Directory name will change
                $img->save($destinationPath.$filename);
                $query->image       = $filename;


                // image code manually
                // $image_name        = Str::uuid() . Str::random(5);
                // $ext               = Str::lower($request->file('image')->getClientOriginalExtension());
                // $image_full_name   = $image_name.'.'.$ext;
                // $upload_path       = "uploads/trust/";  // Directory name will change
                // $image_url         = $upload_path.$image_full_name;
                // $success           = $request->file('image')->move($upload_path,$image_full_name);
                // $query->image      = $image_full_name;

            }

            // All request name will be changed
            $query->title = $request->title;
            $query->slogan = $request->slogan;
            $query->status = $request->status;
            $query->user_id = Auth::guard('admin')->id();
            $query->save();
        }
        return response()->json([
            'status' => "success",
            'message' => $message,
        ]);
    }

    public function TrustData(Request $request)
    {
        $Trust = Trust::with('admin:id,name')->orderBy('id', 'desc')->get(); // Model & Variable will change
        $this->i=1;

        return DataTables::of($Trust)  // Variable will change
        ->addColumn('user_id', function ($data){
				return $data->admin ? $data->admin->name:'';
			})
        ->addColumn('id', function ($data){
            return $this->i++;
        })
        ->addColumn('image', function ($data) {
                $url = asset('uploads/trust/'. $data->image);   // Directory name will change
                return '<img src="'.$url.'" style="height:80px; width:80px;" alt="Image" class="mx-auto img-fluid d-block"/>';
            })
        ->addColumn('action', function ($data){
            $htmlData='';
            $htmlData .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="btn btn-info btn-sm tableEdit"><i class="fa fa-edit"></i></a>&nbsp;';
            $htmlData .='<a href="javascript:void(0)" data-id="'.$data->id.'" class="btn btn-danger btn-sm tableDelete"><i class="fa fa-trash"></i></a>';
            return $htmlData;
        })
        ->rawColumns(['image','action'])
        ->toJson();
    }

    // End


}
