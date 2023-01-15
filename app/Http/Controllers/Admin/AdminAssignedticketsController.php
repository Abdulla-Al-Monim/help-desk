<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket\Ticket;
use App\Models\User;
use Auth;

class AdminAssignedticketsController extends Controller
{
    public function show(Request $req, $id){
                    

        if($req->ajax())
        {

            $output = '';

            $assign = Ticket::find($id);
            
            $data = User::with('role')->get();

            $total_row = $data->count();

            if($total_row > 0){
                $output .='<option label="Select Agent"></option>';
                foreach($data as $row){
                    if($row->id != Auth::id())
                    $output .= '
                    <option  value="'.$row->id.'"' .($row->id == $assign->toassignuser_id ? ' selected' : '').  '>'.$row->username.' ('.$row->role->role_name.')</option>

                    ';
                }                   
                                
            }else{
                $output .='<option label="Select Agent"></option>';
                $output = '
                <option >No Data Found</option>
                ';
            }
            $data = array(
                'assign_data'=> $assign,
                'table_data' => $output,
                'total_data' => $total_row
            );

            return response()->json($data);
        }
    }


    public function create(Request $request){

        $this->validate($request, [
            'assigned_user_id' => 'required',
        ]);
        
        $calID = Ticket::find($request->assigned_id);
        $calID->toassignuser_id  = $request->assigned_user_id;
        $calID->myassignuser_id  = Auth::id();
        $calID->save();
        $calname = Ticket::where('id',$request->assigned_id)->with('toassignuser')->first();
        $name = $calname->toassignuser->username;

        return response()->json(['name'=> $name ,'code'=>200, 'success'=> 'Ticket assigned'], 200);

    }

    public function update($id){
        $calID = Ticket::find($id);
        $calID->toassignuser_id  = null;
        $calID->myassignuser_id  = null;
        $calID->save();
        return response()->json(['data'=> $calID, 'error'=> 'Update Successfully']);

    }
}
