<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RolesController extends Controller
{
    public function index(){
        $roles = Role::all();
        return view('admin.roles.index',[
            'roles' => $roles
        ]);
    }

    public function deleteRole(Role $role){
        try{
            if($role){
                $role->delete();
                return redirect()->back()->with('roleSuccessMsg',"Role deleted successfully.");
            }
        }catch(\Exception $e){
            return redirect()->back()->with('roleErrorMsg',"Role not found.");
        }
    }

    public function create(){
        return view('admin.roles.create');
    }

    public function store(Request $request){
        $role_name = $request->get('role_name');
        $status = $request->get('status');

        $validator = $request->validate([
            'role_name' => 'required|unique:roles,role_name',
            'status' => 'required'
        ]);

        $role = new Role();
        $role->role_name = $role_name;
        $role->status = $status;
        $role->save();
        return redirect()->route('roles')->with('roleSuccessMsg','Role created successfully.');

    }

    public function edit(Request $request,Role $role){
        return view('admin.roles.edit',[
            'model' => $role
        ]);
    }

    public function update(Request $request){
        $role = Role::where('id',$request->get('role_id'))->get()->first();
        if($role){
            $validator =  $request->validate([
                'role_name' => 'required|unique:roles,role_name,'.$role->id,
                'status' => 'required'
            ]);
            $role->role_name = $request->get('role_name');
            $role->status = $request->get('status');
            $role->save();
            return redirect()->back()->with("roleSuccessMsg",'Role updated successfully.');
        }else{
            return redirect()->back()->with("roleErrorMsg",'Something went wrong,please try again.');
        }
    }

}
