<?php

namespace App\Http\Controllers;

use App\Models\Slider;
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

class SliderController extends Controller
{

    public function Slider()
    {
        return view('back-end.pages.slider.slider');
    }

    public function SliderEditData(Request $request)
    {
        $query = Slider::find($request->id); // Model will change
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

    public function SliderInsert(Request $request)
    {

        if($request->has('delete')){
            $query = Slider::find($request->delete); // Model will change

            if ($query->image != null) {
                unlink(public_path('uploads/slider/' . $query->image)); // image directory name will change
            }

            $query->delete();

            $message = 'Slider Deleted Successfully!'; // message will change
        }else{

            $id = $request->id ?? null; // If updating, get the ID, otherwise null
            $request->validate(array(  // All column field will change
                'title' => 'required|min:3',
                'slogan' => 'required|min:3',
                'button_text' => 'required|min:3',
                'link' => 'required|min:1',
                'image' => $id ? 'nullable' : 'required', // Required if creating, nullable if updating
                'status' => 'required|in:active,inactive',
            ));

            $message = 'Slider Create Successfully!'; // Message will change

            if($request->has('id')){
                $query = Slider::find($request->id);  // Model name will change

                if ($request->hasFile('image')) {
                    if ($query->image != null) {
                        unlink(public_path('uploads/slider/' . $query->image)); // Directory name will change
                    }
                }

                $message = 'Slider Updated Successfully!'; // Message will change

                if(!$query){
                    return response()->json([
                    'status' => "error",
                    'message' => "Not Found, Please Try Again..."
                    ],422);
                }
            }else{
                $query = new Slider;  // Model name will change
                $query->user_id = Auth::guard('admin')->id();
            }

            if ($request->hasFile('image')) {
                // image code By using image intervention package
                $file               = $request->file('image');
                $manager            = new ImageManager(new Driver());
                $extension          = Str::lower($file->getClientOriginalExtension());
                $filename           = Str::uuid() . Str::random(5) . '.' . $extension;
                $img                = $manager->read($file);
                $img                = $img->resize(650,445);
                $destinationPath    = public_path('uploads/slider/');  // Directory name will change
                $img->save($destinationPath.$filename);
                $query->image       = $filename;


                // image code manually
                // $image_name        = Str::uuid() . Str::random(5);
                // $ext               = Str::lower($request->file('image')->getClientOriginalExtension());
                // $image_full_name   = $image_name.'.'.$ext;
                // $upload_path       = "uploads/slider/";  // Directory name will change
                // $image_url         = $upload_path.$image_full_name;
                // $success           = $request->file('image')->move($upload_path,$image_full_name);
                // $query->image      = $image_full_name;

            }

            // All request name will be changed
            $query->title = $request->title;
            $query->slogan = $request->slogan;
            $query->button_text = $request->button_text;
            $query->link = $request->link;
            $query->status = $request->status;
            $query->user_id = Auth::guard('admin')->id();
            $query->save();
        }
        return response()->json([
            'status' => "success",
            'message' => $message,
        ]);
    }

    public function SliderData(Request $request)
    {
        $Slider = Slider::with('admin:id,name')->orderBy('id', 'desc')->get(); // Model & Variable will change
        $this->i=1;

        return DataTables::of($Slider)  // Variable will change
        ->addColumn('user_id', function ($data){
				return $data->admin ? $data->admin->name:'';
			})
        ->addColumn('id', function ($data){
            return $this->i++;
        })
        ->addColumn('image', function ($data) {
                $url = asset('uploads/slider/'. $data->image);   // Directory name will change
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
