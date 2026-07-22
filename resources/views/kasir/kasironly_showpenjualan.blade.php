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
                        class="text-blue-600 dark:text-blue-400 hover:underline">Kasir UI</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <a href="{{ route('kasir.kasir_cekpenjualan') }}"
                        class="text-blue-600 dark:text-blue-400 hover:underline">History Penjualan</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-gray-500 dark:text-gray-400">Detail Penjualan</span>
                </div>

                <div class="col-lg-6  text-gray-500 px-4 py-2 text-right">
                    <a href="{{ route('kasir.kasir_cekpenjualan') }}">
                        <button class="btn text-blue-600 dark:text-blue-400 hover:underline">{{ __('Kembali') }}</button>
                    </a>

                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 border-b border-gray-100 dark:border-gray-700 pb-6">
                        <div>
                            <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-4">Informasi Penjualan</h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">No. Invoice</label>
                                    <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $penjualan->no_invoice }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Customer</label>
                                    <div class="text-md font-semibold text-gray-900 dark:text-gray-100">{{ $penjualan->customer->nama ?? $penjualan->customer_id ?? '-' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Toko</label>
                                    <div class="text-md font-semibold text-gray-900 dark:text-gray-100">{{ $penjualan->toko->name ?? '-' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tanggal Transaksi</label>
                                    <div class="text-md font-semibold text-gray-900 dark:text-gray-100">{{ $penjualan->created_at->format('d F Y H:i') }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tipe Pembayaran</label>
                                    <div class="text-md font-semibold text-gray-900 dark:text-gray-100">{{ $penjualan->tipePembayaran->name ?? '-' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Keterangan</label>
                                    <div class="text-md text-gray-900 dark:text-gray-100">{{ $penjualan->keterangan ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg border border-gray-100 dark:border-gray-700">
                            <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase mb-4">Ringkasan Pembayaran</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between ">
                                    <span class="text-gray-500">Total Pembelian:</span>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100">Rp {{ number_format($penjualan->total_pembelian, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Diskon:</span>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100">
                                        @if($penjualan->diskon_percentage > 0)
                                        {{ number_format($penjualan->diskon_percentage, 0) }}%
                                        (Rp {{ number_format($penjualan->diskon_nominal, 0, ',', '.') }})
                                        @else
                                        Rp {{ number_format($penjualan->diskon_nominal, 0, ',', '.') }}
                                        @endif
                                    </span>
                                </div>
                                <div class="flex justify-between  text-xl border-t border-b border-gray-200 dark:border-gray-700 pt-2 mt-2">
                                    <span class="font-bold text-gray-700 dark:text-gray-300">Total Harus Dibayar:</span>
                                    <span class="font-black text-green-600 dark:text-green-400">Rp {{ number_format($penjualan->total_harus_dibayar, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Dibayar:</span>
                                    <span class="font-semibold text-gray-500 dark:text-gray-100">Rp {{ number_format($penjualan->dibayar, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Kembalian:</span>
                                    <span class="font-semibold text-indigo-600 dark:text-indigo-400">Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-4">Daftar Produk</h3>
                        <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th class="px-4 py-3">Nama Produk</th>
                                        
                                        <th class="px-4 py-3 text-center">Jumlah</th>
                                        <th class="px-4 py-3 text-center">Satuan</th>
                                        <th class="px-4 py-3 text-center">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($penjualan->details as $detail)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                            {{ $detail->produk->name ?? $detail->produk_id }}
                                        </td>
                                        
                                        <td class="px-4 py-3 text-center">
                                            {{ number_format($detail->jumlah, 0) }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            {{ $detail->satuan }}
                                        </td>
                                        <td class="px-4 py-3 text-center font-semibold text-gray-900 dark:text-white">
                                            Rp {{ number_format($detail->sub_total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50 dark:bg-gray-700">
                                    <tr class="font-semibold text-gray-900 dark:text-white">
                                        <td class="px-4 py-3 text-right" colspan="2">Total:</td>
                                        <td class="px-4 py-3 text-center">{{ number_format($penjualan->details->sum('jumlah'), 0) }}</td>
                                        <td class="px-4 py-3 text-center font-bold">
                                            Rp {{ number_format($penjualan->details->sum('sub_total'), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
</body>

</html>