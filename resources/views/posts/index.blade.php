<x-app-layout>

     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(' New List') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-6">
        <div class="bg-white p-6 rounded-lg shadow-lg">

            <!-- Filtering Form -->
            <form method="GET" action="{{ route('posts.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <h1 class="text-3xl font-bold my-auto">News Content</h1>

                    <div class="md:col-span-1">
                        <label for="source_id" class="block text-sm font-medium text-gray-700">Filter by Source:</label>
                        <select name="source_id" id="source_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">All Sources</option>
                            @foreach($sources as $source)
                                <option value="{{ $source->id }}" {{ $source->id == $sourceId ? 'selected' : '' }}>
                                    {{ $source->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-1">
                        <label for="per_page" class="block text-sm font-medium text-gray-700">Items per page:</label>
                        <select name="per_page" id="per_page" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="75" {{ $perPage == 75 ? 'selected' : '' }}>75</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>

                    <div class="flex items-end md:col-span-1 text-center">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full flex">
                            <x-heroicon-o-funnel class="h-5 w-5 mr-1"/> Apply
                        </button>
                    </div>
                </div>
            </form>

            <hr class="h-1 my-4 bg-indigo-100">

            <!-- Display message based on availability of posts -->
            <div class="mb-6">
                @if($posts->isEmpty())
                    <p class="text-lg text-gray-600">No news found.</p>
                @else
                    <p class="text-lg text-gray-600">News found: {{ $posts->total() }}</p>
                @endif
            </div>

            <!-- Display Posts in Table Format -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Source</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thumbnail</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($posts as $post)
                            <tr>
                               
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <a href="{{ $post->news_url }}" target="_blank" class="text-indigo-600 hover:underline">{{ $post->title }}</a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $post->published_date }}</td>
                                 <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    @if($post->source)
                                        <div class="flex items-center">
                                            @if($post->source->logo)
<img src="{{ env('APP_URL')  . $post->source->logo }}" alt="Source Logo" class="w-10 h-10 object-cover rounded-full mr-2">

                                            @endif
                                            {{ $post->source->name }}
                                        </div>
                                    @else
                                        No Source
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    @if($post->thumbnail_url)
                                        <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-24 h-24 object-cover rounded-md">
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-6">
                {{ $posts->appends(['source_id' => $sourceId, 'per_page' => $perPage])->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
