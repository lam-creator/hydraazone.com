<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Yajra\Datatables\Datatables;

class CityController extends Controller
{

    public function City()
    {
        return view('back-end.pages.location.city');
    }

    public function CityEditData(Request $request)
    {
        $query = City::find($request->id); // Model will changed
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

    public function CityInsert(Request $request)
    {

        if($request->has('delete')){
            $query = City::find($request->delete); // Model will changed

            $query->delete();

            $message = 'City Deleted Successfully!';  // message will changed
        }else{

            $id = $request->id ?? null; // If updating, get the ID, otherwise null
            $request->validate(array(  // All column field will changed
                'name' => 'required|min:2|unique:cities,name,' . $id,  // Unique table name & unique column name will change
                'status' => 'required|in:active,inactive',
            ));

            $message = 'City Created Successfully!';  // message will changed

            if($request->has('id')){
                $query = City::find($request->id);  // Model will changed

                $message = 'City Updated Successfully!'; // message will changed

                if(!$query){
                    return response()->json([
                    'status' => "error",
                    'message' => "Not Found, Please Try Again..."
                    ],422);
                }
            }else{
                $query = new City;  // Model will changed
                $query->user_id = Auth::guard('admin')->id();
            }

            // All request name will be changed
            $query->name = Str::title($request->name);
            $query->city_slug = Str::slug($request->name , '-');
            $query->status = $request->status;
            $query->user_id = Auth::guard('admin')->id();
            $query->save();
        }
        return response()->json([
            'status' => "success",
            'message' => $message,
        ]);
    }

    public function CityData(Request $request)
    {

        $City = City::with('admin:id,name')->orderBy('id', 'desc')->get(); // Model & Variable will change
        $this->i=1;

        return DataTables::of($City)  // Variable will change
        ->addColumn('user_id', function ($data){
				return $data->admin ? $data->admin->name:'';
			})
        ->addColumn('id', function ($data){
            return $this->i++;
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
