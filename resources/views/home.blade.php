@extends('layouts.app') 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Navigation
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item @if(request()->route()->getName() === 'admin.projects.create') active @endif">Create Projects</li>
                        <li class="list-group-item @if(request()->route()->getName() === 'admin.projects.index') active @endif">View Projects</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Porjects</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection