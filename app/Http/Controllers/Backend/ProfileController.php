<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->user()->id);

        return view('backend.profile', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $profile)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email,'.$profile->id
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $image = $request->file('new_profile_image');
        if($image != null) {
            $validator = Validator::make($request->all(), [
                'new_profile_image' => 'image|max:2048'
            ], [
                'new_profile_image.image' => 'The uploaded file must be an image',
                'new_profile_image.max' => 'The image size must not exceed 2 MB'
            ]);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Update failed!');
            }

            if($request->old_profile_image) {
                Storage::delete('public/profile_images/' . $request->old_profile_image);
            }

            $image_name = $image->getClientOriginalName();
            $image->storeAs('public/profile_images', $image_name);
        }
        else {
            $image_name = $request->old_profile_image;
        }

        if($request->old_password != null && $request->new_password != null && $request->confirm_password != null) {

            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'required|string|min:6|max:100|',
                'confirm_password' => 'required|same:new_password',
            ]);
    
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if(Hash::check($request->old_password, $profile->password)) {
                $data = $request->except('old_password', 'new_password', 'confirm_password', 'old_profile_image', 'new_profile_image');
                $data['password'] = bcrypt($request->new_password);
                $data['profile_image'] = $image_name;
                $profile->fill($data)->save();

                Auth::guard('web')->logout();
                Auth::logoutOtherDevices($request->new_password);

                return redirect()->route('login');
            }
            else {
                return redirect()->route('admin.profile.index')->with('error', "Old password is wrong!");
            }
        }
        else {
            $data = $request->except('old_password', 'new_password', 'confirm_password', 'old_profile_image', 'new_profile_image');
            $data['profile_image'] = $image_name;
            $profile->fill($data)->save();

            return redirect()->route('admin.profile.index')->with('success', "Successfully Updated!");
        }
    }
}
