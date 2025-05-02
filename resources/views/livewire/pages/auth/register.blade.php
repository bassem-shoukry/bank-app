<?php

use App\Models\Industry;
use App\Models\ParticipantType;
use App\Models\User;
use App\Models\Country;
use App\Models\City;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $date_of_birth = '';
    public $country_id = '';
    public $city_id = '';
    public $participant_type_id = '';
    public $industry_id = '';
    public $institution = '';
    public $countries = [];
    public $cities = [];
    public $participantTypes = [];
    public $industries = [];

    public function mount(): void
    {
        $this->countries = Country::all();
        $this->cities = collect();
        $this->participantTypes = ParticipantType::where('is_active', true)->get();
        $this->industries = Industry::all();
    }

    public function updatedCountryId($value): void
    {
        $this->cities = City::where('country_id', $value)
            ->get();
        $this->city_id = '';
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'city_id' => ['required', 'exists:cities,id'],
            'participant_type_id' => ['required', 'exists:participant_types,id'],
            'industry_id' => ['required', 'exists:industries,id'],
            'institution' => ['required', 'string', 'max:255'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required
                          autofocus autocomplete="name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')"/>
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required
                          autocomplete="username"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <!-- Date of Birth -->
        <div class="mt-4">
            <x-input-label for="date_of_birth" :value="__('Date of Birth')"/>
            <x-text-input wire:model="date_of_birth" id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" required/>
            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2"/>
        </div>

        <!-- Country -->
        <div class="mt-4">
            <x-input-label for="country_id" :value="__('Country')"/>
            <select wire:model.live="country_id" id="country_id" name="country_id"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required>
                <option value="">Select a Country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('country_id')" class="mt-2"/>
        </div>

        <!-- City -->
        <div class="mt-4">
            <x-input-label for="city_id" :value="__('City')"/>
            <select wire:model="city_id" id="city_id" name="city_id"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    {{ empty($country_id) ? 'disabled' : '' }} required>
                <option value="">Select a City</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('city_id')" class="mt-2"/>
        </div>

        <!-- Participant Type -->
        <div class="mt-4">
            <x-input-label for="participant_type_id" :value="__('Participant Type')" />
            <select wire:model="participant_type_id" id="participant_type_id" name="participant_type_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="">Select a Participant Type</option>
                @foreach($participantTypes as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('participant_type_id')" class="mt-2" />
        </div>

        <!-- Industry -->
        <div class="mt-4">
            <x-input-label for="industry_id" :value="__('Industry')" />
            <select wire:model="industry_id" id="industry_id" name="industry_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="">Select an Industry</option>
                @foreach($industries as $industry)
                    <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('industry_id')" class="mt-2" />
        </div>

        <!-- Institution -->
        <div class="mt-4">
            <x-input-label for="institution" :value="__('Institution')" />
            <x-text-input wire:model="institution" id="institution" class="block mt-1 w-full" type="text" name="institution" required />
            <x-input-error :messages="$errors->get('institution')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"/>
            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password"/>
            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password"/>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
               href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
