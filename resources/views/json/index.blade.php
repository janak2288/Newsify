<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('JSON Conversions') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-6">
        <div class="bg-white p-4 rounded-lg shadow-lg">
            <div class="flex justify-between mb-4">
                <h1 class="text-2xl font-bold">JSON Conversions</h1>
                <a href="{{ route('json-conversion.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <x-heroicon-s-plus class="w-5 h-5 mr-2"/>
                    Add New Conversion
                </a>
            </div>

            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Converted Url</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($conversions as $conversion)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $conversion->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $conversion->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ route('json-conversion.show', $conversion->id) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $conversion->type == 'wordpress_with_jetpack' ? 'WordPress with Jetpack' : 'WordPress without Jetpack' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('json-conversion.edit', $conversion->id) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
