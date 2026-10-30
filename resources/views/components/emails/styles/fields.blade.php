{{--
    CSS of <x-emails.field> rows, coloured with the e-mail's accent colour.
--}}
@props(['accent'])

.field {
    margin-bottom: 15px;
    padding: 10px;
    background-color: white;
    border-radius: 5px;
    border-left: 4px solid {{ $accent }};
}

.field-label {
    font-weight: bold;
    color: {{ $accent }};
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
