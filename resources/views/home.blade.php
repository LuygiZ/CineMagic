@extends('layouts.main')

@section('header-title', 'Home Page')

@section('main')
<main>
    <div class="max-w-7xl mt-10 mx-auto px-4">
        <div class="bg-img relative rounded-lg shadow-lg overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
            <div class="absolute top-0 right-0 m-8 bg-white p-8 rounded-lg shadow-lg max-w-md">
                <h2 class="text-3xl font-semibold text-gray-800 mb-4">Book a Ticket</h2>
                <form id="book-ticket-form" action="{{ route('screenings.seats', ['screening' => ':screeningId']) }}" method="GET" class="space-y-4">
                    @csrf
                    <div class="mb-4">
                        <label for="movie_title" class="block text-sm font-medium text-gray-700">Movie Title</label>
                        <select id="movie_title" name="movie_title" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                            <option value="">Select a movie</option>
                            @foreach ($movies as $movie)
                                <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="screening" class="block text-sm font-medium text-gray-700">Select Session</label>
                        <select id="screening" name="screening" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                            <option value="">Select a session</option>
                        </select>
                    </div>

                    <button type="submit" id="book-now-btn" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Book Now
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mt-10 mx-auto px-4">
        <h1 class="text-4xl text-center mt-5 font-extrabold text-gray-800">On Display</h1>

        <div class="flex flex-wrap justify-center mt-8 gap-8">
            @foreach ($movies->take(8) as $movie)
                <div class="relative overflow-hidden rounded-lg shadow-lg transform transition duration-500 hover:scale-105 max-w-sm">
                    @php
                        $posterPath = $movie->poster_filename ? 'storage/app/public/posters/' . $movie->poster_filename : 'storage/app/public/posters/_no_poster_1.png';
                    @endphp
                    <a href="{{ route('movies.show', ['movie' => $movie]) }}" class="block">
                        <img src="{{ Vite::asset($posterPath) }}" alt="..." class="w-full h-96 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
                        <div class="absolute bottom-0 left-0 p-5">
                            <h1 class="text-2xl font-bold text-white">{{ $movie->title }}</h1>
                            <p class="mt-2 text-sm text-gray-300">{{ $movie->genre_code }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</main>
@endsection


<style>
    .bg-img {
        background-image: url("{{ Vite::asset('resources/img/photos/carousel1.png') }}");
        background-size: cover;
        background-position: center;
        min-height: 400px;
        position: relative;
    }

    .container {
        position: absolute;
        right: 0;
        margin: 20px;
        max-width: 300px;
        padding: 16px;
        background-color: white;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const movieSelect = document.getElementById('movie_title');
    const screeningSelect = document.getElementById('screening');
    const bookNowBtn = document.getElementById('book-now-btn');

    const screenings = @json($screenings);

    movieSelect.addEventListener('change', function() {
        const selectedMovieId = this.value;
        screeningSelect.innerHTML = '<option value="">Select a session</option>';

        if (selectedMovieId) {
            const filteredScreenings = screenings.filter(screening => screening.movie_id == selectedMovieId);

            filteredScreenings.forEach(screening => {
                const option = document.createElement('option');
                option.value = screening.id;
                option.textContent = `${screening.date} - Start Time: ${screening.start_time} - Theater ${screening.theater_id}`;
                screeningSelect.appendChild(option);
            });
        }
    });

    // Handle form submission
    bookNowBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const selectedScreeningId = screeningSelect.value;

        if (selectedScreeningId) {
            // Redirect to the seats route with the selected screening_id
            window.location.href = `{{ url('screenings/seats') }}/${selectedScreeningId}`;
        } else {
            alert('Please select a session to book.');
        }
    });
});
</script>
