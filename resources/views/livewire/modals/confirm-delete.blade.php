<div class="p-6 bg-white rounded-lg">
    <h3 class="text-lg font-medium text-gray-900">Confirm Delete</h3>

    <div class="mt-4">
        <p class="text-sm text-gray-600">
            Are you sure you want to delete the dataset <strong>"{{ $name }}"</strong>?
            This action cannot be undone.
        </p>
    </div>

    <div class="mt-6 flex justify-end gap-3">
        <button
            wire:click="$dispatch('closeModal')"
            type="button"
            class="py-2 px-4 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md">
            Cancel
        </button>

        <button
            wire:click="delete"
            type="button"
            class="py-2 px-4 bg-red-600 hover:bg-red-700 text-white rounded-md">
            Delete Dataset
        </button>
    </div>
</div>
