<x-layouts.app>
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('dashboard') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('produks.index') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">Produk</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('View') }}</span>
    </div>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">View Produk</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Produk details</p>
        </div>
        <div class="flex gap-2">
            @if(auth()->user()->hasPermission('edit-produks'))
            <a href="{{ route('produks.edit', $produk) }}">
                <x-button type="primary">{{ __('Edit') }}</x-button>
            </a>
            @endif
            <a href="{{ route('produks.index') }}">
                <x-button type="secondary">{{ __('Kembali') }}</x-button>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nama Produk
                    </label>
                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $produk->name }}
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        SKU
                    </label>
                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $produk->sku }}
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Toko
                    </label>
                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $produk->toko->name ?? $produk->toko }}
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Kategori
                    </label>
                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $produk->kategori->name ?? $produk->kategori }}
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Harga Beli
                    </label>
                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ number_format($produk->harga_beli, 0, ',', '.') }}
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Harga Jual
                    </label>
                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ number_format($produk->harga_jual, 0, ',', '.') }}
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Satuan
                    </label>
                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $produk->satuan }}
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Batas Bawah
                    </label>
                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $produk->batas_bawah }}
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden self-start">
            <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Kelola Stok Produk
                </h3>
            </div>

            <form action="{{ route('produks.tambahstokstore', $produk) }}" method="POST">
                @csrf
                <div class="p-6 space-y-5">

                    <div class="bg-blue-50 dark:bg-blue-950/40 p-4 rounded-lg border border-blue-200 dark:border-blue-900 flex justify-between items-center">
                        <div>
                            <p class="text-xs text-blue-600 dark:text-blue-400 font-medium uppercase tracking-wider">Stok Saat Ini</p>
                            <p class="text-2xl font-black text-gray-800 dark:text-gray-100 mt-1">
                                {{ $produk->currentStok() }}
                            </p>
                        </div>
                        <span class="text-sm font-semibold bg-blue-100 dark:bg-blue-900/60 text-blue-800 dark:text-blue-300 px-3 py-1 rounded-md">
                            {{ $produk->satuan ?? 'Pcs' }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipe Transaksi</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center justify-center p-3 border rounded-lg cursor-pointer transition-all border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50 dark:has-[:checked]:bg-teal-950/30 has-[:checked]:text-teal-700 dark:has-[:checked]:text-teal-400 font-medium">
                                <input type="radio" name="tipe" value="IN" class="sr-only" checked>
                                Stok Masuk (IN)
                            </label>
                            <label class="flex items-center justify-center p-3 border rounded-lg cursor-pointer transition-all border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50 dark:has-[:checked]:bg-rose-950/30 has-[:checked]:text-rose-700 dark:has-[:checked]:text-rose-400 font-medium">
                                <input type="radio" name="tipe" value="OUT" class="sr-only">
                                Stok Keluar (OUT)
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah</label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <input type="number" min="1" name="jumlah" id="jumlah" required class="block w-full rounded-lg border-gray-300 dark:border-gray-600 pl-4 pr-16 py-2.5 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Masukkan jumlah...">
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                                <span class="text-gray-500 dark:text-gray-400 sm:text-sm font-semibold bg-gray-100 dark:bg-gray-600 px-2.5 py-1 rounded">
                                    {{ $produk->satuan ?? 'Pcs' }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                    <button type="submit" class="w-full sm:w-auto inline-flex justify-center rounded-lg border border-transparent shadow-sm px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-layouts.app>