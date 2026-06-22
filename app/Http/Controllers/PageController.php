<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class PageController extends Controller
{

    public function Page()
    {
        return view('back-end.pages.page.page');
    }

    public function PageEditData(Request $request)
    {
        $query = Page::find($request->id); // Model will change
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

    public function PageInsert(Request $request)
    {

        if ($request->has('delete')) {
            $query = Page::find($request->delete); // Model will change

            $query->delete();
            $message = 'Page Deleted Successfully!'; // message will change
        } else {

            $id = $request->id ?? null; // If updating, get the ID, otherwise null
            $request->validate(array(  // All column field will change
                'title' => 'required|min:2',
                'content' => 'required|min:2',
                'location' => 'required|in:footer_1,footer_2,menu',
                'meta_title' => 'required|min:1',
                'meta_description' => 'required|min:1',
                'meta_keywords' => 'required|min:1',
                'status' => 'required|in:active,inactive',
            ));

            $message = 'Page Created Successfully!'; // Message will change

            if ($request->has('id')) {
                $query = Page::find($request->id);  // Model name will change

                $message = 'Page Updated Successfully!'; // Message will change

                if (!$query) {
                    return response()->json([
                        'status' => "error",
                        'message' => "Not Found, Please Try Again..."
                    ], 422);
                }
            } else {
                $query = new Page;  // Model name will change
            }

            // All request name will be changed
            $query->title = $request->title;
            $query->slug = Str::slug($request->title);
            $query->content = $request->content;
            $query->location = $request->location;
            $query->meta_title = $request->meta_title;
            $query->meta_description = $request->meta_description;
            $query->meta_keywords = $request->meta_keywords;
            $query->status = $request->status;
            $query->save();
        }
        return response()->json([
            'status' => "success",
            'message' => $message,
        ]);
    }

    public function PageData(Request $request)
    {
        $Page = Page::orderBy('id', 'desc')->get(); // Model & Variable will change
        $this->i = 1;

        return DataTables::of($Page)  // Variable will change
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

    public function PageDetails($slug, $id)
    {
        $PageData = Page::where('id', $id)->firstOrFail();

        // Check if the slug matches the one in the database
        if ($slug !== $PageData->slug) {
            // Redirect to the correct slug if it doesn't match
            return redirect()->route('page.details', ['slug' => $PageData->slug, 'id' => $id]);
        }
        return view('front-end.layouts.page', compact('PageData'));
    }

    // End

}
