<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="bg-white p-2 rounded-lg shadow-lg">
            <div class="flex justify-between">
        <h1 class="text-3xl font-bold p-1">Sources</h1>
        <a href="{{ route('sources.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <x-heroicon-o-plus-circle class="w-5 h-5 mr-2"/>
            Add New Source
        </a> </div>

        @if (session('success'))
            <div class="mt-4 p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto mt-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">JSON URL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Logo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($sources as $source)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $source->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 truncate">{{ $source->json_url }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @if ($source->logo)
                                    <img src="{{ Storage::url($source->logo) }}" alt="Logo" class="w-16 h-16 object-cover rounded-md">
                                @else
                                    No Logo
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <a href="{{ route('sources.edit', $source) }}" class="text-yellow-600 hover:text-yellow-800">
                                    <x-heroicon-o-pencil class="w-5 h-5 inline-block"/>
                                </a>
                                <form action="{{ route('sources.destroy', $source) }}" method="POST" class="inline-block ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this source?');">
                                        <x-heroicon-o-trash class="w-5 h-5 inline-block"/>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> </div>
</x-app-layout>
