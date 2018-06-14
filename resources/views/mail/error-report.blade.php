@component('mail::message')
Hi,<br>
An error while handling a request. Here are the details:


- User: {{ $user['name'] }} ({{ $user['email'] }})
- Time: {{ $timeOfException }}
- Error message: {{ $exception->getMessage() }}
- File: {{ $exception->getFile() }}
- Line: {{ $exception->getLine() }}


@component('mail::panel')

{{ $exception->getTraceAsString() }}

@endcomponent

@endcomponent
