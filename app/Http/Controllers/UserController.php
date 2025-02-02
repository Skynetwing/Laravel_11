<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:users', ['only' => ['index','show','create','store','edit','update','destroy']]);
        $this->middleware('permission:menu-manage-users', ['only' => ['index','show','create','store','edit','update','destroy']]);
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request): View
    {
        $data = User::whereNot('user_type', 'customer')->latest()->paginate(5);
        return view('users.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        // $roles = Role::pluck('name', 'name')->all();
        $roles = Role::where('name', '!=', 'Super Admin')->pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            // 'user_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image
        ]);

        $input = $request->all();

        // Hash the password
        $input['password'] = Hash::make($input['password']);
        $input['user_pic'] = null;
        $input['user_type'] = 'admin';

        // Save user image
        if ($request->hasFile('user_pic')) {
            $file = $request->file('user_pic');
            $filePath = $file->store('user', 'public');
            $fileUrl = Storage::url($filePath);
            $input['user_pic'] = $fileUrl;
        }

        // Create the user and assign the role
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    public function show($id): View
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    public function edit($id): View
    {
        $user = User::find($id);
        // Check if the user is a "Super Admin"
        if ($user->roles->contains('name', 'Super Admin')) {
            // Only include the "Super Admin" role
            $roles = Role::where('name', 'Super Admin')->pluck('name', 'name')->all();
        } else {
            // Exclude the "Super Admin" role
            $roles = Role::where('name', '!=', 'Super Admin')->pluck('name', 'name')->all();
        }
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }

        $user = User::find($id);

        // Prevent changing the role of a Super Admin
        if ($user->hasRole('Super Admin') && 'Super Admin' != $request->input('roles')) {
            return redirect()->route('users.index')
                ->with('error', 'Cannot change the role of a Super Admin user.');
        }

        // Update user image
        if ($request->hasFile('user_pic')) {
            if ($user->user_pic) {
                $oldFilePath = public_path($user->user_pic);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $file = $request->file('user_pic');
            $filePath = $file->store('user', 'public');
            $fileUrl = Storage::url($filePath);
            $input['user_pic'] = $fileUrl;
        }

        // Update user data
        $user->update($input);

        $roles = $user->getRoleNames();
        // Only update roles if the user is not Super Admin
        if (!$user->hasRole('Super Admin') && $roles[0] != $request->input('roles')) {
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $user->assignRole($request->input('roles'));
        }

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $user = User::find($id);
        // Check if the user has the 'Super Admin' role
        if ($user && $user->hasRole('Super Admin')) {
            return redirect()->route('users.index')
                ->with('error', 'Cannot delete a user with the Super Admin role.');
        }
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

}
