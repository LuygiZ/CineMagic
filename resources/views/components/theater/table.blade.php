<div {{ $attributes }} class="max-w-7xl mx-auto p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach ($theaters as $theater)
        @php
            $photoPath = $theater->photo_filename ? 'storage/theater_photos/' . $theater->photo_filename : '/storage/posters/_no_poster_1.png';
        @endphp
        <a href="{{ route('theater.show', ['theater' => $theater]) }}" class="block">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-105 hover:shadow-2xl h-full"> <!-- Set fixed height for container -->
                <img src="{{ asset($photoPath) }}" alt="Theater Photo" class="w-full h-64 object-cover">
                <div class="p-4 h-full flex flex-col"> <!-- Set flex and full height for inner content -->
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $theater->name }}</h3>
                    <div class="flex-grow overflow-y-auto"> <!-- Set flex-grow and overflow-y-auto for additional content -->
                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-2"><strong>Number of seats:</strong> {{ $theater->seats->count() }}</p>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
</div>
