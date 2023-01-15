<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ticket\Category;
use DB;
use Response;
use Str;
use DataTables;
use App\Models\Ticket\Ticket;
use App\Models\Ticketnote;
use File;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
Use Auth;
class AdminTicketController extends Controller
{
    public function createticket(){
         $categories = Category::where('status', '1')->get();
            $data['categories'] = $categories;
         return view('admin.viewticket.createticket')->with($data);
    }
    public function storeticket( Request $request){
        $this->validate($request, [
            'subject' => 'required|max:255',
            'category' => 'required',
            'message' => 'required',
            
        ]);

        $file = null;
        if ( $request->file ) 
            {
                // if ($img->video) {
                //  unlink($img->video);
                // }
                $file                   = $request->file('file');
                $fileName = time().'.'.$request->file->extension();
                $request->file->move(public_path('uploads/ticket/'), $fileName);
                $file             = 'uploads/ticket/' . $fileName;
               
            }
        $ticket = Ticket::create([
            'subject' => $request->input('subject'),
            'user_id' => Auth::user()->id,
            'category_id' => $request->input('category'),
            'message' => $request->input('message'),
            
            'status' => 'New',
            'file' => $file,
             'created_at'            => Carbon::now(),
        ]);
        $ticket = Ticket::find($ticket->id);
        $ticket->ticket_id = 'G-'.$ticket->id;
        $categoryfind = Category::find($request->category);
        $ticket->priority = $categoryfind->priority;
        $ticket->update();

        
        return response()->json(['success' => 'Ticket create' . $ticket->ticket_id], 200);

    }

