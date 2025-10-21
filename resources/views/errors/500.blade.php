@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message')
    {{ __('Server Error') }}
    <br><br>
    {{ __('An error occurred on the page. Please try again later.') }}
    <br>
    {{ __('Or contact us if the problem persists.') }}
    <br><br>
    {{ __('Contact us:') }}
    <a href="mailto:tamas@cegem360.hu">tamas@cegem360.hu</a>
@endsection
