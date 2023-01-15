if(request()->ajax()) {
                $data = Ticket::latest('updated_at')->get();
        
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
                    $cust_id = $data->user->username;
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
                    $created_at = $data->created_at->format(setting('date_format'));
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
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'"  class="btn btn-outline-primary" id="assigned" data-bs-toggle="tooltip" data-bs-placement="top" title="Change">'.$data->toassignuser->name.'</a>
                                
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
                        $last_reply = $data->last_reply->diffForHumans();
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
                ->addColumn('checkbox', function($data){
                    
                        return '<input type="checkbox" name="student_checkbox[]" class="checkall" value="'.$data->id.'" />';
                    
                })
                ->rawColumns(['action','user_id','subject','status','priority','created_at','toassignuser_id','last_reply','ticket_id','checkbox'])
                ->addIndexColumn()
                ->make(true);
            }
                return view('admin.viewticket.alltickets');