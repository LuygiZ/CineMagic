@extends('layout')

@section('content')
<!--<a class="add-disc">
    <form action="#" method="GET">
        <button type="submit">
            <i class="fas fa-plus-square"></i>
        </button>
    </form>
</a><!-->
<div class="row mb-3">
    
    <a href="{{route('movies.create')}}" class="btn btn-success" role="button" aria-pressed="true">Novo Filme</a>

</div>
<table class="table">
    <thead>
        <tr>
            <th>Titulo</th>
            <th>Genero</th>
            <th>Ano</th>
            <th>Cartaz</th>
            <th>Sumário</th>
            <th>Trailer</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($movies as $movie)
        <tr>
            <td>{{$movie->titulo}}</td>
            <td>{{$movie->genero_code}}</td>
            <td>{{$movie->ano}}</td>
            <td><img width="250" height="400" alt="Img" src="../storage/cartazes/{{$movie->cartaz_url}}"></td>
            <td>{{$movie->sumario}}</td>
            <td><iframe width="400" height="400" src=" "></iframe></td>
            <td>
                <a href="{{route('movies.edit', ['movie' => $movie])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a>
            </td>
            <td>
                <form action="{{route('movies.destroy', ['filme' => $film])}}" method="POST">
                    @csrf
                    @method("DELETE")
                    <input type="submit" class="btn btn-danger btn-sm" value="Apagar">
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $movies->links() }}
@endsection