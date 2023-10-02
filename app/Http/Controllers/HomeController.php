<?php

namespace App\Http\Controllers;

use App\Models\Admin\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getUserDetails(Request $request){
        $id = $request->get('id');
        $user = User::where('id',$id)->get()->first();
        return response()->json($user);
    }

    public function getUser(Request $request) {
        $searchTerm = trim($request->get('term', ''));
        $page = trim($request->get('page', 1));
        $limit = 10;
        if ($page < 1) {
            $page = 1;
        }

        $currentPage = $page;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        $userType = [];
        $tblUser = User::getTableName();
        $source = User::where('id','!=', Auth::user()->id)->where([$tblUser.'.status' => 1]);
        if(array_key_exists('user_type',$request->all())){
            if($request->get('user_type') == 'vendor'){
                $source->where($tblUser.'.role_id', Role::ROLE_VENDOR);
            }else{
                $source->where($tblUser.'.role_id', Role::ROLE_CUSTOMER);
            }
        }

        if ($searchTerm !== '' && strlen($searchTerm) > 0) {
            $source->where(function ($query) use ($searchTerm,$tblUser) {
                if (preg_match('/^[0-9]+$/', $searchTerm)) {
                    $query->where($tblUser.'.id', '=', $searchTerm);
                } else {
                    $query->where($tblUser.'.email', 'LIKE', $searchTerm.'%')
                        ->orWhere($tblUser.'.first_name', 'LIKE', $searchTerm . '%')
                        ->orWhere($tblUser.'.last_name', 'LIKE', $searchTerm . '%')
                        ->orWhere($tblUser.'.phone_number', 'LIKE', $searchTerm . '%');
                }
            });
        }

        $source->orderBy($tblUser.'.first_name', 'ASC');

        $rawSql = DB::raw('CONCAT(IFNULL('.$tblUser.'.first_name, \'\'), " ", IFNULL('.$tblUser.'.last_name, \'\')) AS full_name ');

        $result = $source->paginate($limit, ['users.id','users.first_name','users.last_name','users.email','users.gst_no',$rawSql]);

        return response()->json($result);
    }


    function sendTestEmail(){
        $data = User::where('id', 1)->get()->first();
        sendMail(\App\Emailers\Auth::class , [
            'user' => $data
        ])->onRegister($data);
    }

}
