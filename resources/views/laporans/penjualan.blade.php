<x-layouts.app>
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('dashboard') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ $title }}</span>
    </div>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $title }}</h1>
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
            @if(auth()->user()->hasPermission('create-laporanpenjualans'))
            @if (($canCreate ?? true) !== false)
            <a href="{{ route('laporans.penjualan.create') }}">
                <x-button type="primary">{{ __('Create ' . $title) }}</x-button>
            </a>
            @endif
            @endif


        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <!-- Section Wrapper Form Filter -->
        <div class="p-5 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30">
            <form action="{{ route('laporans.penjualan') }}" method="get" id="filter-form">
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

                    <!-- Toko Select Group -->
                    <div class="flex-1">
                        <label for="toko" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5">
                            Toko
                        </label>
                        <div class="relative">
                            <select id="toko" name="toko" class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-500 transition-colors">
                                <option value="">Semua Toko</option>
                                @foreach($tokos as $toko)
                                <option value="{{ $toko->id }}" {{ request('toko') == $toko->id ? 'selected' : '' }}>
                                    {{ $toko->name }}
                                </option>
                                @endforeach
                            </select>
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
                untuk
                @if(request('toko'))
                toko <strong>{{ $tokos->firstWhere('id', request('toko'))->name ?? 'Terpilih' }}</strong>
                @else
                <strong>Semua Toko</strong>
                @endif
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-5">
            <div class="bg-blue-600 rounded-lg p-5 text-white shadow-sm">
                <p class="text-blue-100 text-sm font-medium uppercase">Total Omset</p>
                <h3 class="text-2xl font-bold mt-1">Rp {{ number_format($totalOmset, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-emerald-600 rounded-lg p-5 text-white shadow-sm">
                <p class="text-emerald-100 text-sm font-medium uppercase">Total Pendapatan</p>
                <h3 class="text-2xl font-bold mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>
        <h1 class="p-3 text-lg font-bold text-gray-800 dark:text-gray-100">Total Asset</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-5">
            <div class="bg-blue-600 rounded-lg p-5 text-white shadow-sm">
                <p class="text-blue-100 text-sm font-medium uppercase">Total Stok</p>
                <h3 class="text-2xl font-bold mt-1">{{ $totalStok }}</h3>
            </div>
            <div class="bg-emerald-600 rounded-lg p-5 text-white shadow-sm">
                <p class="text-emerald-100 text-sm font-medium uppercase">Total Aset</p>
                <h3 class="text-2xl font-bold mt-1">Rp {{ number_format($totalAsset, 0, ',', '.') }}</h3>
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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.tailwindcss.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    
</x-layouts.app>