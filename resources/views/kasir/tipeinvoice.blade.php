<x-layouts.app>
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('dashboard') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('Cashier') }}</span>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Cashier POS') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('Transaction and invoice management') }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- LEFT COLUMN: Product Grid --}}
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="font-semibold text-gray-800 dark:text-gray-200">{{ __('Products') }}</h2>
                <input type="text" id="searchProduct" placeholder="Search product..." class="mt-2 w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
            </div>
            <div class="p-4">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 max-h-[500px] overflow-y-auto">
                    @forelse($produks as $produk)
                        <button type="button"
                            class="product-item text-left p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200"
                            data-name="{{ $produk->name }}"
                            data-price="{{ $produk->harga_jual }}"
                            data-unit="{{ $produk->satuan }}"
                            data-id="{{ $loop->index }}">
                            <div class="font-medium text-gray-800 dark:text-gray-200 text-sm">{{ $produk->name }}</div>
                            <div class="text-blue-600 dark:text-blue-400 font-bold mt-1">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Satuan: {{ $produk->satuan }}</div>
                        </button>
                    @empty
                        <p class="col-span-full text-center text-gray-500 dark:text-gray-400 py-8">{{ __('No products available.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Cart & Invoice --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col h-[600px]">
            {{-- Cart Header --}}
            <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                <h2 class="font-semibold text-gray-800 dark:text-gray-200">{{ __('Shopping Cart') }}</h2>
            </div>

            {{-- Cart Items List (Scrollable) --}}
            <div class="flex-1 overflow-y-auto p-4 space-y-3" id="cartItems">
                <p class="text-center text-gray-400 dark:text-gray-500 text-sm py-8">{{ __('No items added yet') }}</p>
            </div>

            {{-- Cart Summary & Invoice Preview --}}
            <div class="border-t border-gray-200 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-900">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('Subtotal') }}</span>
                        <span class="font-medium text-gray-800 dark:text-gray-200" id="subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('Tax (10%)') }}</span>
                        <span class="font-medium text-gray-800 dark:text-gray-200" id="tax">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold pt-2 border-t border-gray-200 dark:border-gray-700">
                        <span class="text-gray-800 dark:text-gray-200">{{ __('Total') }}</span>
                        <span class="text-blue-600 dark:text-blue-400" id="total">Rp 0</span>
                    </div>
                </div>

                <div class="mt-4 space-y-2">
                    <div class="flex gap-2">
                        <input type="number" id="paymentAmount" placeholder="Payment amount" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white text-sm">
                        <button id="calculateChangeBtn" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 text-sm font-medium transition">Change</button>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600 dark:text-gray-400">{{ __('Change') }}</span>
                        <span class="font-bold text-green-600 dark:text-green-400" id="changeAmount">Rp 0</span>
                    </div>
                </div>

                <div class="mt-4 flex gap-2">
                    <button id="processPaymentBtn" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-200">
                        {{ __('Process Payment') }}
                    </button>
                    <button id="clearCartBtn" class="px-4 py-2 border border-red-300 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md text-sm font-medium transition">
                        {{ __('Clear') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- INVOICE MODAL --}}
    <div id="invoiceModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 p-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('INVOICE') }}</h3>
                <button onclick="closeInvoiceModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6 space-y-4" id="invoiceContent">
                {{-- Dynamic invoice content will be inserted here --}}
            </div>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex gap-2">
                <button onclick="printInvoice()" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2 rounded-md transition">Print</button>
                <button onclick="closeInvoiceModal()" class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-medium py-2 rounded-md transition">Close</button>
            </div>
        </div>
    </div>

    @push('scripts')
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
                taxEl.textContent = formatRupiah(0);
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
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="adjustQuantity(${idx}, -1)" class="w-6 h-6 rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600">-</button>
                            <span class="w-10 text-center text-gray-800 dark:text-gray-200">${item.quantity}</span>
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

            // Calculate tax and total
            const tax = subtotal * 0.1;
            const total = subtotal + tax;

            subtotalEl.textContent = formatRupiah(subtotal);
            taxEl.textContent = formatRupiah(tax);
            totalEl.textContent = formatRupiah(total);

            // Recalculate change if payment is entered
            calculateChange();
        }

        // Adjust quantity
        window.adjustQuantity = function(index, delta) {
            if (cart[index]) {
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
            return { total, payment, change };
        }

        // Event: calculate change button
        document.getElementById('calculateChangeBtn').addEventListener('click', calculateChange);

        // Add product to cart
        function addToCart(name, price, unit) {
            const existing = cart.find(item => item.name === name && item.price === price);
            if (existing) {
                existing.quantity++;
            } else {
                cart.push({
                    name: name,
                    price: price,
                    unit: unit,
                    quantity: 1
                });
            }
            updateCart();
        }

        // Product button click listeners
        document.querySelectorAll('.product-item').forEach(btn => {
            btn.addEventListener('click', function() {
                const name = this.dataset.name;
                const price = parseInt(this.dataset.price);
                const unit = this.dataset.unit;
                addToCart(name, price, unit);
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

        // Process payment and show invoice
        document.getElementById('processPaymentBtn').addEventListener('click', () => {
            if (cart.length === 0) {
                alert('Cart is empty. Add some products first.');
                return;
            }

            const { total, payment, change } = calculateChange();
            if (payment < total) {
                alert('Insufficient payment. Please enter amount greater than or equal to total.');
                return;
            }

            // Generate invoice data
            const invoiceData = {
                transaction_id: 'INV-' + Date.now(),
                date: new Date().toLocaleString(),
                items: [...cart],
                subtotal: total - (total * 0.1), // subtotal before tax
                tax: total * 0.1,
                total: total,
                payment: payment,
                change: change,
                cashier: '{{ auth()->user()->name ?? "Cashier" }}'
            };

            showInvoice(invoiceData);
        });

        // Show invoice modal
        function showInvoice(data) {
            let itemsHtml = '';
            data.items.forEach(item => {
                const itemTotal = item.price * item.quantity;
                itemsHtml += `
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <td class="py-2 text-sm">${escapeHtml(item.name)}</td>
                        <td class="py-2 text-sm text-center">${item.quantity}</td>
                        <td class="py-2 text-sm text-right">${formatRupiah(item.price)}</td>
                        <td class="py-2 text-sm text-right">${formatRupiah(itemTotal)}</td>
                    </tr>
                `;
            });

            const invoiceHtml = `
                <div class="text-center border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h2 class="text-xl font-bold">STORE NAME</h2>
                    <p class="text-xs text-gray-500">Jl. Example No. 123, City</p>
                    <p class="text-xs text-gray-500">Tel: (021) 1234567</p>
                </div>
                <div class="flex justify-between text-xs text-gray-500 pt-2">
                    <span>Invoice: ${data.transaction_id}</span>
                    <span>${data.date}</span>
                </div>
                <div class="text-xs text-gray-500">Cashier: ${data.cashier}</div>
                <table class="w-full text-sm mt-4">
                    <thead class="border-b border-gray-300 dark:border-gray-600">
                        <tr><th class="text-left py-1">Item</th><th class="text-center py-1">Qty</th><th class="text-right py-1">Price</th><th class="text-right py-1">Total</th></tr>
                    </thead>
                    <tbody>
                        ${itemsHtml}
                    </tbody>
                </table>
                <div class="border-t border-gray-200 dark:border-gray-700 mt-4 pt-3 space-y-1 text-sm">
                    <div class="flex justify-between"><span>Subtotal</span><span>${formatRupiah(data.subtotal)}</span></div>
                    <div class="flex justify-between"><span>Tax (10%)</span><span>${formatRupiah(data.tax)}</span></div>
                    <div class="flex justify-between font-bold text-base pt-1"><span>TOTAL</span><span>${formatRupiah(data.total)}</span></div>
                    <div class="flex justify-between"><span>Payment</span><span>${formatRupiah(data.payment)}</span></div>
                    <div class="flex justify-between text-green-600"><span>Change</span><span>${formatRupiah(data.change)}</span></div>
                </div>
                <div class="text-center text-xs text-gray-400 mt-6 pt-3 border-t border-gray-200 dark:border-gray-700">
                    Thank you for shopping with us!
                </div>
            `;

            document.getElementById('invoiceContent').innerHTML = invoiceHtml;
            document.getElementById('invoiceModal').classList.remove('hidden');
            document.getElementById('invoiceModal').classList.add('flex');
        }

        window.closeInvoiceModal = function() {
            document.getElementById('invoiceModal').classList.add('hidden');
            document.getElementById('invoiceModal').classList.remove('flex');
        };

        window.printInvoice = function() {
            const printContent = document.getElementById('invoiceContent').innerHTML;
            const originalTitle = document.title;
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head><title>Print Invoice</title>
                <style>
                    body { font-family: monospace; padding: 20px; max-width: 400px; margin: 0 auto; }
                    .text-center { text-align: center; }
                    .text-right { text-align: right; }
                    table { width: 100%; border-collapse: collapse; }
                    td, th { padding: 8px 4px; }
                </style>
                </head>
                <body>${printContent}</body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        };

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
    @endpush
</x-layouts.app>