@extends('layouts.app')
@section('content')

{{--    {{ dd(old()) }}--}}
        <imprest v-bind:olddata="{{ count(old()) == 0 ? json_encode(new stdClass()) : json_encode(old()) }}" v-bind:errors="{{ json_encode($errors->all()) }}"></imprest>

        {{--<example></example>--}}
<script href="{{ asset('js/app.js') }}"></script>
@endsection
