@extends('errors::minimal')

@section('title', __('Not Found'))
@section('image')
<img src="{{ asset('images/404.png') }}" alt="404" class="w-4/5 mx-auto" />
@endsection
@section('message', __('Looks like you’ve got lost….'))
