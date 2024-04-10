<x-mail::message>
    # Introduction:
    ## Sending mail to the Admin, bcz you have a new ticket in our system

    {{ $name }}
    {{ $email }}


    <x-mail::button :url="''">
        See the ticket
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>

