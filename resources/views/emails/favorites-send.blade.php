<!DOCTYPE html>
<html lang="hu">

    <head>
        <meta charset="UTF-8">
        <title>Online irodaház ajánlat érkezett!</title>
    </head>

    <body>
        <p>Online irodaház ajánlat érkezett!</p>
        <br>
        <p>Kedves {{ $recipientName }},</p>
        <p>{{ $bodyText }}</p>
        <p>Az alábbi irodákat ajánljuk Önnek:</p>
        <ul>
            @foreach ($properties as $property)
                <li><a href="{{ $property['url'] }}">{{ $property['title'] }}</a></li>
            @endforeach
        </ul>
        <br>
        <p>Üdvözlettel,</p>
        <p>Fekete Richárd<br>
            mobil: +36 20 381 3917<br>
            e-mail: richard.fekete@psg-irodahazak.hu</p>
    </body>

</html>
