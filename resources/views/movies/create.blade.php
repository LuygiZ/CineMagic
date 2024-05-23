@extends('layout')
@section('title','Novo Filme' )
@section('content')

    <form method="POST" action="{{route('movies.store')}}" class="form-group">
        @csrf
        @include('movies.partials.create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('movies.create')}}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection