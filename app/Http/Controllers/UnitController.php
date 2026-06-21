<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Yajra\Datatables\Datatables;

class UnitController extends Controller
{

    public function Unit()
    {
        return view('back-end.pages.product.unit');
    }

    public function UnitEditData(Request $request)
    {
        $query = Unit::find($request->id); // Model will be changed
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

    public function UnitInsert(Request $request)
    {

        if($request->has('delete')){
            $query = Unit::find($request->delete); // Model will be changed

            $query->delete();

            $message = 'Unit Deleted Successfully!';  // message will be changed
        }else{

            $id = $request->id ?? null; // If updating, get the ID, otherwise null
            $request->validate(array(  // All column field will be changed
                'name' => 'required|min:1|unique:units,name,' . $id,  // Unique table name & unique column name will change
                'status' => 'required|in:active,inactive',
            ));

            $message = 'Unit Create Successfully!';  // message will be changed

            if($request->has('id')){
                $query = Unit::find($request->id);  // Model will be changed

                $message = 'Unit Updated Successfully!'; // message will be changed

                if(!$query){
                    return response()->json([
                    'status' => "error",
                    'message' => "Not Found, Please Try Again..."
                    ],422);
                }
            }else{
                $query = new Unit;  // Model will be changed
                $query->user_id = Auth::guard('admin')->id();
            }

            // All request name will be changed
            $query->name = $request->name;
            $query->unit_slug = Str::slug($request->name , '-');
            $query->status = $request->status;
            $query->user_id = Auth::guard('admin')->id();
            $query->save();
        }
        return response()->json([
            'status' => "success",
            'message' => $message,
        ]);
    }

    public function UnitData(Request $request)
    {
        $Unit = Unit::with('admin:id,name')->orderBy('id', 'desc')->get();  // Model & Variable will be change
        $this->i=1;

        return DataTables::of($Unit)  // Variable will be changed
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
