@extends('layouts.app') 
@section('content')
<div class="card">
    <div class="card-header">View Projects</div>

    <show-projects :data-projects="{{ $projects }}"></show-projects>
</div>
@endsection