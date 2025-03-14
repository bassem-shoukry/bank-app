<div>
    @if($success)
        <div class="alert alert-success mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <p>Thank you for your message! We'll get back to you shortly.</p>
        </div>
    @endif

    <form wire:submit="submit">
        <div class="mb-4">
            <input type="text" class="w-full px-4 py-3 text-base border rounded @error('name') border-red-500 @enderror"
                   wire:model="name" placeholder="Name">
            @error('name')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <input type="email" class="w-full px-4 py-3 text-base border rounded @error('email') border-red-500 @enderror"
                   wire:model="email" placeholder="Email">
            @error('email')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <textarea class="w-full px-4 py-3 text-base border rounded @error('message') border-red-500 @enderror"
                      rows="6" wire:model="message" placeholder="Message"></textarea>
            @error('message')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <button type="submit"
                    class="w-full px-6 py-3 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 border border-blue-600 rounded shadow-md transition duration-200"
                    wire:loading.attr="disabled"
                    style="background-color: #1D4ED8; color: #fff !important;">
    <span wire:loading wire:target="submit">
        <i class="fa fa-spinner fa-spin"></i> Sending...
    </span>
                <span wire:loading.remove wire:target="submit">
        Send Message
    </span>
            </button>
        </div>
    </form>
</div>
