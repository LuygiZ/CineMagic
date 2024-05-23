@extends('layout')
@section('title','Alterar Filme' )
@section('content')

<form method="POST" action="{{route('movies.update', ['movie' => $movie]) }}" class="form-group">
    @csrf
    @method('PUT')
    @include('movies.partials.create-edit')
    <div class="form-group text-right">
        @can('update',$filme)
        <button type="submit" class="btn btn-success" name="ok">Save</button>
        @endcan
        <a href="{{route('admin.filmes.edit', ['filme' => $filme]) }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection