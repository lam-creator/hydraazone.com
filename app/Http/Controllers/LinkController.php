<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class LinkController extends Controller
{

    public function Link()
    {
        return view('back-end.pages.link.link');
    }

    public function LinkEditData(Request $request)
    {
        $query = Link::find($request->id); // Model will change
        if (!$query) {
            return response()->json([
                'status' => "error",
                'message' => "Not Found, Please Try Again..."
            ], 422);
        }

        return response()->json([
            'status' => "success",
            'data' => $query,

        ]);
    }

    public function LinkInsert(Request $request)
    {

        if ($request->has('delete')) {
            $query = Link::find($request->delete); // Model will change

            $query->delete();
            $message = 'Link Deleted Successfully!'; // message will change
        } else {

            $id = $request->id ?? null; // If updating, get the ID, otherwise null
            $request->validate(array(  // All column field will change
                'title' => 'required|min:2',
                'link' => 'required|url',
                'location' => 'required|in:footer_1,footer_2,menu',
                'status' => 'required|in:active,inactive',
            ));

            $message = 'Link Created Successfully!'; // Message will change

            if ($request->has('id')) {
                $query = Link::find($request->id);  // Model name will change

                $message = 'Link Updated Successfully!'; // Message will change

                if (!$query) {
                    return response()->json([
                        'status' => "error",
                        'message' => "Not Found, Please Try Again..."
                    ], 422);
                }
            } else {
                $query = new Link;  // Model name will change
            }

            // All request name will be changed
            $query->title = $request->title;
            $query->slug = Str::slug($request->title);
            $query->link = $request->link;
            $query->location = $request->location;
            $query->status = $request->status;
            $query->save();
        }
        return response()->json([
            'status' => "success",
            'message' => $message,
        ]);
    }

    public function LinkData(Request $request)
    {
        $Link = Link::orderBy('id', 'desc')->get(); // Model & Variable will change
        $this->i = 1;

        return DataTables::of($Link)  // Variable will change
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('action', function ($data) {
                $htmlData = '';
                $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-info btn-sm tableEdit"><i class="fa fa-edit"></i></a>&nbsp;';
                $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-danger btn-sm tableDelete"><i class="fa fa-trash"></i></a>';
                return $htmlData;
            })
            ->rawColumns(['image', 'action'])
            ->toJson();
    }



    // End

}
