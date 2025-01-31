<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionController extends Controller
{

    public function index()
    {

        $users = User::all();
        
        $roles = Role::all();


        return view('roles.index', ['users' => $users,'roles'=>$roles]);
    }

    public function showcreateform()
    {
        $permissions = Permission::all();

        return view('roles.create', ['permissions' => $permissions]);
    }
    public function createrolesandpermission(Request $request)
    {
        
        $role = strtolower($request->role);
        $role = Role::firstOrCreate(['name' => $role]);
        $request->validate([
            'role' => 'required|string|max:255',
            'permissions' => 'required|array|min:1',
        ]);
        foreach ($request->permissions as $permission) {
            $setpermission = Permission::where('id', $permission)->pluck('name');
            $role->givePermissionTo($setpermission);
        }

        return redirect(route('users.index'));
    }
    public function setroles(Request $request)
    {
      
        $user = User::where('name', "Darshil")->first();
        if ($user) {
        $request->validate([
            'roles' => 'required|array|min:1',
        ]);
        foreach ($request->roles as $role) {
            $setrole = Role::where('id', $role)->pluck('name');
            $user->assignRole($setrole->first());
        }
      
    }
        return redirect(route('users.index'));
    }
    public function removeroles(Request $request)
    {
        
       
        $request->validate([
            'roles' => 'required|array|min:1',
            'user_id'=>'required'
        ]);
        $user = User::where('id', $request->user_id)->first();
        foreach ($request->roles as $role) {
           
            $removerole = Role::where('id', $role)->pluck('name');
            
            $user->removeRole($removerole->first());
        }

        return redirect(route('users.index'));
    }
}
