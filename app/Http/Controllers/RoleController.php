<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:users', ['only' => ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']]);
        $this->middleware('permission:menu-manage-role', ['only' => ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']]);
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $permission = Permission::all()
            ->sortBy([
                ['position_group', 'asc'],
                ['position', 'asc'],
            ])
            ->groupBy('group')
            ->map(function ($groupItems, $group) {
                $positionGroup = $groupItems->first()->position_group;

                $data = $groupItems->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'position' => $item->position,
                        'name' => $item->name,
                    ];
                });

                return [
                    'group' => $group,
                    'position_group' => $positionGroup,
                    'data' => $data->values()->toArray(),
                ];
            })
            ->values()
            ->toArray();
        return view('roles.create', compact('permission'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $permissionsID = array_map(
            function ($value) {
                return (int) $value;
            },
            $request->input('permission')
        );

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($permissionsID);

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    public function edit($id)
    {
        $permission = Permission::all()
            ->sortBy([
                ['position_group', 'asc'],
                ['position', 'asc'],
            ])
            ->groupBy('group')
            ->map(function ($groupItems, $group) {
                $positionGroup = $groupItems->first()->position_group;

                $data = $groupItems->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'position' => $item->position,
                        'name' => $item->name,
                    ];
                });

                return [
                    'group' => $group,
                    'position_group' => $positionGroup,
                    'data' => $data->values()->toArray(),
                ];
            })
            ->values()
            ->toArray();
        $role = Role::find($id);
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $permissionsID = array_map(
            function ($value) {
                return (int) $value;
            },
            $request->input('permission')
        );

        $role->syncPermissions($permissionsID);

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    public function destroy($id)
    {
        $role = DB::table("roles")->where('id', $id)->first();
        if ($role && $role->name === 'Super Admin') {
            return redirect()->route('roles.index')->with('error', 'The Super Admin role cannot be deleted.');
        }
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }

    public function groupsPosition(Request $request)
    {
        DB::beginTransaction();
        try {
            $groups = $request->input('groups');
            $group_position = 1;
            if (!empty($groups) && count($groups) > 0) {
                foreach ($groups as $key => $group) {
                    Permission::where('group', $group)->update(['position_group' => $group_position, 'group' => $group]);
                    $group_position++;
                }
            }
            DB::commit();
            $response = [
                'success' => true,
                'data'    => [],
                'message' => "Change groups position successfully",
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => "Failed to change groups position. Please try again later.",
            ];
            return response()->json($response, 404);
        }

    }

    public function permissionsPosition(Request $request)
    {
        DB::beginTransaction();
        try {
            $permissions = $request->input('permissions');
            $group = $request->input('group');
            $group_position_data = Permission::where('group', $group)
            ->pluck('position_group')
            ->first();

            $permissions_position = 1;
            if (!empty($permissions) && count($permissions) > 0) {
                foreach ($permissions as $key => $permission) {
                    Permission::where('id', $permission)->update(['position' => $permissions_position, 'group' => $group, 'position_group' => $group_position_data]);
                    $permissions_position++;
                }
            }
            DB::commit();
            $response = [
                'success' => true,
                'data'    => [],
                'message' => "Change permissions position successfully",
            ];
            return response()->json($response, 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => "Failed to change permissions position. Please try again later.",
            ];
            return response()->json($response, 404);
        }

    }

}
