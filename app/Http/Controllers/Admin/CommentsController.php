<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\Comment;
use File;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
Use Auth;
class CommentsController extends Controller
{
    public function postComment(Request $request,  $ticket_id)
    {

        if($request->status == 'Solved')
        {

            $this->validate($request, [
                'comment' => 'required'
            ]); 
            $comment = Comment::create([
                'ticket_id' => $request->input('ticket_id'),
                'user_id' => Auth::user()->id,
                'comment' => $request->input('comment')
            ]);
            
            $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
            $ticket->status = 'Closed';
            $ticket->replystatus = $request->input('status');
            // Auto Close Ticket
            $ticket->auto_close_ticket = null;
            // Auto Response Ticket
            $ticket->auto_replystatus = null;
            $ticket->last_reply = now();
            $ticket->closing_ticket = now();
            $ticket->update();

            return redirect()->back()->with("success", 'Reply Successfuly');

        }else{
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
                'user_id' => Auth::user()->id,

                'comment' => $request->input('comment'),
                'display' => 1,
            ]);
            
            $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
            $ticket->status = $request->input('status');
            $ticket->replystatus = null;
           $ticket->last_reply = now();
            if($request->status == 'On-Hold'){
                $ticket->note = $request->input('note');
                // Auto Close Ticket
                $ticket->auto_close_ticket = null;
                // Auto Response Ticket
                $ticket->auto_replystatus = null;
            }
            // Auto Close Ticket
            $ticket->auto_close_ticket = null;
            // Auto Response Ticket
            $ticket->auto_replystatus = null;
            $ticket->update();
            

            return redirect()->back()->with("success", 'Ticket Teply Successfuly');
        }
       
    }

    public function updateedit(Request $request, $id){
        if ($request->has('message')) {

            $this->validate($request, [
                'message' => 'required'
            ]);
            $ticket = Ticket::findOrFail($id);
            $ticket->message = $request->input('message');
            
            $ticket->update(); 
            return redirect()->back();

        }else{
            $this->validate($request, [
                'editcomment' => 'required'
            ]);
            $comment = Comment::findOrFail($id);
            $comment->comment = $request->input('editcomment');
            
            $comment->update(); 
            return redirect()->back();
        }

       
    }


    public function reopenticket(Request $req){
        $reopenticket = Ticket::find($req->reopenid);
        $reopenticket->status = 'Re-Open';
        $reopenticket->replystatus = null;
        $reopenticket->update();

        return response()->json([
            'success' => 'Ticket Re-Open Successfuly',
        ]);
    }
}
