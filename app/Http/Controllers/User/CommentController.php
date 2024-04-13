<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\UserResource;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Ticket $ticket, CommentRequest $request)
    {
         $request->validated();

         $comment = $ticket->comments()->forceCreate([
             'title'   => $request->string('title'),
             'text'    => $request->string('text'),
             'user_id' => 7
         ]);

         return response()->json([
             'message' => __('messages.store_success'),
             'data'    => $comment
         ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function allCommentsByTicketId(User $user, Ticket $ticket): AnonymousResourceCollection
    {
        $data = $ticket->comments()->with(['user'])->get();
        return CommentResource::collection($data);
    }
}
