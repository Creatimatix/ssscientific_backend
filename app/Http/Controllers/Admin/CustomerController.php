<?php

namespace App\Http\Controllers\Admin;

use App\Emailers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Admin\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function getCustomers(){
        $customers = User::where('status',1)->where('role_id', 4)->with('role')->get()->all();
        return view('admin.customers.index',[
            'customers' => $customers,
            'type' => 'customer'
        ]);
    }

    public function deleteCustomer(User $user){
        if($user){
            $user->delete();
            return redirect()->back()->with('customerMsg','Customer deleted successfully.');
        }
    }

    public function add(Request $request){
        $type = $request->get('type');
        $roles = Role::where('status', 1)->get()->all();
        $businessHeads = User::where('status',1)->whereIn("role_id",[2])->with('role')->get()->all();
        $zones = User::ZONES;
        return view('admin.customers.create',[
            'roles' => $roles,
            'businessHeads' => $businessHeads,
            'type' => $type,
            'zones' => $zones
        ]);
    }

    public function updateCustomerForm(Request $request){
        $id = $request->get('id');
        $validated = $request->validate([
            'email' => 'required|unique:users,email,'.$id,
            'phone_number' => 'required|unique:users,phone_number,'.$id
        ]);
        $customer = User::updateOrCreate(
            ['id' => $id],
            [
                'company_name' => $request->get('company_name'),
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'phone_number' => $request->get('phone_number'),
                'email' => $request->get('email'),
                'gst_no' => $request->get('gst_no'),
                'pan_no' => $request->get('pan_no'),
                'role_id' => $request->get('role'),
                'zone' => $request->get('zone'),
                'id_manager' => $request->get('id_manager'),
                'status' => $request->get('status', 1),
                'address' => $request->input('address'),
                'apt_no' => $request->input('apt_no'),
                'zipcode' => $request->input('zipcode'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
            ],
        );

        if(array_key_exists('vendor_code',$request->all())){
            $customer->vendor_code = $request->get('vendor_code');
            $customer->save();
        }
        if(!$id){
            $customer->password = Hash::make(env('USER_PASSWORD', ''));
            $customer->save();
        }

        return redirect()->back()->with('customerMsg',"Details ".($id> 0?'updated': 'added')." successfully");

    }
    public function edit(Request $request, User $user){
        $type = $request->get('type');
        $roles = Role::where('status', 1)->get()->all();
        $businessHeads = User::where('status',1)->whereIn("role_id",[2])->where('id', '!=' ,$user->id)->with('role')->get()->all();
        $zones = User::ZONES;
        return view('admin.customers.edit',[
            'model' => $user,
            'type' => $type,
            'businessHeads' => $businessHeads,
            'roles' => $roles,
            'zones' => $zones
        ]);
    }

    public function getUsers(){
        $customers = User::where('status',1)->whereIn("role_id",[1, 2, 3])->with('role')->get()->all();

        return view('admin.customers.index',[
            'customers' => $customers,
            'type' => 'user',
        ]);
    }

    public function getVendors(){
        $customers = User::where('status',1)->where("role_id", 5)->with('role')->get()->all();
        return view('admin.customers.index',[
            'customers' => $customers,
            'type' => 'vendor'
        ]);
    }

    public function changePassword(Request $request){
        $userId = $request->get('customer_id');
        $password = $request->get('password');
        $confirmPassword = $request->get('confirm_password');

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'statusCode' => Response::HTTP_BAD_REQUEST,
                "errors" => $validator->errors()
            ]);
        }

        $user = User::where('id', $userId)->get()->first();
        if($user){
            $user->password = Hash::make($password);
            $user->save();
        }

        return response()->json([
            'statusCode' => Response::HTTP_OK,
            "message" => "Password successfully reset."
        ]);
    }
}
