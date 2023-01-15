<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\User;
use App\Models\Role;
use Hash;
use DataTables;
use Illuminate\Support\Str;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
class AgentCreateController extends Controller
{

    public function index()
    {
        

        $user = User::with('role')->get();
        $data['users'] = $user;
     
        $roles = Role::get();
        $data['roles'] = $roles;
    
        return view('admin.agent.index')->with($data);
       
    }

    public function create()
    {
        $roles = Role::get();
        $data['roles'] = $roles;

        return view('admin.agent.agentprofilecreate')-> with($data);
    }


    public function store(Request $request)
    {
        
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'empid' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required',
            'password' => 'required|string|min:8',
        ]);
        if($request->phone){
            $request->validate([
                'phone' => 'numeric',
            ]);
        }
        
        $user = User::create([
            'firstname' => Str::ucfirst($request->input('firstname')),
            'lastname' => Str::ucfirst($request->input('lastname')),
            'empid' => Str::upper($request->empid),
            'email' => $request->email,
            'gender' => $request->gender,
            'role_id' => $request->role,
            'status' => '1',
            'password' => Hash::make($request->password),
            'skills' => $request->skills,
            'phone' => $request->phone,
            'image' => null,
            'verified' => '1',
            
        ]);

        $users = User::find($user->id);
        $users->name = $user->firstname.' '.$user->lastname;
        $users->username = $user->firstname.' '.$user->lastname;
        $users->languagues = $request->languages;
        $users->update();
        
        return redirect()->route('admin.emp.index')->with('success', 'Add Successfully');
    }


    public function userimportindex(){

        
        

        return view('admin.agent.userimport');
    }

     /**
    * @return \Illuminate\Support\Collection
    */
    public function usercsv(Request $req) 
    {
        
        
        
        Excel::import(new UserImport, request()->file('file'));
     
        return redirect()->route('admin.emp.index')->with('success', 'Emp Emport Successfully');
    }

    public function status(Request $request, $id)
    {
        $calID = User::find($id);
        $calID->status = $request->status;
        $calID->save();

        return response()->json(['code'=>200, 'success'=> 'Status Update Successfully'], 200);

    }


    public function show($id)
    {
        
        $user = User::where('id', $id)->first();
        
        
        return view('admin.agent.agentprofile')-> with($data);
    }
    
}
