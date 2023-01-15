<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ticket\Category;
use App\Models\Ticket\Ticket;
use DB;
use Response;
use Str;
use DataTables;
class CategoryController extends Controller
{
    public function index(){
        $categories = DB::table('categories')->paginate();
            $data['categories'] = $categories;
            
        if(request()->ajax()) {

           $data = Category::get();
           return DataTables::of($data)->addColumn('name', function($data){
                    return Str::limit($data->name, '40');
                })->addColumn('priority', function($data){
                    if($data->priority != null){

                        if($data->priority == "Low"){

                            return '<span class="badge badge-success-light" >'.$data->priority.'</span>';
                                
                        }
                        elseif($data->priority == "High"){

                            return '<span class="badge badge-danger-light">'.$data->priority.'</span>';
                                
                        }elseif($data->priority == "Critical"){

                            return '<span class="badge badge-danger-dark">'.$data->priority.'</span>';
                            
                        }else{

                            return ' <span class="badge badge-warning-light">'.$data->priority.'</span>';
                                
                        }
                    }
                    else{
                        return '~';
                    }

                })->addColumn('status', function($data){
                    
                        if($data->status == '1'){
                            $button = '
                            <label class="custom-switch form-switch mb-0">
                                <input type="checkbox" name="status" data-id="'.$data->id.'" id="myonoffswitch'.$data->id.'" value="1" class="custom-switch-input tswitch" checked>
                                <span class="custom-switch-indicator"></span>
                            </label>';
                        }else{
                            $button = ' 
                                <label class="custom-switch form-switch mb-0">
                                    <input type="checkbox" name="status" data-id="'.$data->id.'" id="myonoffswitch'.$data->id.'" value="1" class="custom-switch-input tswitch">
                                    <span class="custom-switch-indicator"></span>
                                </label> ';
                        }
                        return $button;
                    
                })->addColumn('action', function($data){
                    
                  $button = '<div class = "d-flex"><a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-id="'.$data->id.'"data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a></div>';
                    
                  return $button;
                })->rawColumns(['name','priority','status','action',])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.category.index')->with($data);
    }

    public function status(Request $request, $id)
    {
          $calID = Category::find($id);
          $calID ->status = $request->status;
          $calID ->save();
        return response()->json(['code'=>200, 'success'=> 'Update Successfully'], 200);
    }
    public function store(Request $request){
         
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories',
            ]);
            if($validator->passes()){
            $testiId = $request->testimonial_id;
            $categoryfind = Category::find($testiId);
            if($categoryfind){
                

                    $testi =  [
                        'name' => $request->name,
                        
                        'priority' => $request->priority,
                        
                        'status' => $request->status ?  '1' :  '0',
                    ];
               
                
            }
            if(!$categoryfind){
                $testi =  [
                    'name' => $request->name,
                  
                    'priority' => $request->priority,
                  
                    'status' => $request->status ?  '1' :  '0',
                ];
            }        
            $testimonial = Category::updateOrCreate(['id' => $testiId], $testi);
            return response()->json(['code'=>200, 'success'=> 'Create Successfully','data' => $testimonial], 200);
            }
            else
            {
                return Response::json(['errors' => $validator->errors()]);
            }
        
    }

    public function show($id){

        $post = Category::find($id);
        
        $data = [
            'post' => $post,
        ];
        return response()->json($data);
    }

    public function categorylist(Request $req, $ticket_id){
        if($req->ajax()){
            $output = '';
            $category = Category::where('status', '1')->get();

            $totalrow = $category->count();
            $ticket = DB::table('tickets')->where('ticket_id', $ticket_id)->first();
            if($totalrow > 0){
                $output .='<option label="Select Category"></option>';
                foreach($category as $categories){
                    $output .= '
                    <option  value="'.$categories->id.'"'.($categories->id == $ticket->category_id ? 'selected': '').'>'.$categories->name.'</option>
                    ';
                }
            }else{
                $output .= '
                <option label="No Data Found"></option>
                ';
            }


           
            
            $data = array(
                
                'table_data' => $output,
                'total_data' => $totalrow,
                'ticket' => $ticket,
                
            );
          return response()->json($data, 200);
        }
    }

    public function categorychange(Request $req)
    {

        $this->validate($req, [
            'category' => 'required',
        ]);

        $ticketcategory = Ticket::find($req->ticket_id);
        $ticketcategory->category_id = $req->category;
        
        
    
        
        
        $findcat = Category::find($req->category);
        $ticketcategory->priority = $findcat->priority;
        $ticketcategory->update();

        return response()->json(['success' => 'Update Successfully']);
        

    }

}
