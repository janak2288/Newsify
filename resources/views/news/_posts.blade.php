@foreach ($posts as $post)
        <div class="bg-white p-6 shadow-lg rounded-lg border border-indigo-200">
                    <img src="{{ $post->thumbnail_url }}" alt="Thumbnail" class="w-full h-32 object-cover mb-4 rounded-md">
                    <a href="{{ $post->news_url }}" class="text-blue-600 hover:underline">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $post->title }}</h3>
                        <p class="text-gray-700 mt-2">{{ $post->news_overview }}</p>
                    </a>
                    <div class="flex items-center mt-4">
                        <img src="{{ env('APP_URL') . $post->source->logo }}" alt="Source Logo" class="w-12 h-12 object-cover rounded-full mr-3">
                        <p class="text-gray-700">{{ $post->source->name }}</p>
                    </div>
                </div>
@endforeach
