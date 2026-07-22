<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    <!-- Dynamic Favicon -->
    @php
    $appName = config('app.name', 'App');
    $initials = collect(explode(' ', $appName))
    ->map(fn($word) => strtoupper(substr($word, 0, 1)))
    ->take(3)
    ->implode('');
    @endphp
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,
        %3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E
            %3Crect width='100' height='100' rx='20' fill='%232563eb'/%3E
            %3Ctext x='50' y='50' text-anchor='middle' dy='0.35em' font-family='Arial, sans-serif' font-size='45' font-weight='bold' fill='white'%3E{{ $initials }}%3C/text%3E
        %3C/svg%3E">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- FontAwesome CDN for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        sidebar: {
                            DEFAULT: '#ffffff',
                            foreground: '#1f2937'
                        }
                    }
                }
            }
        }
    </script>

    <!-- Custom Styles -->
    <style>
        .sidebar-transition {
            transition: width 0.3s ease;
        }

        .content-transition {
            transition: margin-left 0.3s ease;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4b5563;
        }

        .dark .bg-sidebar {
            background-color: #1f2937;
        }

        .dark .text-sidebar-foreground {
            color: #f3f4f6;
        }
    </style>

    <script>
        window.setAppearance = function(appearance) {
            let setDark = () => document.documentElement.classList.add('dark')
            let setLight = () => document.documentElement.classList.remove('dark')
            let setButtons = (appearance) => {
                document.querySelectorAll('button[onclick^="setAppearance"]').forEach((button) => {
                    button.setAttribute('aria-pressed', String(appearance === button.value))
                })
            }
            if (appearance === 'system') {
                let media = window.matchMedia('(prefers-color-scheme: dark)')
                window.localStorage.removeItem('appearance')
                media.matches ? setDark() : setLight()
            } else if (appearance === 'dark') {
                window.localStorage.setItem('appearance', 'dark')
                setDark()
            } else if (appearance === 'light') {
                window.localStorage.setItem('appearance', 'light')
                setLight()
            }
            if (document.readyState === 'complete') {
                setButtons(appearance)
            } else {
                document.addEventListener("DOMContentLoaded", () => setButtons(appearance))
            }
        }
        window.setAppearance(
            "{{ auth()->user()->theme_preference ?? '' }}" ||
            window.localStorage.getItem('appearance') ||
            'system'
        )
    </script>
</head>

<body>
    <main class="flex-1 flex flex-col overflow-auto bg-gray-100 dark:bg-gray-900 content-transition h-screen">
        <div class="p-5">
            <div class="grid grid-cols-2 mb-6">

                <div class="mb-6 flex items-center text-sm">
                    <a href="{{ route('kasir.kasir_dashboard') }}"
                        class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Kasir UI') }}</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-gray-500 dark:text-gray-400">Laporan Toko</span>
                </div>
                <div class="col-lg-6  text-gray-500 px-4 py-2 text-right">
                    <a href="{{ route('kasir.kasir_dashboard') }}">
                        <button class="btn text-blue-600 dark:text-blue-400 hover:underline">{{ __('Kembali') }}</button>
                    </a>

                </div>
            </div>

            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Laporan Toko</h1>
                </div>
                <div class="flex gap-2">
                    @if(auth()->user()->hasPermission('view-laporanpenjualans'))
                    <a href="{{ route('laporans.penjualan.export', request()->all()) }}">
                        <x-button type="secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            {{ __('Download Excel') }}
                        </x-button>
                    </a>
                    @endif



                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Section Wrapper Form Filter -->
                <div class="p-5 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30">
                    <form action="{{ route('kasir.kasir_ceklaporan') }}" method="get" id="filter-form">
                        <div class="flex flex-col sm:flex-row sm:items-end gap-4 max-w-3xl">
                            <!-- Start Date Group -->
                            <div class="flex-1">
                                <label for="startdate" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5">
                                    Tanggal Mulai
                                </label>
                                <div class="relative">
                                    <input type="date" id="startdate" name="startdate"
                                        value="{{ $startdate }}"
                                        class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-500 transition-colors">
                                </div>
                            </div>

                            <!-- End Date Group -->
                            <div class="flex-1">
                                <label for="enddate" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5">
                                    Tanggal Selesai
                                </label>
                                <div class="relative">
                                    <input type="date" id="enddate" name="enddate"
                                        value="{{ $enddate }}"
                                        class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-500 transition-colors">
                                </div>
                            </div>




                            <!-- Action Buttons -->
                            <div class="flex items-center gap-2 pt-2 sm:pt-0">
                                <button type="submit"
                                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-all cursor-pointer h-[38px]">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 8.293A1 1 0 013 7.586V4z" />
                                    </svg>
                                    Filter
                                </button>

                                @if(request('startdate') || request('enddate') || request('toko'))
                                <a href="{{ route('laporans.penjualan') }}"
                                    class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none transition-all h-[38px]">
                                    Reset
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Current Filter Info Status -->
                <div class="px-5 py-3 bg-blue-50/50 dark:bg-blue-950/20 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>
                        Menampilkan data
                        dari <strong>{{ \Carbon\Carbon::parse($startdate)->translatedFormat('d M Y') }}</strong> sampai <strong>{{ \Carbon\Carbon::parse($enddate)->translatedFormat('d M Y') }}</strong>

                    </span>
                </div>

                <div class="p-5">
                    <div class="bg-blue-600 rounded-lg p-5 text-white shadow-sm">
                        <p class="text-blue-100 text-sm font-medium uppercase">Total Omset</p>
                        <h3 class="text-2xl font-bold mt-1">Rp {{ number_format($totalOmset, 0, ',', '.') }}</h3>
                    </div>
                    
                </div>
                <div class="p-5">
                    <div class="bg-blue-600 rounded-lg p-5 text-white shadow-sm">
                        <p class="text-blue-100 text-sm font-medium uppercase">Total Stok</p>
                        <h3 class="text-2xl font-bold mt-1">{{ $totalStok }}</h3>
                    </div>
                    
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-5 pb-5">
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 rounded-lg">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Jumlah Transaksi</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-gray-100">{{ $jumlahTransaksi }}</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 rounded-lg">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Barang Terjual</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-gray-100">{{ $totalBarangTerjual }}</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 rounded-lg">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Stok Habis</p>
                        <p class="text-lg font-bold text-red-600">{{ $stokHabisCount }}</p>
                    </div>
                </div>

            </div>
        </div>
    </main>
</body>

</html>