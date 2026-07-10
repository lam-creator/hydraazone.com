<?php

namespace App\Http\Controllers;

use App\Models\WebsiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class WebsiteSettingsController extends Controller
{

    public function WebsiteSettingsEditData(WebsiteSettings $WebsiteSettings)
    {
        $WebsiteSettingsData = WebsiteSettings::first();
        return view('back-end.pages.settings.websitesettings', compact('WebsiteSettingsData'));
    }

    // update school history
    public function WebsiteSettingsUpdate(Request $request)
    {
        $check_valid = $request->validate([
            'company_name' => 'required|min:3',
            'company_slogan' => 'required|min:3',
            'phone' => 'required|min:3',
            'support_phone' => 'required|min:3',
            'email' => 'required|email|min:3',
            'company_address' => 'required|min:3',
            'facebook_url' => 'required|min:3',
            'twitter_url' => 'required|min:3',
            'youtube_url' => 'required|min:3',
            'instagram_url' => 'required|min:3',
            'android_app_url' => 'required|min:3',
            'ios_app_url' => 'required|min:3',
            'copyright' => 'required|min:3',
            'custom_code_header' => 'nullable',
            'custom_code_footer' => 'nullable',
            'logo' => 'nullable|max:2048',
        ]);

        // check if token is valid
        if (!$check_valid) {
            $notification = array(
                'status' => 'error',
                'message' => 'Failed !!!'
            );
            return redirect()->back()->with($notification);
        } else {

            if ($request->hasFile('logo')) {
                // delete previous image
                $query = WebsiteSettings::first();
                if ($query->logo != null) {
                    unlink(public_path('uploads/logo/' . $query->logo)); // Directory name will change
                }

                // image code By using image intervention package
                $file               = $request->file('logo');
                $manager            = new ImageManager(new Driver());
                $extension          = Str::lower($file->getClientOriginalExtension());
                $filename           = Str::uuid() . Str::random(5) . '.' . $extension;
                $img                = $manager->read($file);
                $img                = $img->resize(200,100);
                $destinationPath    = public_path('uploads/logo/');  // Directory name will change
                $img->save($destinationPath.$filename);


                // image code manually
                // $image_name        = Str::uuid() . '.' . Str::random(5);
                // $ext               = Str::lower($request->file('logo')->getClientOriginalExtension());
                // $image_full_name   = $image_name.'.'.$ext;
                // $upload_path       = "uploads/logo/";  // Directory name will change
                // $image_url         = $upload_path.$image_full_name;
                // $success           = $request->file('logo')->move($upload_path,$image_full_name);

                // insert only image in database
                WebsiteSettings::first()->update([
                    'logo' => $filename
                ]);
            }

            // update data into database
            $query = WebsiteSettings::first()->update([
                'company_name' => $request->company_name,
                'company_slogan' => $request->company_slogan,
                'phone' => $request->phone,
                'support_phone' => $request->support_phone,
                'email' => $request->email,
                'company_address' => $request->company_address,
                'facebook_url' => $request->facebook_url,
                'twitter_url' => $request->twitter_url,
                'youtube_url' => $request->youtube_url,
                'instagram_url' => $request->instagram_url,
                'android_app_url' => $request->android_app_url,
                'ios_app_url' => $request->ios_app_url,
                'copyright' => $request->copyright,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
                'custom_code_header' => $request->custom_code_header,
                'custom_code_footer' => $request->custom_code_footer,
                'user_id' => Auth::guard('admin')->id(),
            ]);

            // echo '<pre>';
            // var_dump($query);
            // echo '</pre>';exit();

            if ($query) {
                $notification = array(
                    'status' => 'success',
                    'message' => 'Data Update Successfully !!!'
                );
                return redirect()->back()->with($notification);
            } else {
                $notification = array(
                    'status' => 'error',
                    'message' => 'Sorry. Data Update failed !!!'
                );
                return redirect()->back()->with($notification);
            }
        }
    }

    // End
}
