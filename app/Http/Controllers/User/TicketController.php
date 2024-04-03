<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class TicketController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $tickets = Ticket::with([
            'priority',
            'user',
            'status',
        ])->latest();

        return TicketResource::collection($tickets->get())
                             ->additional([
                                 'total_ticket' => $tickets->count(),
                                 'open_ticket'  => $tickets->openStatus()->count(),
                                 'close_ticket' => $tickets->closeStatus()->count(),
                             ]);
    }


    public function store(StoreTicketRequest $request): JsonResponse
    {
        $request->validated();

        $ticket = Ticket::forceCreate([
            'title'       => $request->string('title'),
            'description' => $request->string('description'),
            'attachment'  => $request->file('attachment'),
            'priority_id' => $request->input('priority_id'),
            'user_id'     => auth()->user()->id,
            'status_id'   => $request->integer('status_id'),
        ]);

        return response()->json([
            'message' => __('messages.store_success'),
            'data'    => $ticket
        ]);
    }


    public function show(Ticket $ticket): TicketResource
    {
        return new TicketResource($ticket);
    }


    public function getTicketsByStatus(Request $request): JsonResponse|AnonymousResourceCollection
    {
        if ($request->input('status') == 'close') {

            $ticketsCloseStatus = Ticket::closeStatus()->get();
            return TicketResource::collection($ticketsCloseStatus)
                                 ->additional([
                                     'count' => $ticketsCloseStatus->count()
                                 ]);

        }

        if ($request->input('status') == 'open') {

            $ticketsOpenStatus = Ticket::openStatus()->get();
            return TicketResource::collection($ticketsOpenStatus)
                                 ->additional([
                                     'count' => $ticketsOpenStatus->count()
                                 ]);
        }

        return response()->json([
            'message' => __('messages.operation_failed')
        ]);
    }


    public function update(UpdateTicketRequest $request, Ticket $ticket): JsonResponse
    {
        $request->validated();

        $ticket->forceFill([
            'title'       => $request->string('title'),
            'description' => $request->string('description'),
            'attachment'  => $request->file('attachment'),
            'priority_id' => $request->input('priority_id'),
            'status_id'   => $request->integer('status_id'),
        ])->save();

        if (\Auth::user()->roles()->adminRole()->get()->isNotEmpty()){
            $ticket->assigned_to = $request->input('assigned_to');
            $ticket->save();
        }

        return response()->json([
            'message' => __('messages.update_success'),
            'data'    => $ticket
        ]);
    }


    public function destroy(string $id)
    {
        //
    }
}
