<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-6">



        <div class="bg-white p-6 shadow-lg rounded-lg mb-6 border border-indigo-200">
            <h1 class="text-2xl font-bold text-gray-900">Welcome, {{ auth()->user()->name }}!</h1>
            <p class="mt-2 text-gray-700">
                Welcome to the News Aggregation System. Here, you can easily manage and review all news sources and posts efficiently. 
                Utilize the dashboard to quickly access key metrics and navigate through various functionalities of the system.
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Posts Card -->
            <div class="bg-white p-6 shadow-lg rounded-lg border border-indigo-200 flex items-center">
                <x-heroicon-o-document-text class="w-10 h-10 text-indigo-600 mr-4"/>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Total Posts</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalPosts }}</p>
                </div>
            </div>
            
            <!-- Total Sources Card -->
            <div class="bg-white p-6 shadow-lg rounded-lg border border-indigo-200 flex items-center">
                <x-heroicon-o-queue-list class="w-10 h-10 text-indigo-600 mr-4"/>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Total Sources</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalSources }}</p>
                </div>
            </div>
            
            <!-- Add New Source Card -->
            <div class="bg-indigo-600 text-white p-6 shadow-lg rounded-lg flex items-center justify-between">
                <a href="{{ route('sources.create') }}" class="flex items-center hover:bg-indigo-700 transition duration-200 ease-in-out">
                    <x-heroicon-o-plus-circle class="w-8 h-8"/>
                    <span class="ml-3 text-lg font-semibold">Add New Source</span>
                </a>
                <x-heroicon-o-arrow-right class="w-6 h-6"/>
            </div>

            <!-- View News List Card -->
            <div class="bg-indigo-600 text-white p-6 shadow-lg rounded-lg flex items-center justify-between">
                <a href="{{ route('posts.index') }}" class="flex items-center hover:bg-indigo-700 transition duration-200 ease-in-out">
                    <x-heroicon-o-newspaper class="w-8 h-8"/>
                    <span class="ml-3 text-lg font-semibold">View News List</span>
                </a>
                <x-heroicon-o-arrow-right class="w-6 h-6"/>
            </div>
        </div>
    </div>
</x-app-layout>
