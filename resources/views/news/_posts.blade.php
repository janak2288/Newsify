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
