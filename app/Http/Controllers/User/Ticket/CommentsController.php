<?php

namespace App\Http\Controllers\User\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket\Comment;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\Category;
use App\Models\User;
use Hash;
use Auth;
class CommentsController extends Controller
{
    public function postComment(Request $request,  $ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        if($ticket->status == "Closed"){
            
             return redirect()->back()->with("error",'The ticket has been already closed.');
        }
        else{
            $this->validate($request, [
                'comment' => 'required'
            ]);
            $tic = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
            if($tic->comments()->get() != null){
                $comm = $tic->comments()->update([
                    'display' => null
                ]);
            }
            $comment = Comment::create([
                'ticket_id' => $request->input('ticket_id'),
                'cust_id' => Auth::guard('customer')->user()->id,
                'user_id' => null,
                'display' => 1,
                'comment' => $request->input('comment')
            ]);

            

            // Closing the ticket
            if(request()->has(['status'])){

                $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

                $ticket->status = $request->input('status');
                $ticket->closing_ticket = now()->format('Y-m-d');
                $ticket->update();

                $ticketOwner = $ticket->user;

            }

            $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
            $ticket->last_reply = now();
            // Auto Overdue Ticket

            

            
            // End Auto Close Ticket

            if(request()->input(['status']) == 'Closed'){
                $ticket->replystatus = 'Solved';
            }
            $ticket->update();
        
            
            return redirect()->back()->with("success", trans('langconvert.functions.ticketreply'));
        }
       
    }

    public function updateedit(Request $request, $id){
        
            $this->validate($request, [
                'editcomment' => 'required'
            ]);
          
            $comment = Comment::findOrFail($id);
            $comment->comment = $request->input('editcomment');
            
            $comment->update(); 
            return redirect()->back()->with('success', 'Updated successfully');
        

       
    }
}
