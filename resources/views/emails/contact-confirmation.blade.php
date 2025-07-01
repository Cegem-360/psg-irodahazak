<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kapcsolatfelvételi üzenet megerősítése</title>
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
                background-color: #1a365d;
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
            <h1>Köszönjük üzenetét!</h1>
            <p>PSG Irodaházak</p>
        </div>

        <div class="content">
            <p>Kedves {{ $name }}!</p>

            <p>Köszönjük, hogy kapcsolatba lépett velünk. Üzenetét megkaptuk és munkatársunk hamarosan felveszi Önnel a
                kapcsolatot.</p>

            <p><strong>Az Ön üzenete:</strong></p>
            <div class="contact-info">
                <p><strong>Tárgy:</strong>
                    {{ $property_title }}
                </p>
                <p style="margin-top: 15px;">{{ $userMessage }}</p>
            </div>

            <h3>Elérhetőségeink:</h3>
            <div class="contact-info">
                <div class="contact-item">
                    <strong>Telefon:</strong>
                    <span>+36 20 381 3917</span>
                </div>
                <div class="contact-item">
                    <strong>Email:</strong>
                    <span>info@psg-irodahazak.hu</span>
                </div>
                <div class="contact-item">
                    <strong>Iroda:</strong>
                    <span>1016 Budapest, Derék u. 2.</span>
                </div>
            </div>

            <h3>Nyitvatartás:</h3>
            <div class="contact-info">
                <div class="contact-item">
                    <strong>Hétfő-Péntek:</strong>
                    <span>9:00 - 18:00</span>
                </div>
                <div class="contact-item">
                    <strong>Szombat:</strong>
                    <span>10:00 - 14:00</span>
                </div>
                <div class="contact-item">
                    <strong>Vasárnap:</strong>
                    <span>Zárva</span>
                </div>
            </div>

            <p>Amennyiben sürgős kérdése van, kérjük, hívjon minket telefonon a +36 20 381 3917 számon.</p>

            <p style="margin-top: 30px;">
                Üdvözlettel,<br>
                <strong>Property Solution Group csapata</strong>
            </p>

            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                Ez egy automatikus válasz. Kérjük, ne válaszoljon erre az emailre.
            </p>
        </div>
    </body>

</html>
