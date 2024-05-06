<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if(session('users')) {
            $users = session('users');
            $name = session('name');
            $email = session('email');
            $role = session('role');
            $items = 10;

            session()->forget('users');
            session()->forget('name');
            session()->forget('email');
            session()->forget('role');
        }
        else {
            $items = $request->items ?? 10;
            $users = User::where('id', '!=', auth()->user()->id)->where('status', '!=', '0')->paginate($items);
            $name = null;
            $email = null;
            $role = null;
        }

        foreach($users as $user) {
            $user->action = '
            <a id="'.$user->id.'" class="view btn btn-success btn-sm mx-1 rounded-0" title="View"><i class="bi bi-back"></i></a>
            <a id="'.$user->id.'" class="edit btn btn-warning btn-sm mx-1 rounded-0" title="Edit"><i class="bi bi-pencil-fill"></i></a>
            <a id="'.$user->id.'" class="delete btn btn-danger btn-sm mx-1 rounded-0" title="Delete"><i class="bi bi-trash"></i></a>';

            $user->name = $user->first_name . ' ' . $user->last_name;

            if($user->profile_image == null) {
                $user->profile_image = '<img src="' . asset("storage/no_user_image.jpg") . '" alt="No Image" class="table-image">';
            }
            else{
                $user->profile_image = '<img src="' . asset('storage/profile_images/'. $user->profile_image) . '" alt="Profile Image" class="table-image">';
            }

            $user->role = ($user->role == 'admin') ? '<span class="badge role-admin">Admin</span>' : '<span class="badge role-customer">Customer</span>';
            $user->status = ($user->status == '1') ? '<span class="badge text-bg-success">Activate</span>' : '<span class="badge text-bg-danger">Deactivate</span>';
        }

        return view('backend.users', [
            'users' => $users,
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'items' => $items
        ]);
    }
                                                                              
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'password' => 'required|string|min:6|max:100|',
            'password_confirmation' => 'required|same:password',
            'profile_image' => 'image|max:2048'
        ], [
            'profile_image.image' => 'The uploaded file must be an image',
            'profile_image.max' => 'The image size must not exceed 2 MB'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Creation failed!');
        }

        if($request->file('profile_image') != null) {
            $image = $request->file('profile_image');
            $image_name = $image->getClientOriginalName();
            $image->storeAs('public/profile_images', $image_name);
        }
        else {
            $image_name = null;
        }

        $user = new User();
        $data = $request->except('password', 'password_confirmation', 'profile_image');
        $data['password'] = bcrypt($request->password);
        $data['profile_image'] = $image_name;
        $user->create($data);

        return redirect()->route('admin.users.index')->with('success', 'Successfully created!');
    }

    public function show(User $user)
    {
        return response($user);
    }

    public function edit(User $user)
    {
        return response($user);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email,'.$user->id,
            'new_profile_image' => 'image|max:2048'
        ], [
            'new_profile_image.image' => 'The uploaded file must be an image',
            'new_profile_image.max' => 'The image size must not exceed 2 MB'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Update failed!');
        }

        if($request->file('new_profile_image') != null) {
            if($request->old_profile_image) {
                Storage::delete('public/profile_images/' . $request->old_profile_image);
            }

            $image = $request->file('new_profile_image');
            $image_name = $image->getClientOriginalName();
            $image->storeAs('public/profile_images', $image_name);
        }
        else {
            $image_name = $request->old_profile_image;
        }

        $data = $request->except('password', 'password_confirmation', 'old_profile_image', 'new_profile_image');

        if($request->new_password != null) {
            $validator = Validator::make($request->all(), [
                'new_password' => 'required|string|min:6|max:100|',
                'password_confirmation' => 'required|same:new_password',
            ]);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Update failed!');
            }

            $data['password'] = bcrypt($request->new_password);
        }
        
        $data['profile_image'] = $image_name;
        $user->fill($data)->save();
        
        return redirect()->route('admin.users.index')->with('success', "Successfully updated!");
    }

    public function destroy(User $user)
    {
        $user->status = '0';
        $user->save();

        return redirect()->back()->with('success', 'Successfully Deleted!');
    }

    public function filter(Request $request)
    {
        if($request->has('reset')) {
            $filter_keys = ['users', 'name', 'email', 'role'];
            foreach($filter_keys as $key) {
                session([$key => null]);
            }

            return redirect()->route('admin.users.index');
        }

        $name = $request->name;
        $email = $request->email;
        $role = $request->role;

        $users = User::where('id', '!=', auth()->user()->id)->where('status', '!=', '0');

        if($name != null) {
            $users->where('first_name', 'like', '%' . $name . '%')->orWhere('last_name', 'like', '%' . $name . '%');
        }

        if($email != null) {
            $users->where('email', 'like', '%' . $email . '%');
        }

        if($role != 'all') {
            $users->where('role', $role);
        }

        $users = $users->orderBy('id', 'asc')->paginate(10);

        session([
            'users' => $users,
            'name' => $name,
            'email' => $email,
            'role' => $role,
        ]);

        return redirect()->route('admin.users.index');
    }
}