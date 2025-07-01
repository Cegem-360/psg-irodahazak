<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Új árajánlat kérés</title>
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
                background-color: #f97316;
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
                border-left: 4px solid #f97316;
            }

            .field-label {
                font-weight: bold;
                color: #f97316;
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

            .quote-id {
                background-color: #fef3c7;
                padding: 10px;
                border-radius: 5px;
                margin-bottom: 20px;
                text-align: center;
            }
        </style>
    </head>

    <body>
        <div class="header">
            <h1>Új árajánlat kérés érkezett</h1>
            <p>PSG Irodaházak - Online ajánlatkérés</p>
        </div>

        <div class="content">
            <div class="quote-id">
                <strong>Árajánlat azonosító: #{{ $quoteId }}</strong>
            </div>

            <p>Új árajánlat kérés érkezett az online kapcsolatfelvételi űrlapról:</p>

            <div class="field">
                <div class="field-label">Név:</div>
                <div class="field-value">{{ $name }}</div>
            </div>
            <div class="field">
                <div class="field-label">Cég:</div>
                <div class="field-value">{{ $company }}</div>
            </div>

            <div class="field">
                <div class="field-label">Telefonszám:</div>
                <div class="field-value">{{ $phone }}</div>
            </div>

            <div class="field">
                <div class="field-label">Email cím:</div>
                <div class="field-value">{{ $email }}</div>
            </div>
            <div class="field">
                <div class="field-label">Tárgy:</div>
                <div class="field-value">{{ $subject }}</div>
            </div>

            @if ($userMessage)
                <div class="message-box">
                    <div class="field-label">Üzenet:</div>
                    <div class="field-value">{{ $userMessage }}</div>
                </div>
            @endif

            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                Ez az üzenet automatikusan lett generálva a PSG Irodaházak weboldaláról.
                <br>
                Kérjük, vegye fel a kapcsolatot az ügyféllel a lehető leghamarabb!
            </p>
        </div>
    </body>

</html>
