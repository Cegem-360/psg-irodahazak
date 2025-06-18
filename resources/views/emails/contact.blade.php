<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Új kapcsolatfelvételi üzenet</title>
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

            .field {
                margin-bottom: 15px;
                padding: 10px;
                background-color: white;
                border-radius: 5px;
                border-left: 4px solid #1a365d;
            }

            .field-label {
                font-weight: bold;
                color: #1a365d;
                margin-bottom: 5px;
            }

            .field-value {
                color: #333;
            }

            .message-box {
                background-color: white;
                padding: 20px;
                border-radius: 5px;
                border: 1px solid #e2e8f0;
                margin-top: 20px;
            }
        </style>
    </head>

    <body>
        <div class="header">
            <h1>Új kapcsolatfelvételi üzenet</h1>
            <p>PSG Irodaházak - Kapcsolatfelvételi űrlap</p>
        </div>

        <div class="content">
            <p>Új üzenet érkezett a kapcsolatfelvételi űrlapról:</p>

            <div class="field">
                <div class="field-label">Név:</div>
                <div class="field-value">{{ $name }}</div>
            </div>

            <div class="field">
                <div class="field-label">Email cím:</div>
                <div class="field-value">{{ $email }}</div>
            </div>

            <div class="field">
                <div class="field-label">Telefonszám:</div>
                <div class="field-value">{{ $phone }}</div>
            </div>

            @if ($company)
                <div class="field">
                    <div class="field-label">Cég neve:</div>
                    <div class="field-value">{{ $company }}</div>
                </div>
            @endif

            <div class="field">
                <div class="field-label">Tárgy:</div>
                <div class="field-value">
                    @switch($subject)
                        @case('iroda_keresese')
                            Iroda keresése
                        @break

                        @case('iroda_kiadas')
                            Iroda kiadása
                        @break

                        @case('ingatlan_ertekeles')
                            Ingatlan értékelés
                        @break

                        @case('befektetes')
                            Befektetési lehetőség
                        @break

                        @case('tanacadas')
                            Tanácsadás
                        @break

                        @case('egyeb')
                            Egyéb
                        @break

                        @default
                            {{ $subject }}
                    @endswitch
                </div>
            </div>

            <div class="message-box">
                <div class="field-label">Üzenet:</div>
                <div class="field-value">{{ $message }}</div>
            </div>

            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                Ez az üzenet automatikusan lett generálva a PSG Irodaházak weboldaláról.
            </p>
        </div>
    </body>

</html>
