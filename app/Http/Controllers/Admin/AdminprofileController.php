<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Hash;
use File;
use Image;
use Illuminate\Support\Str;
use DB;
use DataTables;
use Session;
class AdminprofileController extends Controller
{
    public function index(){
        return view('admin.profile.adminprofile');
    }

    public function usersetting(Request $request)
    {
        $users = User::find($request->user_id);
        $users->darkmode = $request->dark;
        $users->update();
        return response()->json(['code'=>200, 'success'=> 'Update Successfully'], 200);

    }
    public function changePassword(Request $request)
    {
        
        $request->validate([
          'current_password' => 'required|max:255',
          'password' => 'required|string|min:8|confirmed|max:255',
          'password_confirmation' => 'required|max:255',
        ]);
        if($request->current_password == $request->password){
            return back()->with('error', 'Your new password can not be the same as your old password. Please choose a new password.');
        }else{
            $user = Auth::user();
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = Hash::make($request->password);
                $user->save();

                Auth::logout();
        
                return  redirect()->route('login')->with('success', trans('langconvert.functions.changepassword'));
            }
            else{
                return back()->with('error', trans('langconvert.functions.changepasswordnotmatch'));
            }
        }

        
    }
    

    public function profileedit()
    {

        return view('admin.profile.adminprofileupdate');

    }

    public function profilesetup(Request $request){
        $this->validate($request, [
            'firstname' => 'max:255',
            'lastname' => 'max:255',
        ]);
         if($request->phone){
            $this->validate($request, [
                'phone' => 'numeric',
            ]);
         }

        $user_id = Auth::user()->id;
        $user = User::findOrFail($user_id);

        $user->firstname = ucfirst($request->input('firstname'));
        $user->lastname = ucfirst($request->input('lastname'));
        $user->name = ucfirst($request->input('firstname')).' '.ucfirst($request->input('lastname'));
        $user->languagues = implode(', ', $request->input('languages'));
        $user->skills = implode(', ', $request->input('skills'));
        $user->phone = $request->input('phone');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileArray = array('image' => $file);
            $rules = array(
                'image' => 'mimes:jpeg,jpg,png|required|max:5120' // max 10000kb
              );
          
              // Now pass the input and rules into the validator
              $validator = Validator::make($fileArray, $rules);

              if ($validator->fails())
                {
                    return redirect()->back()->with('error', 'image error');
                }else{
                   
                        $destination = 'uploads/profile';
                        $image_name = time() . '.' . $file->getClientOriginalExtension();
                        $resize_image = Image::make($file->getRealPath());

                        $resize_image->resize(80, 80, function($constraint){
                        $constraint->aspectRatio();
                        })->save($destination . '/' . $image_name);

                        $destinations = 'uploads/profile/'.$user->image;
                        if(File::exists($destinations)){
                            File::delete($destinations);
                        }
                        $file = $request->file('image');
                        $user->update(['image'=>$image_name]);
                    }
            
            
        }
       
       
        $user->update(); 
        return redirect('admin/profile')->with('success', 'Update Successfully');

    }


    public function imageremove(Request $request, $id){

        $user = User::findOrFail($id);

        $user->image = null;
        $user->update();

        return response()->json(['success'=> 'Profile Delete Successfully']);
        
    }
}
