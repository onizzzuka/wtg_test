@extends('app')

@section('content')
    <div id="app" class="h-full"></div>
@endsection

<script>
    window.__CHAT__ = {
        me: @json($me),
        users: @json($users),
    };
</script>