    public function alltickets(Request $request){
        if(request()->ajax()) {
                $data = Ticket::latest('updated_at')->with('user')->get();
        
                return DataTables::of($data)
                ->addColumn('ticket_id', function($data){
                    $note = DB::table('ticketnotes')->pluck('ticketnotes.ticket_id')->toArray();
                    if($data->ticketnote->isEmpty()){
                        $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span>';
                    }else{
                    $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span> <span class="badge badge-warning-light">Note</span>';
                    }
                    return $ticket_id;
                })
            
               ->addColumn('subject', function($data){
                   
                    $subject = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.Str::limit($data->subject, '40').'</a>';
                    
                    return $subject;
                })
               ->addColumn('user_id',function($data){
                    $user_id = $data->user->name;
                    return $user_id;
                })
                ->addColumn('priority',function($data){
                    if($data->priority != null){
                        if($data->priority == "Low"){
                            $priority = '<span class="badge badge-success-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "High"){
                            $priority = '<span class="badge badge-danger-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "Critical"){
                            $priority = '<span class="badge badge-danger-dark">'.$data->priority.'</span>';
                        }
                        else{
                            $priority = '<span class="badge badge-warning-light">'.$data->priority.'</span>';
                        }
                    }else{
                        $priority = '~';
                    }
                    return $priority;
                })
                ->addColumn('created_at',function($data){
                    $created_at = $data->created_at->format('Y-m-d');
                    return $created_at;
                })
                ->addColumn('category_id', function($data){
                    if($data->category_id != null){
                        $category_id = Str::limit($data->category->name, '40');
                        return $category_id;
                    }else{
                        return '~';
                    }
                })
                ->addColumn('status', function($data){
        
                    

                        if($data->status == "New"){
                            $status = '<span class="badge badge-burnt-orange"> '.$data->status.' </span>';
        
                        }
                        elseif($data->status == "Re-Open"){
                            $status = '<span class="badge badge-teal">'.$data->status.'</span> ';
                        }
                        elseif($data->status == "Inprogress"){
                            $status = '<span class="badge badge-info">'.$data->status.'</span>';
                        }
                        elseif($data->status == "On-Hold"){
                            $status = '<span class="badge badge-warning">'.$data->status.'</span>';
                        }
                        else{
                            $status = '<span class="badge badge-danger">'.$data->status.'</span>';
                        }
        
                        return $status;

                    })
                ->addColumn('toassignuser_id', function($data){
                   
                        if($data->toassignuser == null){
                            $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                            Assign
                            </a>';
                        }
                        else{
                            if($data->toassignuser_id != null){
                                $toassignuser_id = '
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic outlined example">
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'"  class="btn btn-outline-primary" id="assigned" data-bs-toggle="tooltip" data-bs-placement="top" title="Change">'.$data->toassignuser->username.'</a>
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'" class="btn btn-outline-primary" id="btnremove"><i class="fe fe-x" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"></i></a>
                                </div>
                                ';
                
                            }else{
                                $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                            Assign
                            </a>';
                            }
                        }
                    return $toassignuser_id;
                })
                ->addColumn('last_reply', function($data){
                    if($data->last_reply == null){
                        $last_reply = $data->created_at->diffForHumans();
                    }else{
                        $last_reply = $data->created_at->diffForHumans();
                    }
        
                    return $last_reply;
                })
               ->addColumn('action', function($data){
        
                    $button = '<div class = "d-flex">';
                    
        
                        $button .= '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>';
                   
                    
                        $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1" id="show-delete" ><i class="feather feather-trash-2 text-danger" data-id="'.$data->id.'"data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>';
                    
                    
                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['action','user_id','priority','subject','ticket_id','created_at','category_id','status','toassignuser_id','last_reply'])
                ->addIndexColumn()
                ->make(true);
            }
                return view('admin.viewticket.alltickets');
    }

    public function show($ticket_id){

        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        $comments = $ticket->comments()->latest()->paginate(10);
        
        $category = $ticket->category;

        if (request()->ajax()) {
            
            $view = view('admin.viewticket.showticketdata',compact('comments'))->render();
            return response()->json(['html'=>$view]);
        }
       
        return view('admin.viewticket.showticket', compact('ticket','category', 'comments'));
    }
    public function ticketmassdestroy(){

    }


    public function changepriority(Request $req){

        $this->validate($req, [
            'priority_user_id' => 'required',
        ]);

        $priority = Ticket::find($req->priority_id);
        $priority->priority = $req->priority_user_id;
        $priority->update();

        $priorityname = $priority->priority;
        return response()->json(['priority' => $priorityname,'success' => 'Update Successfully'], 200);
    }


    public function note(Request $request){

        $ticketnote = Ticketnote::create([
            'ticket_id' => $request->input('ticket_id'),
            'user_id' => Auth::user()->id,
            'ticketnotes' => $request->input('ticketnote')
        ]);

        return response()->json(['success'=> 'Add Note Successfully']);
    }

    public function notedestroy($id)
    {
        $ticketnotedelete = Ticketnote::find($id);
        $ticketnotedelete->delete();

        return response()->json(['error'=> 'Delete Successfully']);


    }
    public function mytickets(){
        if(request()->ajax()) {
                $data = Ticket::where('user_id', auth()->id())->latest('updated_at')->with('user')->get();
        
                return DataTables::of($data)
                ->addColumn('ticket_id', function($data){
                    $note = DB::table('ticketnotes')->pluck('ticketnotes.ticket_id')->toArray();
                    if($data->ticketnote->isEmpty()){
                        $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span>';
                    }else{
                    $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span> <span class="badge badge-warning-light">Note</span>';
                    }
                    return $ticket_id;
                })
            
               ->addColumn('subject', function($data){
                   
                    $subject = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.Str::limit($data->subject, '40').'</a>';
                    
                    return $subject;
                })
               ->addColumn('user_id',function($data){
                    $user_id = $data->user->name;
                    return $user_id;
                })
                ->addColumn('priority',function($data){
                    if($data->priority != null){
                        if($data->priority == "Low"){
                            $priority = '<span class="badge badge-success-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "High"){
                            $priority = '<span class="badge badge-danger-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "Critical"){
                            $priority = '<span class="badge badge-danger-dark">'.$data->priority.'</span>';
                        }
                        else{
                            $priority = '<span class="badge badge-warning-light">'.$data->priority.'</span>';
                        }
                    }else{
                        $priority = '~';
                    }
                    return $priority;
                })
                ->addColumn('created_at',function($data){
                    $created_at = $data->created_at->format('Y-m-d');
                    return $created_at;
                })
                ->addColumn('category_id', function($data){
                    if($data->category_id != null){
                        $category_id = Str::limit($data->category->name, '40');
                        return $category_id;
                    }else{
                        return '~';
                    }
                })
                ->addColumn('status', function($data){
        
                    

                        if($data->status == "New"){
                            $status = '<span class="badge badge-burnt-orange"> '.$data->status.' </span>';
        
                        }
                        elseif($data->status == "Re-Open"){
                            $status = '<span class="badge badge-teal">'.$data->status.'</span> ';
                        }
                        elseif($data->status == "Inprogress"){
                            $status = '<span class="badge badge-info">'.$data->status.'</span>';
                        }
                        elseif($data->status == "On-Hold"){
                            $status = '<span class="badge badge-warning">'.$data->status.'</span>';
                        }
                        else{
                            $status = '<span class="badge badge-danger">'.$data->status.'</span>';
                        }
        
                        return $status;

                    })
                ->addColumn('toassignuser_id', function($data){
                   
                        if($data->toassignuser == null){
                            $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                            Assign
                            </a>';
                        }
                        else{
                            if($data->toassignuser_id != null){
                                $toassignuser_id = '
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic outlined example">
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'"  class="btn btn-outline-primary" id="assigned" data-bs-toggle="tooltip" data-bs-placement="top" title="Change">'.$data->toassignuser->username.'</a>
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'" class="btn btn-outline-primary" id="btnremove"><i class="fe fe-x" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"></i></a>
                                </div>
                                ';
                
                            }else{
                                $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                            Assign
                            </a>';
                            }
                        }
                    return $toassignuser_id;
                })
                ->addColumn('last_reply', function($data){
                    if($data->last_reply == null){
                        $to = Carbon::createFromFormat('Y-m-d H:s:i', '2015-5-5 3:30:34');
                        $last_reply = $to;
                    }else{
                        $to = Carbon::now();
                        $last_reply = $to->diffForHumans($data->created_at);
                    }
        
                    return $last_reply;
                })
               ->addColumn('action', function($data){
        
                    $button = '<div class = "d-flex">';
                    
        
                        $button .= '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>';
                   
                    
                        $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1" id="show-delete" ><i class="feather feather-trash-2 text-danger" data-id="'.$data->id.'"data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>';
                    
                    
                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['action','user_id','priority','subject','ticket_id','created_at','category_id','status','toassignuser_id','last_reply'])
                ->addIndexColumn()
                ->make(true);
            }
                return view('admin.viewticket.myticket');
    }
    public function activeticket(){
        
        if(request()->ajax()) {
                $data = Ticket::whereIn('status', ['New', 'Re-Open','Inprogress'])->with('user')->latest('updated_at')->get();
        
                return DataTables::of($data)
                ->addColumn('ticket_id', function($data){
                    $note = DB::table('ticketnotes')->pluck('ticketnotes.ticket_id')->toArray();
                    if($data->ticketnote->isEmpty()){
                        $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span>';
                    }else{
                    $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span> <span class="badge badge-warning-light">Note</span>';
                    }
                    return $ticket_id;
                })
            
               ->addColumn('subject', function($data){
                   
                    $subject = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.Str::limit($data->subject, '40').'</a>';
                    
                    return $subject;
                })
               ->addColumn('user_id',function($data){
                    $user_id = $data->user->name;
                    return $user_id;
                })
                ->addColumn('priority',function($data){
                    if($data->priority != null){
                        if($data->priority == "Low"){
                            $priority = '<span class="badge badge-success-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "High"){
                            $priority = '<span class="badge badge-danger-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "Critical"){
                            $priority = '<span class="badge badge-danger-dark">'.$data->priority.'</span>';
                        }
                        else{
                            $priority = '<span class="badge badge-warning-light">'.$data->priority.'</span>';
                        }
                    }else{
                        $priority = '~';
                    }
                    return $priority;
                })
                ->addColumn('created_at',function($data){
                    $created_at = $data->created_at->format('Y-m-d');
                    return $created_at;
                })
                ->addColumn('category_id', function($data){
                    if($data->category_id != null){
                        $category_id = Str::limit($data->category->name, '40');
                        return $category_id;
                    }else{
                        return '~';
                    }
                })
                ->addColumn('status', function($data){
        
                    

                        if($data->status == "New"){
                            $status = '<span class="badge badge-burnt-orange"> '.$data->status.' </span>';
        
                        }
                        elseif($data->status == "Re-Open"){
                            $status = '<span class="badge badge-teal">'.$data->status.'</span> ';
                        }
                        elseif($data->status == "Inprogress"){
                            $status = '<span class="badge badge-info">'.$data->status.'</span>';
                        }
                        elseif($data->status == "On-Hold"){
                            $status = '<span class="badge badge-warning">'.$data->status.'</span>';
                        }
                        else{
                            $status = '<span class="badge badge-danger">'.$data->status.'</span>';
                        }
        
                        return $status;

                    })
                ->addColumn('toassignuser_id', function($data){
                   
                        if($data->toassignuser == null){
                            $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                            Assign
                            </a>';
                        }
                        else{
                            if($data->toassignuser_id != null){
                                $toassignuser_id = '
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic outlined example">
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'"  class="btn btn-outline-primary" id="assigned" data-bs-toggle="tooltip" data-bs-placement="top" title="Change">'.$data->toassignuser->username.'</a>
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'" class="btn btn-outline-primary" id="btnremove"><i class="fe fe-x" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"></i></a>
                                </div>
                                ';
                
                            }else{
                                $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                            Assign
                            </a>';
                            }
                        }
                    return $toassignuser_id;
                })
                ->addColumn('last_reply', function($data){
                    if($data->last_reply == null){
                        $to = Carbon::createFromFormat('Y-m-d H:s:i', '2015-5-5 3:30:34');
                        $last_reply = $to;
                    }else{
                        $to = Carbon::now();
                        $last_reply = $to->diffForHumans($data->created_at);
                    }
        
                    return $last_reply;
                })
               ->addColumn('action', function($data){
        
                    $button = '<div class = "d-flex">';
                    
        
                        $button .= '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>';
                   
                    
                        $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1" id="show-delete" ><i class="feather feather-trash-2 text-danger" data-id="'.$data->id.'"data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>';
                    
                    
                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['action','user_id','priority','subject','ticket_id','created_at','category_id','status','toassignuser_id','last_reply'])
                ->addIndexColumn()
                ->make(true);
            }
                return view('admin.viewticket.activeticket');
    }


    public function closedticket(){

        if(request()->ajax()) {
                $data = Ticket::where('status', 'Closed')->with('user','toassignuser')->latest('updated_at')->get();
        
                return DataTables::of($data)
                ->addColumn('ticket_id', function($data){
                    $note = DB::table('ticketnotes')->pluck('ticketnotes.ticket_id')->toArray();
                    if($data->ticketnote->isEmpty()){
                        $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span>';
                    }else{
                    $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span> <span class="badge badge-warning-light">Note</span>';
                    }
                    return $ticket_id;
                })
            
               ->addColumn('subject', function($data){
                   
                    $subject = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.Str::limit($data->subject, '40').'</a>';
                    
                    return $subject;
                })
               ->addColumn('user_id',function($data){
                    $user_id = $data->user->name;
                    return $user_id;
                })
                ->addColumn('priority',function($data){
                    if($data->priority != null){
                        if($data->priority == "Low"){
                            $priority = '<span class="badge badge-success-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "High"){
                            $priority = '<span class="badge badge-danger-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "Critical"){
                            $priority = '<span class="badge badge-danger-dark">'.$data->priority.'</span>';
                        }
                        else{
                            $priority = '<span class="badge badge-warning-light">'.$data->priority.'</span>';
                        }
                    }else{
                        $priority = '~';
                    }
                    return $priority;
                })
                ->addColumn('created_at',function($data){
                    $created_at = $data->created_at->format('Y-m-d');
                    return $created_at;
                })
                ->addColumn('category_id', function($data){
                    if($data->category_id != null){
                        $category_id = Str::limit($data->category->name, '40');
                        return $category_id;
                    }else{
                        return '~';
                    }
                })
                ->addColumn('status', function($data){
        
                    

                        if($data->status == "New"){
                            $status = '<span class="badge badge-burnt-orange"> '.$data->status.' </span>';
        
                        }
                        elseif($data->status == "Re-Open"){
                            $status = '<span class="badge badge-teal">'.$data->status.'</span> ';
                        }
                        elseif($data->status == "Inprogress"){
                            $status = '<span class="badge badge-info">'.$data->status.'</span>';
                        }
                        elseif($data->status == "On-Hold"){
                            $status = '<span class="badge badge-warning">'.$data->status.'</span>';
                        }
                        else{
                            $status = '<span class="badge badge-danger">'.$data->status.'</span>';
                        }
        
                        return $status;

                    })
                ->addColumn('last_reply', function($data){
                    if($data->last_reply == null){
                        $to = Carbon::now();
                        $last_reply = $to->diffForHumans($to);
                    }else{
                        $to = Carbon::now();
                        $last_reply = $to->diffForHumans($to);
                    }
        
                    return $last_reply;
                })
               ->addColumn('action', function($data){
        
                    $button = '<div class = "d-flex">';
                    
        
                        $button .= '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>';
                   
                    
                        $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1" id="show-delete" ><i class="feather feather-trash-2 text-danger" data-id="'.$data->id.'"data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>';
                    
                    
                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['action','user_id','priority','subject','ticket_id','created_at','category_id','status','last_reply'])
                ->addIndexColumn()
                ->make(true);
            }
                return view('admin.userticket.viewticket.closedticket');
    }



    public function assignedtickets(){
        
        if(request()->ajax()) {
                $data = Ticket::where('myassignuser_id', Auth::id())->with('user')->latest('updated_at')->get();
        
                return DataTables::of($data)
                ->addColumn('ticket_id', function($data){
                    $note = DB::table('ticketnotes')->pluck('ticketnotes.ticket_id')->toArray();
                    if($data->ticketnote->isEmpty()){
                        $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span>';
                    }else{
                    $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span> <span class="badge badge-warning-light">Note</span>';
                    }
                    return $ticket_id;
                })
            
               ->addColumn('subject', function($data){
                   
                    $subject = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.Str::limit($data->subject, '40').'</a>';
                    
                    return $subject;
                })
               ->addColumn('user_id',function($data){
                    $user_id = $data->user->name;
                    return $user_id;
                })
                ->addColumn('priority',function($data){
                    if($data->priority != null){
                        if($data->priority == "Low"){
                            $priority = '<span class="badge badge-success-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "High"){
                            $priority = '<span class="badge badge-danger-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "Critical"){
                            $priority = '<span class="badge badge-danger-dark">'.$data->priority.'</span>';
                        }
                        else{
                            $priority = '<span class="badge badge-warning-light">'.$data->priority.'</span>';
                        }
                    }else{
                        $priority = '~';
                    }
                    return $priority;
                })
                ->addColumn('created_at',function($data){
                    $created_at = $data->created_at->format('Y-m-d');
                    return $created_at;
                })
                ->addColumn('category_id', function($data){
                    if($data->category_id != null){
                        $category_id = Str::limit($data->category->name, '40');
                        return $category_id;
                    }else{
                        return '~';
                    }
                })
                ->addColumn('status', function($data){
        
                    

                        if($data->status == "New"){
                            $status = '<span class="badge badge-burnt-orange"> '.$data->status.' </span>';
        
                        }
                        elseif($data->status == "Re-Open"){
                            $status = '<span class="badge badge-teal">'.$data->status.'</span> ';
                        }
                        elseif($data->status == "Inprogress"){
                            $status = '<span class="badge badge-info">'.$data->status.'</span>';
                        }
                        elseif($data->status == "On-Hold"){
                            $status = '<span class="badge badge-warning">'.$data->status.'</span>';
                        }
                        else{
                            $status = '<span class="badge badge-danger">'.$data->status.'</span>';
                        }
        
                        return $status;

                    })
                ->addColumn('toassignuser_id', function($data){
                   
                        if($data->toassignuser == null){
                            $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                            Assign
                            </a>';
                        }
                        else{
                            if($data->toassignuser_id != null){
                                $toassignuser_id = '
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic outlined example">
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'"  class="btn btn-outline-primary" id="assigned" data-bs-toggle="tooltip" data-bs-placement="top" title="Change">'.$data->toassignuser->username.'</a>
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'" class="btn btn-outline-primary" id="btnremove"><i class="fe fe-x" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"></i></a>
                                </div>
                                ';
                
                            }else{
                                $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                            Assign
                            </a>';
                            }
                        }
                    return $toassignuser_id;
                })
                ->addColumn('last_reply', function($data){
                    if($data->last_reply == null){
                        $to = Carbon::createFromFormat('Y-m-d H:s:i', '2015-5-5 3:30:34');
                        $last_reply = $to;
                    }else{
                        $to = Carbon::now();
                        $last_reply = $to->diffForHumans($data->created_at);
                    }
        
                    return $last_reply;
                })
               ->addColumn('action', function($data){
        
                    $button = '<div class = "d-flex">';
                    
        
                        $button .= '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>';
                   
                    
                        $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1" id="show-delete" ><i class="feather feather-trash-2 text-danger" data-id="'.$data->id.'"data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>';
                    
                    
                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['action','user_id','priority','subject','ticket_id','created_at','category_id','status','toassignuser_id','last_reply'])
                ->addIndexColumn()
                ->make(true);
            }
                return view('admin.assignedtickets.index');
    }

    public function myassignedtickets(){
        
        if(request()->ajax()) {
                $data = Ticket::where('toassignuser_id', Auth::id())->with('user')->latest('updated_at')->get();
        
                return DataTables::of($data)
                ->addColumn('ticket_id', function($data){
                    $note = DB::table('ticketnotes')->pluck('ticketnotes.ticket_id')->toArray();
                    if($data->ticketnote->isEmpty()){
                        $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span>';
                    }else{
                    $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span> <span class="badge badge-warning-light">Note</span>';
                    }
                    return $ticket_id;
                })
            
               ->addColumn('subject', function($data){
                   
                    $subject = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.Str::limit($data->subject, '40').'</a>';
                    
                    return $subject;
                })
               ->addColumn('user_id',function($data){
                    $user_id = $data->user->name;
                    return $user_id;
                })
                ->addColumn('priority',function($data){
                    if($data->priority != null){
                        if($data->priority == "Low"){
                            $priority = '<span class="badge badge-success-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "High"){
                            $priority = '<span class="badge badge-danger-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "Critical"){
                            $priority = '<span class="badge badge-danger-dark">'.$data->priority.'</span>';
                        }
                        else{
                            $priority = '<span class="badge badge-warning-light">'.$data->priority.'</span>';
                        }
                    }else{
                        $priority = '~';
                    }
                    return $priority;
                })
                ->addColumn('created_at',function($data){
                    $created_at = $data->created_at->format('Y-m-d');
                    return $created_at;
                })
                ->addColumn('category_id', function($data){
                    if($data->category_id != null){
                        $category_id = Str::limit($data->category->name, '40');
                        return $category_id;
                    }else{
                        return '~';
                    }
                })
                ->addColumn('status', function($data){
        
                    

                        if($data->status == "New"){
                            $status = '<span class="badge badge-burnt-orange"> '.$data->status.' </span>';
        
                        }
                        elseif($data->status == "Re-Open"){
                            $status = '<span class="badge badge-teal">'.$data->status.'</span> ';
                        }
                        elseif($data->status == "Inprogress"){
                            $status = '<span class="badge badge-info">'.$data->status.'</span>';
                        }
                        elseif($data->status == "On-Hold"){
                            $status = '<span class="badge badge-warning">'.$data->status.'</span>';
                        }
                        else{
                            $status = '<span class="badge badge-danger">'.$data->status.'</span>';
                        }
        
                        return $status;

                    })
                ->addColumn('toassignuser_id', function($data){
                   
                        if($data->toassignuser == null){
                            $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                            Assign
                            </a>';
                        }
                        else{
                            if($data->toassignuser_id != null){
                                $toassignuser_id = '
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic outlined example">
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'"  class="btn btn-outline-primary" id="assigned" data-bs-toggle="tooltip" data-bs-placement="top" title="Change">'.$data->toassignuser->username.'</a>
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'" class="btn btn-outline-primary" id="btnremove"><i class="fe fe-x" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"></i></a>
                                </div>
                                ';
                
                            }else{
                                $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                            Assign
                            </a>';
                            }
                        }
                    return $toassignuser_id;
                })
                ->addColumn('last_reply', function($data){
                    if($data->last_reply == null){
                        $to = Carbon::createFromFormat('Y-m-d H:s:i', '2015-5-5 3:30:34');
                        $last_reply = $to;
                    }else{
                        $to = Carbon::now();
                        $last_reply = $to->diffForHumans($data->created_at);
                    }
        
                    return $last_reply;
                })
               ->addColumn('action', function($data){
        
                    $button = '<div class = "d-flex">';
                    
        
                        $button .= '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>';
                   
                    
                        $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1" id="show-delete" ><i class="feather feather-trash-2 text-danger" data-id="'.$data->id.'"data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>';
                    
                    
                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['action','user_id','priority','subject','ticket_id','created_at','category_id','status','toassignuser_id','last_reply'])
                ->addIndexColumn()
                ->make(true);
            }
                return view('admin.assignedtickets.myassignedticket');
    }


    public function onholdticket(){
        
        if(request()->ajax()) {
                $data = Ticket::where('status','On-Hold')->latest('updated_at')->get();
        
                return DataTables::of($data)
                ->addColumn('ticket_id', function($data){
                    $note = DB::table('ticketnotes')->pluck('ticketnotes.ticket_id')->toArray();
                    if($data->ticketnote->isEmpty()){
                        $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span>';
                    }else{
                    $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span> <span class="badge badge-warning-light">Note</span>';
                    }
                    return $ticket_id;
                })
            
               ->addColumn('subject', function($data){
                   
                    $subject = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.Str::limit($data->subject, '40').'</a>';
                    
                    return $subject;
                })
               ->addColumn('user_id',function($data){
                    $user_id = $data->user->name;
                    return $user_id;
                })
                ->addColumn('priority',function($data){
                    if($data->priority != null){
                        if($data->priority == "Low"){
                            $priority = '<span class="badge badge-success-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "High"){
                            $priority = '<span class="badge badge-danger-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "Critical"){
                            $priority = '<span class="badge badge-danger-dark">'.$data->priority.'</span>';
                        }
                        else{
                            $priority = '<span class="badge badge-warning-light">'.$data->priority.'</span>';
                        }
                    }else{
                        $priority = '~';
                    }
                    return $priority;
                })
                ->addColumn('created_at',function($data){
                    $created_at = $data->created_at->format('Y-m-d');
                    return $created_at;
                })
                ->addColumn('category_id', function($data){
                    if($data->category_id != null){
                        $category_id = Str::limit($data->category->name, '40');
                        return $category_id;
                    }else{
                        return '~';
                    }
                })
                ->addColumn('status', function($data){
        
                    

                        if($data->status == "New"){
                            $status = '<span class="badge badge-burnt-orange"> '.$data->status.' </span>';
        
                        }
                        elseif($data->status == "Re-Open"){
                            $status = '<span class="badge badge-teal">'.$data->status.'</span> ';
                        }
                        elseif($data->status == "Inprogress"){
                            $status = '<span class="badge badge-info">'.$data->status.'</span>';
                        }
                        elseif($data->status == "On-Hold"){
                            $status = '<span class="badge badge-warning">'.$data->status.'</span>';
                        }
                        else{
                            $status = '<span class="badge badge-danger">'.$data->status.'</span>';
                        }
        
                        return $status;

                    })
                ->addColumn('toassignuser_id', function($data){
                   
                        if($data->toassignuser == null){
                            $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                            Assign
                            </a>';
                        }
                        else{
                            if($data->toassignuser_id != null){
                                $toassignuser_id = '
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic outlined example">
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'"  class="btn btn-outline-primary" id="assigned" data-bs-toggle="tooltip" data-bs-placement="top" title="Change">'.$data->toassignuser->username.'</a>
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'" class="btn btn-outline-primary" id="btnremove"><i class="fe fe-x" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"></i></a>
                                </div>
                                ';
                
                            }else{
                                $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                            Assign
                            </a>';
                            }
                        }
                    return $toassignuser_id;
                })
                ->addColumn('last_reply', function($data){
                    if($data->last_reply == null){
                        $to = Carbon::createFromFormat('Y-m-d H:s:i', '2015-5-5 3:30:34');
                        $last_reply = $to;
                    }else{
                        $to = Carbon::now();
                        $last_reply = $to->diffForHumans($data->created_at);
                    }
        
                    return $last_reply;
                })
               ->addColumn('action', function($data){
        
                    $button = '<div class = "d-flex">';
                    
        
                        $button .= '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>';
                   
                    
                        $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1" id="show-delete" ><i class="feather feather-trash-2 text-danger" data-id="'.$data->id.'"data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>';
                    
                    
                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['action','user_id','priority','subject','ticket_id','created_at','category_id','status','toassignuser_id','last_reply'])
                ->addIndexColumn()
                ->make(true);
            }
                return view('admin.assignedtickets.myassignedticket');
    }
    
}
