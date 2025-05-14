<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Custom Styling -->
    <style>
        /* Base Select2 Styling */
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            min-height: 38px;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #6366f1;
            box-shadow: 0 0 0 1px rgba(99, 102, 241, 0.2);
        }
        .select2-dropdown {
            border-color: #d1d5db;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #e5e7eb;
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            padding: 2px 8px;
            margin-top: 4px;
        }

        /* Responsive Table */
        @media (max-width: 1024px) {
            .responsive-table {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .responsive-table table {
                width: 100%;
                min-width: 800px;
            }
        }

        /* Sizing for inputs and select2 */
        .select2-container--default .select2-selection--multiple,
        .select2-container--default .select2-selection--single {
            min-height: 45px !important;
            padding: 8px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            padding: 5px 10px !important;
            margin-top: 6px !important;
            font-size: 16px !important;
        }

        .select2-container--default .select2-results__option {
            padding: 8px 12px !important;
            font-size: 16px !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            padding: 8px !important;
            font-size: 16px !important;
        }

        /* Responsive utility classes */
        @media (max-width: 640px) {
            .sm-text-sm {
                font-size: 0.875rem !important;
            }
            .sm-px-2 {
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
            }
            .sm-py-2 {
                padding-top: 0.5rem !important;
                padding-bottom: 0.5rem !important;
            }
            .sm-flex-col {
                flex-direction: column !important;
            }
            .sm-w-full {
                width: 100% !important;
            }
            .sm-mt-2 {
                margin-top: 0.5rem !important;
            }
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    <livewire:layout.navigation />

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-full mx-auto py-4 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>
@livewireScripts
<livewire:wire-elements-modal />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@stack('scripts')
</body>
</html>
