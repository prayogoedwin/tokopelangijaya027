<x-layouts.app>
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('dashboard') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('Kasir POS') }}</span>
    </div>

    <div class="grid grid-cols-2 mb-6">
        <div class="col-lg-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Kasir {{ $tokoNama }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('Transaksi') }}</p>

        </div>
        <div class="col-lg-6 text-xs text-gray-500 px-4 py-2 text-right">

            <form action="{{ route('kasir.exittoko') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-700 ml-2" style="font-size: large;">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </div>




    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col h-[800px]">
            {{-- Cart Header --}}
            <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                <h2 class="font-semibold text-gray-800 dark:text-gray-200">{{ __('Keranjang') }}</h2>
            </div>

            {{-- Cart Items List (Scrollable) --}}
            <div class="flex-1 overflow-y-auto p-4 space-y-3" id="cartItems">
                <p class="text-center text-gray-400 dark:text-gray-500 text-sm py-8">{{ __('Belum ada Item') }}</p>
            </div>

            {{-- Cart Summary & Invoice Preview --}}
            <div class="border-t border-gray-200 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-900">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('Subtotal') }}</span>
                        <span class="font-medium text-gray-800 dark:text-gray-200" id="subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('Diskon') }}</span>
                        <div class="flex items-center gap-2">
                            <input type="number" id="discountPercent" value="0" min="0" max="100" step="1"
                                class="w-20 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                            <span class="text-gray-600 dark:text-gray-400">%</span>
                        </div>
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

                <!-- Rest of the payment section remains the same -->
                <div class="mt-4 space-y-2">
                    {{-- Payment Method Select --}}
                    <div class="flex justify-between items-center gap-2">
                        <span class="text-gray-600 dark:text-gray-400 text-sm">{{ __('Metode Pembayaran') }}</span>
                        <select id="paymentMethod"
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                            @foreach($tipe_pembayarans as $tipe_pembayaran)
                            <option value="{{ $tipe_pembayaran->id }}" data-name="{{ $tipe_pembayaran->name }}">
                                {{ $tipe_pembayaran->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <input type="number" id="paymentAmount" placeholder="Payment amount"
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                        <button id="calculateChangeBtn"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 text-sm font-medium transition">{{ __('Hitung Kembalian') }}</button>
                    </div>

                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('Kembalian') }}</span>
                        <span class="font-bold text-green-600 dark:text-green-400" id="changeAmount">Rp 0</span>
                    </div>
                </div>

                <div class="mt-4 flex gap-2">
                    <button id="processPaymentBtn"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-200">
                        {{ __('Process Pembayaran') }}
                    </button>
                    <button id="clearCartBtn"
                        class="px-4 py-2 border border-red-300 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md text-sm font-medium transition">
                        {{ __('Bersihkan') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Product Grid --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="font-semibold text-gray-800 dark:text-gray-200">{{ __('Produk') }}</h2>
                <input type="text" id="searchProduct" placeholder="Search product..." class="mt-2 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
            </div>
            <div class="p-4">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 max-h-[600px] overflow-y-auto">
                    @forelse($produks as $produk)
                    <button type="button"
                        class="product-item text-left p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200"
                        data-id="{{ $produk->id }}"
                        data-name="{{ $produk->name }}"
                        data-price="{{ $produk->harga_jual }}"
                        data-harga_beli="{{ $produk->harga_beli }}"
                        data-unit="{{ $produk->satuan }}"
                        data-stok="{{ $produk->currentStok() }}"
                        data-index="{{ $loop->index }}"> {{-- Mengubah data-id ganda menjadi data-index --}}

                        <div class="font-medium text-gray-800 dark:text-gray-200 text-sm">{{ $produk->name }}</div>
                        <div class="text-blue-600 dark:text-blue-400 font-bold mt-1">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</div>

                        <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400 mt-1">
                            <span>Satuan: {{ $produk->satuan }}</span>
                            {{-- Menampilkan Stok Saat Ini --}}
                            <span class="font-semibold {{ $produk->currentStok() <= 0 ? 'text-red-500' : 'text-green-600 dark:text-green-400' }}">
                                Stok: {{ $produk->currentStok() }}
                            </span>
                        </div>
                    </button>
                    @empty
                    <p class="col-span-full text-center text-gray-500 dark:text-gray-400 py-8">{{ __('No products available.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Cart & Invoice --}}

    </div>




    <script>
        // Cart state
        let cart = [];

        // DOM Elements
        const cartContainer = document.getElementById('cartItems');
        const subtotalEl = document.getElementById('subtotal');
        const taxEl = document.getElementById('tax');
        const totalEl = document.getElementById('total');
        const paymentInput = document.getElementById('paymentAmount');
        const changeAmountEl = document.getElementById('changeAmount');

        // Helper: Format Rupiah
        function formatRupiah(amount) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
        }

        // Update cart display and totals
        function updateCart() {
            if (cart.length === 0) {
                cartContainer.innerHTML = '<p class="text-center text-gray-400 dark:text-gray-500 text-sm py-8">{{ __("No items added yet") }}</p>';
                subtotalEl.textContent = formatRupiah(0);
                document.getElementById('discountAmount').textContent = formatRupiah(0);
                totalEl.textContent = formatRupiah(0);
                paymentInput.value = '';
                changeAmountEl.textContent = formatRupiah(0);
                return;
            }

            // Build cart items HTML
            let html = '';
            let subtotal = 0;

            cart.forEach((item, idx) => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                html += `
    <div class="flex justify-between items-center p-2 border border-gray-100 dark:border-gray-700 rounded-lg">
        <div class="flex-1">
            <div class="font-medium text-gray-800 dark:text-gray-200">${escapeHtml(item.name)}</div>
            <div class="text-xs text-gray-500 dark:text-gray-400">${formatRupiah(item.price)} / ${item.unit}</div>
            <div class="text-xs text-amber-600 dark:text-amber-500">Stok: ${item.currentStok}</div>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="adjustQuantity(${idx}, -1)" class="w-6 h-6 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600">-</button>
            
            <input 
                type="number" 
                min="1" 
                max="${item.currentStok}"
                value="${item.quantity}" 
                onchange="updateQuantityDirectly(${idx}, this.value)"
                class="w-12 text-center text-gray-800 dark:text-gray-200 bg-transparent border border-gray-300 dark:border-gray-600 rounded p-0.5 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
            >
            
            <button onclick="adjustQuantity(${idx}, 1)" class="w-6 h-6 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600">+</button>
            <button onclick="removeFromCart(${idx})" class="ml-2 text-red-500 hover:text-red-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </div>
        <div class="ml-4 text-right font-medium text-gray-800 dark:text-gray-200 w-24">
            ${formatRupiah(itemTotal)}
        </div>
    </div>
`;
            });

            cartContainer.innerHTML = html;

            // Calculate discount and total
            const discountPercent = parseFloat(document.getElementById('discountPercent').value) || 0;
            const discountAmount = subtotal * (discountPercent / 100);
            const total = subtotal - discountAmount;

            subtotalEl.textContent = formatRupiah(subtotal);
            document.getElementById('discountAmount').textContent = formatRupiah(discountAmount);
            totalEl.textContent = formatRupiah(total);

            // Recalculate change if payment is entered
            calculateChange();
        }

        function updateQuantityDirectly(idx, value) {
            let newQty = parseInt(value) || 1;
            const maxStok = cart[idx].currentStok;

            // Batasi kuantitas minimal 1
            if (newQty < 1) {
                newQty = 1;
            }

            // Validasi: Jika input melebihi currentStok, paksa nilainya kembali ke batas maksimal
            if (newQty > maxStok) {
                alert(`Maaf, stok maksimal yang tersedia hanya ${maxStok}`);
                newQty = maxStok;
            }

            cart[idx].quantity = newQty;
            updateCart();
        }

        // Adjust quantity
        window.adjustQuantity = function(index, delta) {
            if (cart[index]) {
                if (delta > 0 && cart[index].quantity >= cart[index].currentStok) {
                    alert(`Maaf, stok maksimal yang tersedia hanya ${cart[index].currentStok}`);
                    return;
                }
                const newQty = cart[index].quantity + delta;
                if (newQty <= 0) {
                    removeFromCart(index);
                } else {
                    cart[index].quantity = newQty;
                    updateCart();
                }
            }
        };

        // Remove item
        window.removeFromCart = function(index) {
            cart.splice(index, 1);
            updateCart();
        };

        // Calculate change
        function calculateChange() {
            const totalText = totalEl.textContent.replace(/[^0-9]/g, '');
            const total = parseInt(totalText) || 0;
            const payment = parseInt(paymentInput.value) || 0;
            const change = payment - total;
            changeAmountEl.textContent = formatRupiah(change > 0 ? change : 0);
            return {
                total,
                payment,
                change
            };
        }

        // Event: calculate change button
        document.getElementById('calculateChangeBtn').addEventListener('click', calculateChange);

        document.getElementById('discountPercent').addEventListener('input', function() {
            let value = parseInt(this.value) || 0;
            if (value < 0) this.value = 0;
            if (value > 100) this.value = 100;
            updateCart();
        });

        // Add product to cart
        function addToCart(id, name, price, harga_beli, unit, currentStok) {
            
            const existing = cart.find(item => item.name === name && item.price === price);
            if (existing) {
                if (existing.quantity >= existing.currentStok) {
                    alert(`Maaf, stok maksimal yang tersedia hanya ${existing.currentStok}`);
                    return;
                }
                existing.quantity++;
            } else {
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    harga_beli: harga_beli,
                    unit: unit,
                    currentStok: currentStok,
                    quantity: 1
                });
            }
            updateCart();
        }

        // Product button click listeners
        document.querySelectorAll('.product-item').forEach(btn => {
            btn.addEventListener('click', function() {
                // console.log('Product data:', this.dataset); // Debugging line
                const id = this.dataset.id;
                const name = this.dataset.name;
                const price = parseInt(this.dataset.price);
                const harga_beli = parseInt(this.dataset.harga_beli);
                const unit = this.dataset.unit;
                const currentStok = parseInt(this.dataset.stok);
                addToCart(id, name, price, harga_beli, unit, currentStok);
            });
        });

        // Search filter
        document.getElementById('searchProduct').addEventListener('input', function(e) {
            const search = e.target.value.toLowerCase();
            document.querySelectorAll('.product-item').forEach(btn => {
                const name = btn.dataset.name.toLowerCase();
                if (name.includes(search)) {
                    btn.style.display = '';
                } else {
                    btn.style.display = 'none';
                }
            });
        });

        // Clear cart
        document.getElementById('clearCartBtn').addEventListener('click', () => {
            if (confirm('Clear all items from cart?')) {
                cart = [];
                updateCart();
            }
        });

        // Process payment and clean cart
        document.getElementById('processPaymentBtn').addEventListener('click', async () => {
            if (cart.length === 0) {
                alert('Cart is empty. Add some products first.');
                return;
            }

            const {
                total,
                payment,
                change
            } = calculateChange();
            if (payment < total) {
                alert('Insufficient payment. Please enter amount greater than or equal to total.');
                return;
            }

            const subtotalText = subtotalEl.textContent.replace(/[^0-9]/g, '');
            const subtotal = parseInt(subtotalText) || 0;
            const discountPercent = parseFloat(document.getElementById('discountPercent').value) || 0;
            const discountAmount = subtotal * (discountPercent / 100);
            const totalAfterDiscount = subtotal - discountAmount;
            const paymentMethodSelect = document.getElementById('paymentMethod');
            const paymentMethodId = paymentMethodSelect.value;



            // Create a form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("kasir.processpayment") }}';

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


        // Simple escape to prevent XSS
        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        // Initial update
        updateCart();
    </script>

    @include('kasir.paymentsuccessmodal')
</x-layouts.app>