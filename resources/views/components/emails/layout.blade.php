{{--
    The HTML document shared by the styled notification / confirmation e-mails:
    the head with the base CSS, the coloured header and the grey content box.

    <x-emails.layout :title="__('New contact message')" accent="#1a365d"
        :subtitle="'PSG Irodaházak - ' . __('Contact form')">
        <x-slot:styles>...template-specific CSS...</x-slot:styles>
        ...content...
    </x-emails.layout>

    `accent` is the header background colour; `heading` (the header H1) defaults to `title`.
--}}
@props(['title', 'accent', 'heading' => null, 'subtitle' => 'PSG Irodaházak'])

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }}</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
            }

            .header {
                background-color: {{ $accent }};
                color: white;
                padding: 20px;
                text-align: center;
                border-radius: 8px 8px 0 0;
            }

            .content {
                background-color: #f8f9fa;
                padding: 30px;
                border-radius: 0 0 8px 8px;
            }

            {{ $styles ?? '' }}
        </style>
    </head>

    <body>
        <div class="header">
            <h1>{{ $heading ?? $title }}</h1>
            <p>{{ $subtitle }}</p>
        </div>

        <div class="content">
            {{ $slot }}
        </div>
    </body>

</html>
