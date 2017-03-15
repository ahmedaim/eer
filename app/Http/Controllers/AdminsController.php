<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminsController extends Controller
{


    /**
     * AdminsController constructor.
     */
    public function __construct()    {
        // Trigger authentic users only
        $this->middleware('auth');

        parent::__construct();
    }


    /**
     * Get all admin
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
//        $admins =  Admin::all();

        $limit = $request->limit?(int)$request->limit:12 ;
        $date_order = $request->date_order?$request->date_order:"desc" ;
        $admins = Admin::query();
        $admins = $admins
            ->orderBy('created_at', $date_order)
            ->paginate($limit) ;

        return view('admin.admins.index', compact('admins'));
    }


    /**
     * Create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $user = Auth::user();
        return view('admin.admins.create' , compact('user'));
    }


    /**
     * Insert new admin
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        // Begin Validations
        $this->admins_validation($request ,   "create");
        // End Validations

        // get current user authenticated
        $user = Auth::user();

        // check for user exist as admin
        $admin_exist = Admin::find($user->id);
        if($admin_exist){
            // error message
            Session::flash('error', "this admin created before");
            // redirect back to same page
            return redirect()->back();
        }

        // insert process
          $admin = $user->admins()->save(Admin::open($request->all()));
            //         Custom insert data as a test purpose
            //         $admin = $user->admins()->save(Admin::open([
            //            'username' => $request->username ,
            //            'email' => $request->email ,
            //            'idUser' => $user->id ,
            //            'role'=> $request->role,
            //            'thumbnail' => $request->thumbnail,
            //            'last_login_date' => Carbon::now(),
            //            'first_name' => $request->first_name ,
            //            'last_name' =>$request->last_name ,
            //            'mobile_number' =>$request->mobile_number,
            //            'profile_path' => $request->profile_path,
            //            "gender" =>$request->gender
            //        ]));

        if($admin){
            // Process success
            Session::flash('success', "Admin created successfully");
        }else{
            // Process Fail
            Session::flash('error', "Sorry . inserting admin process failed");
        }
        // success message

        // redirect back to same page
        return redirect()->back() ;
    }

    /**
     * Admin inputs validations
     * @param Request $request
     * @param $method
     */
    protected function admins_validation(Request $request , $method  )
    {

            // validations for insert process
            $this->validate($request, [
                'username' => 'required|between:2,16',
                'email' => 'required|email|max:255|unique:admins',
                'role' => 'required|int'
            ]
            );


    }

    /**
     * Insert fake data for test process
     * @param Request $request
     */
    public function insert_fake_data(Request $request){

        // limit param for rows limitation
        $limit = $request->limit?(int)$request->limit:3 ;

        // initiate the process
        $users = User::all();
        if($users->count() < 10 ){
            factory(User::class, 10)->create();
        }
        factory(Admin::class, $limit)->create();

    }


}
