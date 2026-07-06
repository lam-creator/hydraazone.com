<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Unit;
use App\Models\Category;
use App\Models\ProductImages;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Yajra\Datatables\Datatables;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Laravel\Pail\ValueObjects\Origin\Console;

class ProductController extends Controller
{

    public function Product()
    {
        $CategoryLists = Category::where('status','active')->get();
        $UnitLists = Unit::where('status','active')->get();
        return view('back-end.pages.product.product', compact('CategoryLists', 'UnitLists'));
    }

    public function ProductEditData(Request $request)
    {
        $query = Product::with('variants')->find($request->id); // Model will change
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

    public function ProductInsert(Request $request)
    {

        if($request->has('delete')){
            $query = Product::find($request->delete); // Model will change

            if ($query->image != null) {
                unlink(public_path('uploads/product/' . $query->image)); // image directory name will change
            }

            // Delete all gallery images
            $galleryImages = ProductImages::where('product_id', $query->id)->get();
            foreach ($galleryImages as $galleryImage) {
                if ($galleryImage->image != null) {
                    $galleryImagePath = public_path('uploads/product-gallery/' . $galleryImage->image);
                    if (file_exists($galleryImagePath)) {
                        unlink($galleryImagePath);
                    }
                }
                $galleryImage->delete();
            }

            $query->delete();

            $message = 'Product Deleted Successfully!'; // message will change
        }else{

            $id = $request->id ?? null; // If updating, get the ID, otherwise null
            $request->validate(array(  // All column field will change
                'name' => 'required|min:2',
                'category_id' => 'required',
                'unit_id' => 'required',
                'sale_price' => 'required|max:8|min:1',
                'discount_price' => 'required|max:8',
                'image' => $id ? 'nullable' : 'required', // Required if creating, nullable if updating
                'status' => 'required|in:active,inactive',
                'show_as' => 'required|in:general,featured,upcoming',
            ));

            $message = 'Product Create Successfully!'; // Message will change

            if($request->has('id')){
                $query = Product::find($request->id);  // Model name will change

                if ($request->hasFile('image')) {
                    if ($query->image != null) {
                        unlink(public_path('uploads/product/' . $query->image)); // Directory name will change
                    }
                }

                $message = 'Product Updated Successfully!'; // Message will change

                if(!$query){
                    return response()->json([
                    'status' => "error",
                    'message' => "Not Found, Please Try Again..."
                    ],422);
                }
            }else{
                $query = new Product;  // Model name will change
                $query->user_id = Auth::guard('admin')->id();
            }

            if ($request->hasFile('image')) {
                // image code By using image intervention package
                $file               = $request->file('image');
                $manager            = new ImageManager(new Driver());
                $extension          = Str::lower($file->getClientOriginalExtension());
                $filename           = Str::uuid() . Str::random(5) . '.' . $extension;
                $img                = $manager->read($file);
                $img                = $img->resize(300,400);
                $destinationPath    = public_path('uploads/product/');  // Directory name will change
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
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
            $query->name = $request->name;
            $query->product_slug = Str::slug($request->name , '-');
            $query->category_id = $request->category_id;
            $query->unit_id = $request->unit_id;
            $query->sale_price = $request->sale_price;
            $query->discount_price = $request->discount_price;
            $query->short_description = $request->short_description;
            $query->long_description = $request->long_description;
            $query->additional_info = $request->additional_info;
            $query->meta_title = $request->meta_title;
            $query->meta_keywords = $request->meta_keywords;
            $query->meta_description = $request->meta_description;
            $query->status = $request->status;
            $query->show_as = $request->show_as;

            // Only set user_id if creating a new product
            if (!$request->has('id')) {
                $query->user_id = Auth::guard('admin')->id();
            }

            $query->save();

            if ($request->has('variants') && is_array($request->variants)) {
                $query->variants()->delete();

                foreach ($request->variants as $variantData) {
                    if (empty($variantData['type']) || empty($variantData['value'])) {
                        continue;
                    }

                    ProductVariant::create([
                        'product_id' => $query->id,
                        'type' => $variantData['type'],
                        'value' => $variantData['value'],
                        'price_adjustment' => $variantData['price_adjustment'] ?? 0,
                        'stock' => $variantData['stock'] ?? 0,
                        'sku' => $variantData['sku'] ?? null,
                        'status' => $variantData['status'] ?? 'active',
                    ]);
                }
            }

            // Handle gallery images
            if ($request->hasFile('gallery_images')) {
                $manager = new ImageManager(new Driver());
                foreach ($request->file('gallery_images') as $image) {
                    $extension = Str::lower($image->getClientOriginalExtension());
                    $filename = Str::uuid() . Str::random(15) . '.' . $extension;
                    $img = $manager->read($image);
                    $img = $img->resize(300, 400);
                    $destinationPath = public_path('uploads/product-gallery/');

                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $img->save($destinationPath . $filename);

                    ProductImages::create([
                        'product_id' => $query->id,
                        'image' => $filename,
                    ]);
                }
            }
        }
        return response()->json([
            'status' => "success",
            'message' => $message,
        ]);
    }

    public function getProductGallery($productId)
    {
        $images = ProductImages::where('product_id', $productId)->get();

        return response()->json([
            'status' => 'success',
            'images' => $images
        ]);
    }

    public function deleteProductGalleryImage($imageId)
    {
        $image = ProductImages::find($imageId);

        if (!$image) {
            return response()->json([
                'status' => 'error',
                'message' => 'Image not found'
            ], 422);
        }

        if ($image->image != null) {
            $imagePath = public_path('uploads/product-gallery/' . $image->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $image->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Gallery image deleted successfully'
        ]);
    }

    // public function ProductInsertOld(Request $request)
    // {

    //     if($request->has('delete')){
    //         $query = Product::find($request->delete); // Model will change

    //         if ($query->image != null) {
    //             unlink(public_path('uploads/product/' . $query->image)); // image directory name will change
    //         }

    //         // Delete all gallery images
    //         $galleryImages = ProductImages::where('product_id', $query->id)->get();
    //         foreach ($galleryImages as $galleryImage) {
    //             if ($galleryImage->image != null) {
    //                 $galleryImagePath = public_path('uploads/product-gallery/' . $galleryImage->image);
    //                 if (file_exists($galleryImagePath)) {
    //                     unlink($galleryImagePath);
    //                 }
    //             }
    //             $galleryImage->delete();
    //         }

    //         $query->delete();

    //         $message = 'Product Deleted Successfully!'; // message will change
    //     }else{

    //         $id = $request->id ?? null; // If updating, get the ID, otherwise null
    //         $request->validate(array(  // All column field will change
    //             'name' => 'required|min:2',
    //             'category_id' => 'required',
    //             'unit_id' => 'required',
    //             'sale_price' => 'required|max:8|min:1',
    //             'discount_price' => 'required|max:8',
    //             'image' => $id ? 'nullable' : 'required', // Required if creating, nullable if updating
    //             'status' => 'required|in:active,inactive',
    //             'show_as' => 'required|in:general,featured,upcoming',
    //         ));

    //         $message = 'Product Create Successfully!'; // Message will change

    //         if($request->has('id')){
    //             $query = Product::find($request->id);  // Model name will change

    //             if ($request->hasFile('image')) {
    //                 if ($query->image != null) {
    //                     unlink(public_path('uploads/product/' . $query->image)); // Directory name will change
    //                 }
    //             }

    //             $message = 'Product Updated Successfully!'; // Message will change

    //             if(!$query){
    //                 return response()->json([
    //                 'status' => "error",
    //                 'message' => "Not Found, Please Try Again..."
    //                 ],422);
    //             }
    //         }else{
    //             $query = new Product;  // Model name will change
    //             $query->user_id = Auth::guard('admin')->id();
    //         }

    //         if ($request->hasFile('image')) {
    //             // image code By using image intervention package
    //             $file               = $request->file('image');
    //             $manager            = new ImageManager(new Driver());
    //             $extension          = Str::lower($file->getClientOriginalExtension());
    //             $filename           = Str::uuid() . Str::random(5) . '.' . $extension;
    //             $img                = $manager->read($file);
    //             $img                = $img->resize(300,400);
    //             $destinationPath    = public_path('uploads/product/');  // Directory name will change
    //             $img->save($destinationPath.$filename);
    //             $query->image       = $filename;


    //             // image code manually
    //             // $image_name        = Str::uuid() . Str::random(5);
    //             // $ext               = Str::lower($request->file('image')->getClientOriginalExtension());
    //             // $image_full_name   = $image_name.'.'.$ext;
    //             // $upload_path       = "uploads/slider/";  // Directory name will change
    //             // $image_url         = $upload_path.$image_full_name;
    //             // $success           = $request->file('image')->move($upload_path,$image_full_name);
    //             // $query->image      = $image_full_name;

    //         }

    //         // All request name will be changed
    //         $query->name = $request->name;
    //         $query->product_slug = Str::slug($request->name , '-');
    //         $query->category_id = $request->category_id;
    //         $query->unit_id = $request->unit_id;
    //         $query->sale_price = $request->sale_price;
    //         $query->discount_price = $request->discount_price;
    //         $query->short_description = $request->short_description;
    //         $query->long_description = $request->long_description;
    //         $query->additional_info = $request->additional_info;
    //         $query->meta_title = $request->meta_title;
    //         $query->meta_keywords = $request->meta_keywords;
    //         $query->meta_description = $request->meta_description;
    //         $query->status = $request->status;
    //         $query->show_as = $request->show_as;

    //         // Only set user_id if creating a new product
    //         if (!$request->has('id')) {
    //             $query->user_id = Auth::guard('admin')->id();
    //         }

    //         $query->save();
    //     }
    //     return response()->json([
    //         'status' => "success",
    //         'message' => $message,
    //     ]);
    // }

    public function ProductData(Request $request)
    {
        $Product = Product::with('category:id,name')->orderBy('id', 'desc')->get(); // Model & Variable will change
        $this->i=1;

        return DataTables::of($Product)  // Variable will change
        ->addColumn('category_id', function ($data){
            return $data->category ? $data->category->name:'';
		})

        ->addColumn('id', function ($data){
            return $this->i++;
        })
        ->addColumn('image', function ($data) {
                $url = asset('uploads/product/'. $data->image);   // Directory name will change
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
