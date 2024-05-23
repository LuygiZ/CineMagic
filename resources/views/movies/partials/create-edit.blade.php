<div class="form-group">
    <label for="inputNome">Titulo</label>
    <input type="text" class="form-control" name="title" id="inputTitle" value="{{old('title', $movie->title)}}" >
    @error('title')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>

<div class="form-group">
    <label for="inputNome">Genero</label>
    <input type="text" class="form-control" name="genre_code" id="inputGenero" value="{{old('genre_code', $movie->genre_code)}}" >
    @error('genre_code')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>

<div class="form-group">
    <label for="inputNome">Ano</label>
    <input type="text" class="form-control" name="year" id="inputAno" value="{{old('year', $movie->year)}}" >
    @error('year')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>

<div class="form-group">
    <label for="inputNome">Sumário</label>
    <input type="text" class="form-control" name="synopsis" id="inputSynopsis" value="{{old('synopsis', $movie->synopsis)}}" >
    @error('synopsis')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>