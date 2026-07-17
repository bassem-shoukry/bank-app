<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" dir="rtl">
            {{ __('إضافة قضية جديدة') }}
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Global Error Messages -->
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <strong class="font-bold">تنبيه!</strong>
                            <span>يوجد أخطاء في البيانات المدخلة.</span>
                            <ul class="mt-3 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('datasets.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- الاسم -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">الاسم</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" maxlength="255"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <p class="mt-1 text-xs text-gray-500">حروف عربية أو إنجليزية فقط، بدون أرقام.</p>
                        </div>

                        <!-- الرقم القومي -->
                        <div>
                            <label for="national_id" class="block text-sm font-medium text-gray-700">الرقم القومي</label>
                            <input type="text" id="national_id" name="national_id" value="{{ old('national_id') }}"
                                   inputmode="numeric" autocomplete="off" maxlength="14" pattern="\d{14}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <p class="mt-1 text-xs text-gray-500">14 رقمًا بدون مسافات.</p>
                        </div>

                        <!-- العنوان -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">العنوان</label>
                            <textarea id="address" name="address" rows="2" maxlength="1000"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('address') }}</textarea>
                        </div>

                        <!-- رقم القضيه -->
                        <div>
                            <label for="case_number" class="block text-sm font-medium text-gray-700">رقم القضيه</label>
                            <input type="text" id="case_number" name="case_number" value="{{ old('case_number') }}" maxlength="100"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <p class="mt-1 text-xs text-gray-500">مثال: 1234/2026</p>
                        </div>

                        <!-- نوع القضيه -->
                        <div>
                            <label for="case_type_id" class="block text-sm font-medium text-gray-700">نوع القضيه</label>
                            <select name="case_type_id" id="case_type_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- اختر نوع القضيه --</option>
                                @foreach($caseTypes as $id => $name)
                                    <option value="{{ $id }}" {{ (string) old('case_type_id') === (string) $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- الحكم -->
                        <div>
                            <label for="verdict" class="block text-sm font-medium text-gray-700">الحكم</label>
                            <textarea id="verdict" name="verdict" rows="4" maxlength="5000"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('verdict') }}</textarea>
                        </div>

                        <!-- السداد -->
                        <div>
                            <label for="payment_status" class="block text-sm font-medium text-gray-700">السداد</label>
                            <select name="payment_status" id="payment_status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- اختر حالة السداد --</option>
                                @foreach(\App\Enums\PaymentStatus::cases() as $status)
                                    <option value="{{ $status->value }}" {{ old('payment_status') === $status->value ? 'selected' : '' }}>
                                        {{ $status->getLabel() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-left">
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                حفظ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mask the national ID to digits only, 14 characters max -->
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nationalId = document.getElementById('national_id');
            nationalId.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '').slice(0, 14);
            });
        });
    </script>
    @endpush
</x-app-layout>
