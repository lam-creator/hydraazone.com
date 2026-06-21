<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class AdminCouponController extends Controller
{

    // for permissions can be used in the controller
    protected function admin()
    {
        return Auth::guard('admin')->user();
    }

    public function Coupon()
    {
        // Check if the user has permission to view roles list
        if (!$this->admin()->can('coupon.list')) {
            abort(403, 'Access denied');
        }

        return view('back-end.pages.coupon.coupon');
    }

    public function CouponEditData(Request $request)
    {
        // Check if the user has permission to edit a role
        if (!$this->admin()->can('coupon.edit')) {
            abort(403, 'Access denied');
        }

        $query = Coupon::find($request->id);
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

    public function CouponInsert(Request $request)
    {

        if ($request->has('delete')) {

            // Check if the user has permission to delete a role
            if (!$this->admin()->can('coupon.delete')) {
                abort(403, 'Access denied');
            }

            $query = Coupon::find($request->delete);
            $query->delete();

            $message = 'Coupon Deleted Successfully!';
        } else {

            $id = $request->id ?? null;
            $request->validate(array(
                'code' => 'required|string|min:2|max:255|unique:coupons,code,' . $id,
                'discount' => 'required|integer|min:1',
                'usage_limit' => 'nullable|integer|min:1',
                'expires_at' => 'required|date',
                'status' => 'required|in:active,inactive',
            ));

            $message = 'Coupon Created Successfully!';

            if ($request->has('id')) {

                // Check if the user has permission to update a role
                if (!$this->admin()->can('coupon.edit')) {
                    abort(403, 'Access denied');
                }

                $query = Coupon::find($request->id);

                $message = 'Coupon Updated Successfully!';

                if (!$query) {
                    return response()->json([
                        'status' => "error",
                        'message' => "Not Found, Please Try Again..."
                    ], 422);
                }
            } else {

                // Check if the user has permission to create a role
                if (!$this->admin()->can('coupon.create')) {
                    abort(403, 'Access denied');
                }

                $query = new Coupon;
                // $query->user_id = Auth::guard('admin')->id();
                $query->used_count = 0;
            }

            // Convert code to uppercase
            $query->code = strtoupper($request->code);
            $query->discount = $request->discount;
            // $query->is_active = $request->status == 'active' ? true : false;
            $query->usage_limit = $request->usage_limit;
            $query->expires_at = $request->expires_at ? Carbon::parse($request->expires_at) : null;
            $query->status = $request->status;
            $query->save();
        }

        return response()->json([
            'status' => "success",
            'message' => $message,
        ]);
    }

    public function CouponData(Request $request)
    {
        // Check if the user has permission to view roles list
        if (!$this->admin()->can('coupon.list')) {
            abort(403, 'Access denied');
        }

        $Coupon = Coupon::orderBy('id', 'desc')->get();
        $this->i = 1;

        return DataTables::of($Coupon)
            ->addColumn('user_id', function ($data) {
                return $data->admin ? $data->admin->name : '';
            })
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->editColumn('code', function ($data) {
                return '<span class="badge badge-info">' . $data->code . '</span>';
            })
            ->editColumn('discount', function ($data) {
                return '৳ ' . number_format($data->discount);
            })
            ->editColumn('status', function ($data) {
                if ($data->is_active) {
                    return '<span class="badge badge-success">Active</span>';
                } else {
                    return '<span class="badge badge-danger">Inactive</span>';
                }
            })
            ->editColumn('usage', function ($data) {
                if ($data->usage_limit) {
                    return $data->used_count . ' / ' . $data->usage_limit;
                } else {
                    return $data->used_count . ' / Unlimited';
                }
            })
            ->editColumn('expires_at', function ($data) {
                if ($data->expires_at) {
                    $html = date('M d, Y H:i', strtotime($data->expires_at));
                    if (Carbon::parse($data->expires_at)->isPast()) {
                        $html .= '<br><span class="badge badge-warning">Expired</span>';
                    }
                    return $html;
                }
                return '<span class="text-muted">Never</span>';
            })
            // ->editColumn('created_at', function ($data) {
            //     return date('M d, Y', strtotime($data->created_at));
            // })
            ->addColumn('action', function ($data) {
                $htmlData = '';

                // Edit Button Permission
                if (Auth::guard('admin')->user()->can('coupon.edit')) {
                    $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-info btn-sm tableEdit"><i class="fa fa-edit"></i></a>&nbsp;';
                }

                // Delete Button Permission
                if (Auth::guard('admin')->user()->can('coupon.delete')) {
                    $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-danger btn-sm tableDelete"><i class="fa fa-trash"></i></a>&nbsp;';
                }

                // Toggle Status Button Permission
                if (Auth::guard('admin')->user()->can('coupon.edit')) {
                    $htmlData .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-secondary btn-sm tableToggleStatus"><i class="fa fa-power-off"></i></a>';
                }

                return $htmlData;
            })
            ->rawColumns(['code', 'status', 'expires_at', 'action'])
            ->toJson();
    }


    // Add toggle status method
    public function CouponToggleStatus(Request $request)
    {
        // Check if the user has permission to update a role
        if (!$this->admin()->can('coupon.edit')) {
            abort(403, 'Access denied');
        }

        $query = Coupon::find($request->id);

        if (!$query) {
            return response()->json([
                'status' => "error",
                'message' => "Not Found, Please Try Again..."
            ], 422);
        }

        $query->is_active = !$query->is_active;
        $query->save();

        $status = $query->is_active ? 'activated' : 'deactivated';

        return response()->json([
            'status' => "success",
            'message' => "Coupon " . $status . " successfully",
        ]);
    }



}
