<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact Us') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- CONTACT SECTION -->
                    <section id="contact">
                        <div class="mb-8">
                            <h2 class="text-3xl font-bold mb-3">Get in touch</h2>
                            <p class="text-gray-600">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
                        </div>

                        <div class="flex flex-col md:flex-row md:space-x-8">
                            <!-- CONTACT FORM - 6 columns -->
                            <div class="w-full md:w-1/2 mb-8 md:mb-0">
                                <livewire:contact-form />
                            </div>

                            <!-- CONTACT INFO - 6 columns -->
                            <div class="w-full md:w-1/2">
                                <div class="bg-gray-50 p-6 rounded-lg h-full">
                                    <h2 class="text-2xl font-bold mb-4">Contact Info</h2>
                                    <p class="text-gray-600 mb-6">Feel free to reach out to us through any of the channels below.</p>

                                    <div class="space-y-4">
                                        <p class="flex items-start">
                                            <i class="fa fa-map-marker mt-1 mr-6 text-black"></i>
                                            <span>456 New Street 22000, New York City, USA</span>
                                        </p>
                                        <p class="flex items-start">
                                            <i class="fa fa-envelope mt-1 mr-6 text-black"></i>
                                            <a href="mailto:info@company.com" class="text-blue-600 hover:text-blue-800">info@company.com</a>
                                        </p>
                                        <p class="flex items-start">
                                            <i class="fa fa-phone mt-1 mr-6 text-black"></i>
                                            <span>010-020-0340</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
