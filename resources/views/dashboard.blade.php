<x-layouts.app>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Dashboard')}}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('Welcome to the dashboard') }}</p>
    </div>

    <div class="">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
            {{ __('Welcome back,') }} {{ auth()->user()->name ?? 'Guest' }}!
        </h1>
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-2 gap-6 p-5">

            @foreach($tokos as $toko)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col justify-between">

                <div class="p-5 border-b border-gray-100 dark:border-gray-700/50 bg-gradient-to-r from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white tracking-tight">
                                {{ $toko->name }}
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="truncate max-w-[200px] sm:max-w-xs">{{ $toko->alamat ?? 'Alamat tidak tersedia' }}</span>
                            </p>
                        </div>

                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 dark:bg-blue-950/40 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-900 uppercase">
                            {{ $toko->status_toko ?? 'Cabang' }}
                        </span>
                    </div>
                </div>

                <div class="p-5 flex-grow">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-rose-600 dark:text-rose-400 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                            Stok Menipis
                        </span>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">
                            {{ count($toko->produk_menipis) }} Produk
                        </span>
                    </div>

                    @if(count($toko->produk_menipis) > 0)
                    <div class="space-y-2.5 max-h-[220px] overflow-y-auto pr-1 custom-scrollbar">
                        @foreach($toko->produk_menipis as $produk)
                        <div class="flex items-center justify-between p-3 rounded-lg bg-rose-50/50 dark:bg-rose-950/10 border border-rose-100 dark:border-rose-950/40 hover:border-rose-200 transition-colors">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 ">
                                {{ $produk->name }}
                            </span>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2 py-0.5 rounded font-mono text-xs font-bold bg-rose-100 dark:bg-rose-900/50 text-rose-700 dark:text-rose-300">
                                    Sisa: {{ $produk->current_stok }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="flex flex-col items-center justify-center py-6 text-center bg-teal-50/30 dark:bg-teal-950/5 rounded-lg border border-dashed border-teal-200 dark:border-teal-900/50">
                        <svg class="w-8 h-8 text-teal-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-xs font-semibold text-teal-700 dark:text-teal-400">Semua Stok Aman</p>
                    </div>
                    @endif
                </div>

                

            </div>
            @endforeach

        </div>


    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #475569;
        }
    </style>

</x-layouts.app>