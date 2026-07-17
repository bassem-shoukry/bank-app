<div dir="rtl">
    <section class="description text-center">
        <h2 class="text-3xl font-bold mb-2">سجل القضايا</h2>
        <p class="text-lg mb-8">إدارة بيانات القضايا</p>
    </section>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6 flex justify-between items-center">
        <div class="flex gap-2">
            <a href="{{ route('datasets.create') }}" class="bg-gray-100 border border-gray-300 py-2 px-4 hover:bg-gray-200 transition">
                إضافة قضية جديدة
            </a>
            <button wire:click="resetFilters" class="bg-red-50 border border-red-200 py-2 px-4 hover:bg-red-100 transition">
                إعادة تعيين البحث
            </button>
        </div>
        <input wire:model.live="searchTerm" type="text" placeholder="بحث بالاسم أو الرقم القومي أو رقم القضية..."
               class="border border-gray-300 px-4 py-2 rounded w-1/3">
    </div>

    <div class="bg-gray-100 overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
            <tr>
                <th class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-right">الاسم</th>
                <th class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-right">الرقم القومي</th>
                <th class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-right">رقم القضيه</th>
                <th class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-right">نوع القضيه</th>
                <th class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-right">السداد</th>
                <th class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-right">إجراءات</th>
            </tr>
            </thead>
            <tbody>
            @forelse($datasets as $dataset)
                <tr>
                    <td class="py-3 px-4 border-b border-gray-200">{{ $dataset->name }}</td>
                    <td class="py-3 px-4 border-b border-gray-200">{{ $dataset->national_id }}</td>
                    <td class="py-3 px-4 border-b border-gray-200">{{ $dataset->case_number }}</td>
                    <td class="py-3 px-4 border-b border-gray-200">{{ $dataset->caseType->name }}</td>
                    <td class="py-3 px-4 border-b border-gray-200">{{ $dataset->payment_status->getLabel() }}</td>
                    <td class="py-3 px-4 border-b border-gray-200">
                        <div class="flex gap-2">
                            <a href="{{ route('datasets.show', $dataset) }}" class="text-blue-500 hover:text-blue-700" title="عرض">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            @if($dataset->user_id == Auth::id() || Auth::user()->is_admin)
                                <button
                                    wire:click="$dispatch('openModal', { component: 'modals.confirm-delete', arguments: { id: {{ $dataset->id }}, name: '{{ $dataset->name }}' }})"
                                    class="text-red-500 hover:text-red-700"
                                    title="حذف">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-3 px-4 border-b border-gray-200 text-center">لا توجد قضايا</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $datasets->links() }}
    </div>
</div>
