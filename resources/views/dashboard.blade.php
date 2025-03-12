<x-app-layout>
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
{{--            {{ __('Dashboard') }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <livewire:dashboard.dataset-dashboard />
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white text-center text-lg-start mt-5 py-4 border-t border-gray-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p>© Data Fabric</p>
        </div>
    </footer>
</x-app-layout>
