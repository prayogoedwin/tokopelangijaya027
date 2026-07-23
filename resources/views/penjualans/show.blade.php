<x-layouts.app>
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('dashboard') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route($tablename . '.index') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ $title }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('View') }}</span>
    </div>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">View {{ $title }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $title }} details</p>
        </div>
        <div class="flex gap-2">
            @if(auth()->user()->hasPermission('edit-' . $tablename))
            <a href="{{ route($tablename . '.edit', $penjualan->id) }}">
                <x-button type="primary">{{ __('Edit Penjualan') }}</x-button>
            </a>
            @endif
            <a href="{{ route($tablename . '.cetaknota', $penjualan->id) }}">
                <x-button type="warning">{{ __('Cetak') }}</x-button>
            </a>
            <a href="{{ route($tablename . '.index') }}">
                <x-button type="secondary">{{ __('Kembali') }}</x-button>
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
                                <th class="px-4 py-3 text-center">Harga Beli</th>
                                <th class="px-4 py-3 text-center">Harga Jual</th>
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
                                    Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    Rp {{ number_format($detail->harga_jual, 0, ',', '.') }}
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
                                <td class="px-4 py-3 text-right" colspan="4">Total:</td>
                                <td class="px-4 py-3 text-center">{{ number_format($penjualan->details->sum('jumlah'), 0) }}</td>
                                <td class="px-4 py-3 text-center font-bold">
                                    Rp {{ number_format($penjualan->details->sum('sub_total'), 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="mt-8 flex gap-3">
                <a href="{{ route($tablename . '.index') }}">
                    <x-button type="primary">Kembali ke Daftar</x-button>
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>