<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" dir="rtl">
            {{ __('بيانات القضية') }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <header class="mb-6">
                    <h2 class="text-3xl font-bold">{{ $dataset->name }}</h2>
                </header>

                <section class="mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded">
                            <p><strong>الرقم القومي:</strong> {{ $dataset->national_id }}</p>
                            <p><strong>العنوان:</strong> {{ $dataset->address }}</p>
                            <p><strong>رقم القضيه:</strong> {{ $dataset->case_number }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded">
                            <p><strong>نوع القضيه:</strong> {{ $dataset->caseType->name }}</p>
                            <p><strong>السداد:</strong> {{ $dataset->payment_status->getLabel() }}</p>
                            <p><strong>تاريخ الإضافة:</strong> {{ $dataset->created_at->format('Y-m-d') }}</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded mt-4">
                        <p><strong>الحكم:</strong></p>
                        <p class="mt-1">{{ $dataset->verdict }}</p>
                    </div>
                </section>

                <div class="flex justify-between mt-8">
                    <a href="{{ route('dashboard') }}" class="bg-gray-200 hover:bg-gray-300 py-2 px-4 rounded">
                        العودة إلى القائمة
                    </a>

                    @if($dataset->user_id == auth()->id() || auth()->user()->is_admin)
                        <button
                            onclick="Livewire.dispatch('openModal', { component: 'modals.confirm-delete', arguments: { id: {{ $dataset->id }}, name: '{{ $dataset->name }}' }})"
                            class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">
                            حذف القضية
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
