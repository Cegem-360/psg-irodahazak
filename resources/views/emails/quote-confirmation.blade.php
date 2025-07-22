<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('Árajánlat kérés megerősítése') }}</title>
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
                background-color: #3b82f6;
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

            .contact-info {
                background-color: white;
                padding: 20px;
                border-radius: 5px;
                border: 1px solid #e2e8f0;
                margin: 20px 0;
            }

            .contact-item {
                margin-bottom: 10px;
                display: flex;
                align-items: center;
            }

            .contact-item strong {
                color: #1a365d;
                width: 100px;
                display: inline-block;
            }

            .logo {
                text-align: center;
                margin: 20px 0;
            }
        </style>
    </head>

    <body>
        <div class="header">
            <h1>{{ __('Thank you for your quote request!') }}</h1>
            <p>{{ __('PSG Irodaházak') }}</p>
        </div>

        <div class="content">
            <p>{{ __('Kedves') }} {{ $name }}!</p>

            <p>{{ __('Köszönjük, hogy online árajánlatot kért tőlünk. Kérését megkaptuk és munkatársunk') }}
                <strong>{{ __('24 órán belül') }}</strong> {{ __('felveszi Önnel a kapcsolatot.') }}
            </p>

            <h3>{{ __('Elérhetőségeink:') }}</h3>
            <div class="contact-info">
                <div class="contact-item">
                    <strong>{{ __('Telefon') }}:</strong>
                    <span>+36 20 381 3917</span>
                </div>
                <div class="contact-item">
                    <strong>{{ __('Email') }}:</strong>
                    <span>info@psg-irodahazak.hu</span>
                </div>
                <div class="contact-item">
                    <strong>{{ __('Iroda') }}:</strong>
                    <span>{{ __('1016 Budapest, Derék u. 2.') }}</span>
                </div>
            </div>

            <h3>{{ __('Opening hours') }}:</h3>
            <div class="contact-info">
                <div class="contact-item">
                    <strong>{{ __('Monday-Friday') }}:</strong>
                    <span>{{ __('9:00 - 18:00') }}</span>
                </div>
                <div class="contact-item">
                    <strong>{{ __('Saturday') }}:</strong>
                    <span>{{ __('10:00 - 14:00') }}</span>
                </div>
                <div class="contact-item">
                    <strong>{{ __('Sunday') }}:</strong>
                    <span>{{ __('Closed') }}</span>
                </div>
            </div>

            <p>{{ __('Amennyiben sürgős kérdése van, kérjük, hívjon minket telefonon a') }} +36 20 381 3917
                {{ __('számon.') }}</p>

            <p style="margin-top: 30px;">
                {{ __('Üdvözlettel') }},<br>
                <strong>{{ __('Property Solution Group csapata') }}</strong>
            </p>

            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                {{ __('Ez egy automatikus válasz. Kérjük, ne válaszoljon erre az emailre.') }}
            </p>
        </div>
    </body>

</html>
