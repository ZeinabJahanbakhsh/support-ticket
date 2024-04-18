<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Resources\LogResource;
use App\Http\Resources\TicketResource;
use App\Mail\SendTicketNotification;
use App\Models\Category;
use App\Models\CategoryTicket;
use App\Models\Priority;
use App\Models\Ticket;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Nette\Utils\Image;
use Spatie\Activitylog\Models\Activity;
use Str;
use function App\Helpers\adminRole;


class TicketController extends Controller
{
    public function index(User $user): JsonResponse|AnonymousResourceCollection
    {
        $tickets = $user->tickets()->with([
            'priority',
            'status',
            'categories'
        ])->latest();

        return TicketResource::collection($tickets->get())
                             ->additional([
                                 'total_ticket' => $tickets->count(),
                                 'open_ticket'  => $tickets->openStatus()->count(),
                                 'close_ticket' => $tickets->closeStatus()->count(),
                             ]);
    }


    public function store(User $user, StoreTicketRequest $request): JsonResponse
    {
        $request->validated();

        $imageUrl = null;
        $ticket   = null;

        if ($request->input('attachment')) {
            $imageUrl = $this->storeAttachment($request->input('attachment'), $user->id);
        }

        DB::transaction(function () use ($user, $request, &$ticket, &$imageUrl) {

            $ticket = $user->tickets()->forceCreate([
                'title'       => $request->string('title'),
                'description' => $request->string('description'),
                'attachment'  => $imageUrl,
                'priority_id' => $request->input('priority_id'),
                'status_id'   => $request->integer('status_id'),
            ]);

            $ticket->categories()->attach($request->input('category_ids'));
            $ticket->labels()->attach($request->input('label_ids'));
        });

        Mail::to($user->email)->send(new SendTicketNotification($user->name, $user->email));

        return response()->json([
            'message' => __('messages.store_success'),
            'data'    => $ticket
        ]);
    }


    public function show(User $user, Ticket $ticket): TicketResource
    {
        $this->authorize('view', $ticket);
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


    public function getTicketsByPriority(Priority $priority): JsonResponse|AnonymousResourceCollection
    {
        $ticketsByPriority = Ticket::where('priority_id', $priority->id)->get();

        return TicketResource::collection($ticketsByPriority)
                             ->additional([
                                 'count' => $ticketsByPriority->count()
                             ]);
    }


    public function getTicketsByCategory(Category $category): AnonymousResourceCollection
    {
        $ticketsByCategory = $category->tickets()->get();

        return TicketResource::collection($ticketsByCategory)
                             ->additional([
                                 'count' => $ticketsByCategory->count()
                             ]);

    }


    public function update(UpdateTicketRequest $request, Ticket $ticket): JsonResponse
    {
        $this->authorize('update', $ticket);

        $request->validated();

        $imageUrl = null;
        if ($request->input('attachment')) {
            $imageUrl = $this->storeAttachment($request->input('attachment'), $ticket->user_id);
        }

        $ticket->forceFill([
            'title'       => $request->string('title'),
            'description' => $request->string('description'),
            'attachment'  => $imageUrl,
            'priority_id' => $request->input('priority_id'),
            'status_id'   => $request->integer('status_id'),
        ])->save();

        if (adminRole(Auth::user())) {
            $ticket->assigned_to = $request->input('assigned_to');
            $ticket->save();
        }

        return response()->json([
            'message' => __('messages.update_success'),
            'data'    => $ticket
        ]);
    }


    public function activityLogs(): AnonymousResourceCollection
    {
        return LogResource::collection(Activity::orderByDesc('id')->where('causer_id', Auth::user()->id)->get());
    }



    private function storeAttachment($base64Image, $userId): string
    {
        $extension = explode('/', mime_content_type($base64Image))[1];
        $imageName = time() . '_' . $userId . '_' . Str::random(10) . '.' . $extension;
        @list($type, $file_data) = explode(';', $base64Image);

        $attachment = Storage::disk('ticket_attachment')->put($imageName, base64_decode($file_data));
        $imageUrl   = Storage::url($imageName);
        //dd( \File::put(storage_path(). '/attachment_' . $imageName, base64_decode($image))); //storage/attachment_....png

        return $imageUrl;
    }


}
