<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\UserResource;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class CommentController extends Controller
{

    public function store(CommentRequest $request, User $user, Ticket $ticket): JsonResponse
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


    public function show(User $user, Ticket $ticket, Comment $comment): CommentResource
    {
        $this->authorize('view', $comment);
        return new CommentResource($comment);
    }


    public function allCommentsByTicketId(User $user, Ticket $ticket): AnonymousResourceCollection
    {
        abort_if(
            $ticket->user_id != $user->id,
            404,
            __('messages.permission_deny')
        );

        $data = $ticket->comments()->with(['user'])->get();
        return CommentResource::collection($data);
    }



}
