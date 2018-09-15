@extends('layouts.app') 
@section('content')
<div class="card">
    <div class="card-header">View Project: {{ $project->name }}</div>

    <div class="card-body">
        <edit-project-form :project="{{ $project }}"></edit-project-form>
    </div>
</div>
@endsection