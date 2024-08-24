@extends('layouts.public')

@section('content')
    <div class="container mx-auto p-6">
      
        <!-- Filters -->
        <div class="bg-white p-6 shadow-lg rounded-lg mb-6 border border-indigo-200">
            <form method="GET" action="{{ route('news.index') }}" class="flex flex-col md:flex-row gap-4 justify-between">
                <select name="source_id" class="form-select p-2 border border-gray-300 rounded-md w-full">
                    <option value="">Sources </option>
                    @foreach ($sources as $source)
                        <option value="{{ $source->id }}" {{ request('source_id') == $source->id ? 'selected' : '' }}>
                            {{ $source->name }}
                        </option>
                    @endforeach
                </select>

                <input type="date" name="published_from" value="{{ request('published_from') }}" class="w-full form-input p-2 border border-gray-300 rounded-md" placeholder="Published From">
                <input type="date" name="published_to" value="{{ request('published_to') }}" class="w-full form-input p-2 border border-gray-300 rounded-md" placeholder="Published To">

                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Filter</button>
            </form>
        </div>

        <!-- News Cards -->
        <div id="news-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($posts as $post)
                <div class="bg-white p-6 shadow-lg rounded-lg border border-indigo-200">
                    <img src="{{ $post->thumbnail_url }}" alt="Thumbnail" class="w-full h-32 object-cover mb-4 rounded-md">
<a href="{{ route('news.redirect', $post->id) }}" class="text-indigo-600 hover:text-green-600" target="_blank">
                        <h3 class="text-lg font-semibold ">{{ $post->title }}</h3>
                        <p class="text-gray-700 mt-2">{{ $post->news_overview }}</p>
                    </a>
                     <div class="text-gray-700 mt-2 flex items-center"> 
                                   <x-heroicon-o-calendar-date-range  class="h-4 w-4 mr-1"/>

       <p>    {{$post->date}} </p> </div>
                    <div class="flex items-center mt-2">
  <img src="{{ env('APP_URL').$post->source->logo }}" alt="{{$post->source->name}}" class="w-8 h-8 object-cover rounded-full mr-3 border border-2 border-indigo-500">
                        <p class="text-gray-700">{{ $post->source->name }}</p>
                         
                    </div>
                   
                </div>
            @endforeach
        </div>

        <!-- Load More Button -->
        @if ($posts->hasMorePages())
            <div class="mt-6 text-center">
                <button id="load-more" data-page="{{ $posts->currentPage() }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    Load More
                </button>
            </div>
        @endif
    </div>

    <script>
    document.getElementById('load-more').addEventListener('click', function() {
        var button = this;
        var page = button.getAttribute('data-page');
        var sourceId = new URLSearchParams(window.location.search).get('source_id') || '';
        var publishedFrom = new URLSearchParams(window.location.search).get('published_from') || '';
        var publishedTo = new URLSearchParams(window.location.search).get('published_to') || '';

        fetch(`{{ route('news.load_more') }}?page=${page}&source_id=${sourceId}&published_from=${publishedFrom}&published_to=${publishedTo}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html',
            },
        })
        .then(response => {
            if (response.ok) {
                return response.text();
            } else if (response.status === 404) {
                button.style.display = 'none'; // Hide the button if no more posts are found
                return Promise.reject('No more posts available.');
            } else {
                return Promise.reject('An error occurred.');
            }
        })
        .then(html => {
            if (html.trim() === '') {
                button.style.display = 'none'; // Hide the button if the HTML is empty
            } else {
                document.getElementById('news-container').insertAdjacentHTML('beforeend', html);
                button.setAttribute('data-page', parseInt(page) + 1);
            }
        })
        .catch(error => {
            console.error(error);
        });
    });
</script>

@endsection
