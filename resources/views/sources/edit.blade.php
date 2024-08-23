<x-app-layout>


     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Source') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-6">
        <div class="bg-white p-2 rounded-lg shadow-lg">

        <form action="{{ route('sources.update', $source) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Source Name</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="{{ old('name', $source->name) }}" required>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="json_url" class="block text-sm font-medium text-gray-700">JSON URL</label>
                <input type="url" name="json_url" id="json_url" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="{{ old('json_url', $source->json_url) }}" required>
                @error('json_url')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
                <input type="file" name="logo" id="logo" class="mt-1 block w-full text-gray-700 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @if ($source->logo)
                    <div class="mt-2">
                        <img src="{{ env('APP_URL'). $source->logo }}" alt="Logo" class="w-auto h-16 object-cover">
                    </div>
                @endif
                @error('logo')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <x-heroicon-o-pencil class="w-5 h-5 mr-2"/>
                    Update
                </button>
            </div>
        </form>
    </div></div>
</x-app-layout>
