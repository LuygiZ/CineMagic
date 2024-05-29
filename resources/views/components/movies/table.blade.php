<div {{ $attributes }} class="max-w-7xl mx-auto p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach ($movies as $movie)
    @php
        $posterPath = $movie->poster_filename ? 'storage/app/public/posters/' . $movie->poster_filename : 'storage/app/public/posters/_no_poster_1.png';
    @endphp
    <a href="{{ route('movies.show', ['movie' => $movie]) }}" class="block">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-105 hover:shadow-2xl h-full"> <!-- Set fixed height for container -->
            <img src="{{ Vite::asset($posterPath) }}" alt="Poster" class="w-full h-64 object-cover">
            <div class="p-4 h-full flex flex-col"> <!-- Set flex and full height for inner content -->
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $movie->title }}</h3>
                <p class="text-gray-700 dark:text-gray-300">{{ $movie->year }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2"><strong>Género:</strong> {{ $movie->genre_code }}</p>
                <div class="flex-grow overflow-y-auto"> <!-- Set flex-grow and overflow-y-auto for synopsis -->
                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">{{ $movie->synopsis }}</p>
                </div>
            </div>
        </div>
    </a>
    @endforeach
</div>
