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
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <script src="{{ asset('js/tailwind.js') }}"></script>

    <!-- Alpine.js CDN -->
    <!-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> -->
    <script src="{{ asset('js/alpine.min.js') }}" defer></script>


    <!-- FontAwesome CDN for Icons -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" /> -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" />

    <!-- tom select -->
    <link rel="stylesheet" href="{{ asset('css/tom-select.css') }}" />
    <script src="{{ asset('js/tom-select.complete.min.js') }}"></script>

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

<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex flex-col">
    <main class="flex-1 flex flex-col overflow-auto bg-gray-100 dark:bg-gray-900 content-transition h-full">
        <div class="p-5">



            <div class="grid grid-cols-2 mb-6">
                <div class="col-lg-6">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Kasir {{ $tokoNama }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('Transaksi') }}</p>

                </div>
                <div class="col-lg-6 text-gray-500 px-4 py-2 text-right">

                    <a href="{{ route('kasir.kasir_cekstok') }}">
                        <button class="btn px-2 text-blue-600 dark:text-blue-400 hover:underline">{{ __('Cek Stok') }}</button>
                    </a>
                    <a href="{{ route('kasir.kasir_cekpenjualan') }}">
                        <button class="btn px-2 text-blue-600 dark:text-blue-400 hover:underline">{{ __('History Penjualan') }}</button>
                    </a>
                    <a href="{{ route('kasir.kasir_ceklaporan') }}">
                        <button class="btn px-2 text-blue-600 dark:text-blue-400 hover:underline">{{ __('Laporan') }}</button>
                    </a>

                    <form action="{{ route('kasir.kasir_exittoko') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 ml-2" style="font-size: large;">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>

            {{-- Row 1: Add Product & Big Total Price --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="md:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Tambah Produk') }}
                        </label>
                        <select id="productSelect"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 dark:focus:border-indigo-400 dark:focus:ring-indigo-400/40 searchable-select">
                            @foreach($produks as $produk)
                            <option value="{{ $loop->index }}"
                                data-id="{{ $produk->id }}"
                                data-name="{{ $produk->name }}"
                                data-price="{{ $produk->harga_jual }}"
                                data-harga_beli="{{ $produk->harga_beli }}"
                                data-stok="{{ $produk->currentStok() }}"
                                data-unit="{{ $produk->satuan }}">
                                {{ $produk->name }} - {{ $produk->sku }}
                            </option>
                            @endforeach
                        </select>
                        <div class="flex gap-2 mt-3">
                            <input type="number" id="productQty" value="1" min="1"
                                class="w-24 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm text-center">
                            <button id="addProductBtn"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                                {{ __('Tambah ke keranjang') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 h-full flex flex-col">
                        <div class="">
                            <span class="text-gray-600 dark:text-gray-400 uppercase">{{ __('TOTAL HARGA') }}</span>
                            <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mt-2 text-right" id="bigTotalPrice">
                                Rp 0
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Row 2: Main Content - Cart Table (col-9) & Right Panel (col-3) --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-4">
                {{-- Cart Table - col-9 --}}
                <div class="lg:col-span-9">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

                        <div class="overflow-x-auto min-h-[450px]">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300 w-16">No</th>
                                        <th class="px-4 py-3 text-left text-gray-700 dark:text-gray-300">Product</th>
                                        <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">Harga</th>
                                        <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300 w-24">Kuantitas</th>
                                        <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300">Stok</th>
                                        <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300 w-24">Satuan</th>
                                        <th class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">Sub Total</th>
                                        <th class="px-4 py-3 text-center text-gray-700 dark:text-gray-300 w-16">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="cartTableBody">
                                    <tr>
                                        <td colspan="8" class="px-4 py-8 text-center text-gray-400 dark:text-gray-500">
                                            {{ __('Belum ada Item') }}
                                        </td>
                                    </tr>
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Right Panel - col-3 (stuff to add later) --}}
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                            {{ __('Garis Besar Transaksi') }}
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">{{ __('Subtotal') }}</span>
                                <span class="font-medium text-gray-800 dark:text-gray-200" id="subtotal">Rp 0</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">{{ __('Jumlah Diskon') }}</span>
                                <span class="font-medium text-red-600 dark:text-red-400" id="discountAmount">Rp 0</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold pt-2 border-t border-gray-200 dark:border-gray-700">
                                <span class="text-gray-800 dark:text-gray-200">{{ __('Total') }}</span>
                                <span class="text-blue-600 dark:text-blue-400" id="total">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Row 3: Discount Input, Payment Method, and Process Button --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                <div class="lg:col-span-9">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                        <div class="flex flex-wrap gap-4 items-end">
                            <div class="flex-1 min-w-[150px]">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Diskon (%)') }}
                                </label>
                                <input type="number" id="discountPercent" value="0" min="0" max="100" step="1"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                            </div>
                            <div class="flex-1 min-w-[200px]">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Metode Pembayaran') }}
                                </label>
                                <select id="paymentMethod"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                                    @foreach($tipe_pembayarans as $tipe_pembayaran)
                                    <option value="{{ $tipe_pembayaran->id }}" data-name="{{ $tipe_pembayaran->name }}">
                                        {{ $tipe_pembayaran->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-1 min-w-[150px]">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Jumlah Pembayaran') }}
                                </label>
                                <input type="number" id="paymentAmount" placeholder="Payment amount"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                            </div>
                            <div class="flex-1 min-w-[100px]">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Kembalian') }}
                                </label>
                                <div class="px-3 py-2 bg-gray-100 dark:bg-gray-900 rounded-md text-right font-bold text-green-600 dark:text-green-400" id="changeAmount">
                                    Rp 0
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <button id="processPaymentBtn"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 text-lg h-full">
                        {{ __('Process Pembayaran') }}
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Choices.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <!-- Choices.js JS -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <style>
        /* Choices.js Custom Wrapper Styles */
        .choices__inner {
            min-height: 42px;
            border-radius: 0.5rem;
            border-color: rgb(209 213 219) !important;
            background: rgb(255 255 255) !important;
            padding: 0.25rem 0.75rem !important;
        }

        .dark .choices__inner {
            border-color: rgb(75 85 99) !important;
            background: rgb(17 24 39) !important;
        }

        .dark .choices__item--selectable{
            color: rgb(255 255 255);
        }



        .choices__input {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: left 0.75rem center !important;
            background-size: 1.1rem !important;
            padding-left: 2.25rem !important;
            /* Shims text to the right of the icon */
            background-color: transparent !important;
            color: rgb(17 24 39) !important;
        }


        .dark .choices__input {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23f3f4f6' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/%3E%3C/svg%3E") !important;
            color: rgb(243 244 246) !important;

        }

        .choices__list--dropdown {
            border-radius: 0.5rem;
            border-color: rgb(75 85 99) !important;
            background: rgb(255 255 255) !important;
            color: rgb(17 24 39) !important;
            z-index: 20;
        }

        .dark .choices__list--dropdown {
            background: rgb(31, 41, 55) !important;
            color: rgb(243 244 246) !important;
        }

        .choices__list--dropdown .choices__item--selectable.is-highlighted {
            background-color: rgb(30 64 175) !important;
            color: #fff !important;
        }

        /* Match template placeholder styling */
        .choices__placeholder {
            opacity: 1;
            color: rgb(107 114 128);
        }

        .dark .choices__placeholder {
            color: rgb(156 163 175);
        }

        .dark .is-selected {
            background-color: rgb(30 64 175) !important;
            color: #fff !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productSelect = document.getElementById('productSelect');

            if (productSelect) {
                const choices = new Choices(productSelect, {
                    searchEnabled: true,
                    removeItemButton: true,
                    itemSelectText: '',
                    noResultsText: 'Produk tidak ditemukan',
                    placeholder: true,
                    placeholderValue: 'Cari atau Pilih Product',
                    shouldSort: false,
                    classNames: {
                        containerOuter: 'choices',
                        containerInner: 'choices__inner',
                        input: 'choices__input',
                        inputCloned: 'choices__input--cloned',
                        list: 'choices__list',
                        listItems: 'choices__list--multiple',
                        listSingle: 'choices__list--single',
                        listDropdown: 'choices__list--dropdown',
                        item: 'choices__item',
                        itemSelectable: 'choices__item--selectable',
                        itemDisabled: 'choices__item--disabled',
                        itemChoice: 'choices__item--choice',
                        placeholder: 'choices__placeholder',
                        group: 'choices__group',
                        groupHeading: 'choices__heading'
                    }

                });

                // Auto-focus logic when an item is selected
                productSelect.addEventListener('change', function(event) {
                    if (event.detail.value) {
                        document.getElementById('productQty').focus();
                    }
                });
            }
        });
    </script>


    <script>
        // Cart state
        let cart = [];
        let nextId = 1;

        // DOM Elements
        const productSelect = document.getElementById('productSelect');
        const productQty = document.getElementById('productQty');
        const addProductBtn = document.getElementById('addProductBtn');
        const cartTableBody = document.getElementById('cartTableBody');
        const subtotalEl = document.getElementById('subtotal');
        const discountAmountEl = document.getElementById('discountAmount');
        const totalEl = document.getElementById('total');
        const bigTotalPrice = document.getElementById('bigTotalPrice');
        const discountPercentInput = document.getElementById('discountPercent');
        const paymentMethodSelect = document.getElementById('paymentMethod');
        const paymentAmountInput = document.getElementById('paymentAmount');
        const changeAmountEl = document.getElementById('changeAmount');

        // Helper: Format Rupiah
        function formatRupiah(amount) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
        }

        // Calculate totals
        function calculateTotals() {
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const discountPercent = parseFloat(discountPercentInput.value) || 0;
            const discountAmount = subtotal * (discountPercent / 100);
            const total = subtotal - discountAmount;

            subtotalEl.textContent = formatRupiah(subtotal);
            discountAmountEl.textContent = formatRupiah(discountAmount);
            totalEl.textContent = formatRupiah(total);
            bigTotalPrice.textContent = formatRupiah(total);

            return {
                subtotal,
                discountAmount,
                total,
                discountPercent
            };
        }

        // Calculate change
        function calculateChange() {
            const totalText = totalEl.textContent.replace(/[^0-9]/g, '');
            const total = parseInt(totalText) || 0;
            const payment = parseInt(paymentAmountInput.value) || 0;
            const change = payment - total;
            changeAmountEl.textContent = formatRupiah(change > 0 ? change : 0);
            return {
                total,
                payment,
                change
            };
        }

        // Update cart table
        function updateCartTable() {
            if (cart.length === 0) {
                cartTableBody.innerHTML = `
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-400 dark:text-gray-500">
                            {{ __('No items added yet') }}
                        </td>
                    </tr>
                `;
                calculateTotals();
                calculateChange();
                return;
            }

            console.log(cart);

            let html = '';
            cart.forEach((item, index) => {
                const subTotal = item.price * item.quantity;
                html += `
                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">${index + 1}</td>
                        <td class="px-4 py-3 font-medium text-gray-800 dark:text-gray-200">${item.name}</td>
                        <td class="px-4 py-3 text-right text-gray-700 dark:text-gray-300">${formatRupiah(item.price)}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="adjustQuantity(${index}, -1)" 
                                    class="w-6 h-6 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600">-</button>
                                <span class="w-10 text-center text-gray-800 dark:text-gray-200">${item.quantity}</span>
                                <button onclick="adjustQuantity(${index}, 1)" 
                                    class="w-6 h-6 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600">+</button>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center text-gray-600 dark:text-gray-400">${item.stok}</td>
                        <td class="px-4 py-3 text-center text-gray-600 dark:text-gray-400">${escapeHtml(item.unit)}</td>
                        <td class="px-4 py-3 text-right font-medium text-gray-800 dark:text-gray-200">${formatRupiah(subTotal)}</td>
                        <td class="px-4 py-3 text-center">
                            <button onclick="removeFromCart(${index})" 
                                class="text-red-500 hover:text-red-700 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                `;
            });

            cartTableBody.innerHTML = html;
            calculateTotals();
            calculateChange();
        }

        // Adjust quantity
        window.adjustQuantity = function(index, delta) {
            if (cart[index]) {
                if (cart[index].quantity + delta > cart[index].stok) {
                    alert('Stok tidak cukup untuk menambahkan lebih banyak item ini.');
                    return;
                }
                const newQty = cart[index].quantity + delta;
                if (newQty <= 0) {
                    removeFromCart(index);
                } else {
                    cart[index].quantity = newQty;
                    updateCartTable();
                }
            }
        };

        // Remove from cart
        window.removeFromCart = function(index) {
            cart.splice(index, 1);
            updateCartTable();
        };

        // Add product to cart
        function addToCart(id, name, price, harga_beli, qty, unit, stok) {
            const existing = cart.find(item => item.name === name && item.price === price);
            if (existing) {
                if (existing.quantity + qty > existing.stok) {
                    alert('Stok tidak cukup untuk menambahkan lebih banyak item ini.');
                    return;
                }
                existing.quantity += qty;
            } else {

                if (qty > stok) {
                    alert('Stok tidak cukup untuk menambahkan item ini.');
                }
                qty = Math.min(qty, stok); // Ensure qty does not exceed stok

                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    harga_beli: harga_beli,
                    unit: unit,
                    quantity: qty,
                    stok: stok
                });
            }
            updateCartTable();
        }

        // Add product button click
        addProductBtn.addEventListener('click', () => {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            if (!productSelect.value) {
                alert('Please select a product.');
                return;
            }
            const id = selectedOption.dataset.id;
            const name = selectedOption.dataset.name;
            const price = parseInt(selectedOption.dataset.price);
            const harga_beli = parseInt(selectedOption.dataset.harga_beli);
            const unit = selectedOption.dataset.unit;
            const stok = parseInt(selectedOption.dataset.stok);
            let qty = parseInt(productQty.value);


            if (isNaN(qty) || qty < 1) {
                qty = 1;
            }

            
            addToCart(id, name, price, harga_beli, qty, unit, stok);
            

            productSelect.value = '';
            productQty.value = '1';
        });

        // Enter key on product qty
        productQty.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                addProductBtn.click();
            }
        });

        // Discount input event
        discountPercentInput.addEventListener('input', function() {
            let value = parseInt(this.value) || 0;
            if (value < 0) this.value = 0;
            if (value > 100) this.value = 100;
            updateCartTable();
        });

        // Payment amount input event
        paymentAmountInput.addEventListener('input', calculateChange);

        // Process payment
        document.getElementById('processPaymentBtn').addEventListener('click', () => {
            if (cart.length === 0) {
                alert('Cart Kosong. Tambahkan beberapa produk terlebih dahulu.');
                return;
            }

            const paymentMethodSelect = document.getElementById('paymentMethod');


            const paymentMethodId = paymentMethodSelect.value;
            const paymentMethodName = paymentMethodSelect.options[paymentMethodSelect.selectedIndex]?.dataset.name || '';

            if (!paymentMethodId) {
                alert('Silakan pilih metode pembayaran.');
                paymentMethodSelect.focus();
                return;
            }

            const {
                total,
                payment,
                change
            } = calculateChange();
            if (payment < total) {
                alert('Pembayaran tidak cukup. Masukkan jumlah yang lebih besar atau sama dengan total.');
                return;
            }

            const subtotalText = subtotalEl.textContent.replace(/[^0-9]/g, '');
            const subtotal = parseInt(subtotalText) || 0;
            const discountPercent = parseFloat(document.getElementById('discountPercent').value) || 0;
            const discountAmount = subtotal * (discountPercent / 100);
            const totalAfterDiscount = subtotal - discountAmount;

            // Create a form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("kasir.kasir_processpayment") }}';

            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            // Add form data
            const formData = {
                subtotal_before_discount: subtotal,
                subtotal_after_discount: totalAfterDiscount,
                discount_percent: discountPercent,
                discount_amount: discountAmount,
                total_payment: totalAfterDiscount,
                payment_method_id: paymentMethodId,
                payment_amount: payment,
                change_amount: change,
                cart_items: JSON.stringify(cart.map(item => ({
                    id: item.id,
                    name: item.name,
                    price: item.price,
                    harga_beli: item.harga_beli,
                    quantity: item.quantity,
                    unit: item.unit,
                    stok: item.stok,
                    total: item.price * item.quantity
                })))
            };

            for (const [key, value] of Object.entries(formData)) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                form.appendChild(input);
            }

            document.body.appendChild(form);
            form.submit();


        });



        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        // Initialize
        updateCartTable();
    </script>
    @include('kasir.paymentsuccessmodal')

</body>