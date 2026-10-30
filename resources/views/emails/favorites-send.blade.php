<!DOCTYPE html>
<html lang="hu">

    <head>
        <meta charset="UTF-8">
        <title>{{ __('You have received an online office building offer!') }}</title>
    </head>

    <body>
        <p>{{ __('You have received an online office building offer!') }}</p>
        <br>
        <p>{{ __('Dear :name,', ['name' => $recipientName]) }}</p>
        <p>{{ $bodyText }}</p>
        <p>{{ __('We recommend the following offices to you:') }}</p>
        <ul>
            @foreach ($properties as $property)
                <li><a href="{{ $property['url'] }}">{{ $property['title'] }}</a></li>
            @endforeach
        </ul>
        <br>
        <p>{{ __('Kind regards') }},</p>
        <p>Fekete Richárd<br>
            {{ __('mobile') }}: +36 20 381 3917<br>
            e-mail: {{ config('mail.agent_address') }}</p>
    </body>

</html>
