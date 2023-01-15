<?php

namespace App\Http\Controllers\User\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Response;
use Str;
use DataTables;
use App\Models\Ticket\Category;
use App\Models\Ticket\Ticket;
use App\Models\Ticketnote;
use File;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
Use Auth;
class TicketController extends Controller
{
    public function create(){
        $categories = Category::where('status', '1')
            ->get();
        return view('user.ticket.create', compact('categories'));
    }
    public function store(Request $request){
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
            'cust_id' => Auth::guard('customer')->user()->id,
            'category_id' => $request->input('category'),
            'message' => $request->input('message'),
            
            'status' => 'New',
            'file' => $file,
        ]);
        $ticket = Ticket::find($ticket->id);
        $ticket->ticket_id = 'cus'.'-'.$ticket->id;
        $categoryfind = Category::find($request->category);
        $ticket->priority = $categoryfind->priority;
        $ticket->update();

        return response()->json(['success' => 'Ticket create successfully' . $ticket->ticket_id], 200);
           
    }
    public function activeticket(){
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
        return view('admin.viewticket.activeticket');
    }

    public function show(Request $req, $ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->with('comments','category')->firstOrFail();
        $comments = $ticket->comments()->paginate(5);
        $category = $ticket->category;


        if (request()->ajax()) {
            $view = view('user.ticket.showticketdata',compact('comments'))->render();
            return response()->json(['html'=>$view]);
        }
        return view('user.ticket.showticket', compact('ticket','category', 'comments'));
        
       
    }

    public function close(Request $request,$ticket_id){
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $ticket->status = 'Re-Open';

        $ticket->update();
        return redirect()->back()->with("success", 'The ticket has been successfully reopened.');
    }
}
