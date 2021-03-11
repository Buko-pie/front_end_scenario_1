@extends('layouts.emailVerif')

@section('content')
<div class="p-5 text-light bg-amin">
    <h2 class="font-weight-bold">Welcome to Sample.Org</h2>
</div>
<br>
<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-3">
                <p>Click apply to register</p>
                <a href="{{ route('register_from') }}" class="btn btn-violet">Apply</a>
            </div>
        </div>
    </div>
</div>
@endsection