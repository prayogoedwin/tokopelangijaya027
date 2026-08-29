<!-- Payment Success Modal -->
<div id="paymentSuccessModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-90" aria-hidden="true"></div>

        <!-- Modal panel -->
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-800 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 bg-white dark:bg-gray-800 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-green-100 rounded-full dark:bg-green-900 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100" id="modal-title">
                            Pembayaran Berhasil !
                        </h3>
                        <div class="mt-2">

                        </div>
                    </div>
                </div>

                <!-- Transaction Summary -->
                <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Invoice Number:</span>
                            <span class="text-gray-900 dark:text-gray-100 font-mono" id="modalInvoiceNumber">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Total Pembayaran:</span>
                            <span class="text-gray-900 dark:text-gray-100 font-bold" id="modalTotal">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Metode Pembayaran:</span>
                            <span class="text-gray-900 dark:text-gray-100" id="modalPaymentMethod">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600 dark:text-gray-400">Kembalian:</span>
                            <span class="text-green-600 dark:text-green-400 font-semibold" id="modalChange">-</span>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp Phone Input (optional) -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Customer No Hp (untuk WhatsApp)
                    </label>
                    <input type="text" id="customerPhone"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"
                        placeholder="e.g., 628123456789">
                </div>
            </div>

            <div class="px-4 py-4 bg-gray-50 dark:bg-gray-900 sm:px-6">
                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">

                    <button type="button" id="printThermalBtn"
                        class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Thermal (80mm)
                    </button>

                    <button type="button" id="printInvoiceBtn"
                        class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Invoice (A4)
                    </button>

                    <button type="button" id="sendWABtn"
                        class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Kirim WhatsApp
                    </button>

                    <button type="button" id="closeModalBtn"
                        class="inline-flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-colors duration-150">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsrsasign/10.5.25/jsrsasign-all-min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/qz-tray@2.2.4/qz-tray.min.js"></script>
<script>
    // Modal functionality
    const paymentSuccessModal = document.getElementById('paymentSuccessModal');
    let currentTransactionData = null;

    // Check if modal should be shown from session
    @if(session('show_payment_modal') && session('transaction_data'))
    document.addEventListener('DOMContentLoaded', function() {
        showPaymentModal(@json(session('transaction_data')));
    });
    @endif

    let isQzConnected = false;



    // Mengambil data dari config/qztray.php dan mengganti \n menjadi baris baru asli di JS
    const qzCertificate = `{!! str_replace(["\r", "\n"], '\n', config('qztray.certificate')) !!}`;
    const qzPrivateKey = `{!! str_replace(["\r", "\n"], '\n', config('qztray.private_key')) !!}`;



    document.addEventListener("DOMContentLoaded", function() {
        // 1. Daftarkan Sertifikat dari Config Laravel ke QZ Tray


        qz.security.setSignaturePromise(function(toSign) {
            return function(resolve, reject) {
                try {
                    // Tanda tangan digital menggunakan library jsrsasign secara lokal di browser
                    var pk = KEYUTIL.getKey(qzPrivateKey);
                    var sig = new KJUR.crypto.Signature({
                        "alg": "SHA1withRSA"
                    });

                    sig.init(pk);
                    sig.updateString(toSign);

                    var hex = sig.sign();
                    resolve(stob64(hextob64(hex)));
                } catch (err) {
                    console.error("Gagal melakukan signing keamanan QZ:", err);
                    reject(err);
                }
            };
        });

        connectQZ();
    });

    // 1. Fungsi untuk menghubungkan ke QZ Tray secara aman
    function connectQZ() {
        if (!qz.websocket.isActive()) {
            qz.websocket.connect().then(() => {
                isQzConnected = true;
                console.log("QZ Tray Terhubung Sukses dengan Sertifikat Resmi!");
            }).catch((err) => {
                isQzConnected = false;
                console.error("Gagal terhubung ke QZ Tray: ", err);
            });
        } else {
            isQzConnected = true;
        }
    }

    function showPaymentModal(transactionData) {
        currentTransactionData = transactionData;

        // Populate modal with transaction data
        document.getElementById('modalInvoiceNumber').textContent = transactionData.no_invoice;
        document.getElementById('modalTotal').textContent = formatRupiah(transactionData.total_harus_dibayar);
        document.getElementById('modalChange').textContent = formatRupiah(transactionData.kembalian);
        document.getElementById('modalPaymentMethod').textContent = transactionData.tipe_pembayaran_name;

        // Show modal
        paymentSuccessModal.classList.remove('hidden');
    }

    // Close modal
    function closeModal() {
        paymentSuccessModal.classList.add('hidden');
    }

    document.getElementById('closeModalBtn').addEventListener('click', closeModal);

    // Click outside to close
    paymentSuccessModal.addEventListener('click', function(e) {
        if (e.target === paymentSuccessModal) {
            closeModal();
        }
    });

    // Print Invoice using DomPDF
    document.getElementById('printInvoiceBtn').addEventListener('click', function() {
        console.log(currentTransactionData, currentTransactionData.penjualan_id);
        if (!currentTransactionData || !currentTransactionData.penjualan_id) {
            alert('Transaction data not found!');
            return;
        }

        // Open the PDF in a new tab
        const pdfUrl = `{{ route('penjualans.cetaknota', ['penjualan' => ':penjualan_id']) }}`.replace(':penjualan_id', currentTransactionData.penjualan_id);
        window.open(pdfUrl, '_blank');
    });

    document.getElementById('printThermalBtn').addEventListener('click', function() {
        // Cek apakah websocket ke QZ Tray sudah siap
        if (!isQzConnected || !qz.websocket.isActive()) {
            alert("Koneksi ke aplikasi QZ Tray belum siap atau belum aktif. Menghubungkan ulang...");
            connectQZ(); // Coba hubungkan kembali otomatis
            return; // Batalkan proses cetak saat ini agar tidak crash
        }
        // Pastikan data transaksi tersedia
        if (!currentTransactionData) {
            alert("Data transaksi tidak ditemukan!");
            return;
        }

        // Ambil data utama dari object
        const toko = currentTransactionData.toko || {};
        const invoiceNo = currentTransactionData.no_invoice;
        const createdAt = new Date(currentTransactionData.created_at);
        const dateStr = createdAt.toLocaleDateString('id-ID') + ' ' + createdAt.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
        });

        const totalPembelian = formatRupiah(currentTransactionData.total_pembelian);
        const diskonNominal = formatRupiah(currentTransactionData.diskon_nominal);
        const totalHarusBayar = formatRupiah(currentTransactionData.total_harus_dibayar);
        const dibayar = formatRupiah(currentTransactionData.dibayar);
        const kembalian = formatRupiah(currentTransactionData.kembalian);
        const metodeBayar = currentTransactionData.tipe_pembayaran_name;

        // Inisialisasi konfigurasi printer QZ Tray
        const config = qz.configs.create("POS-80B"); // Sesuaikan nama printer Windows Anda

        // --- MULAI STRUKTUR DATA CETAK ESC/POS ---
        let dataCetak = [{
                type: 'raw',
                format: 'plain',
                data: '\x1B\x61\x01'
            }, // Rata Tengah (Center)
            {
                type: 'raw',
                format: 'plain',
                data: 'TOKO PELANGI JAYA' + '\n'
            },
            {
                type: 'raw',
                format: 'plain',
                data: (toko.alamat || '') + '\n'
            },
            {
                type: 'raw',
                format: 'plain',
                data: 'Telp: ' + (toko.telp || '-') + '\n'
            },
            {
                type: 'raw',
                format: 'plain',
                data: '------------------------------------------------\n'
            }, // Diubah menjadi 48 Karakter untuk 80mm

            {
                type: 'raw',
                format: 'plain',
                data: '\x1B\x61\x00'
            }, // Rata Kiri (Left)
            {
                type: 'raw',
                format: 'plain',
                data: 'Nota : ' + invoiceNo + '\n'
            },
            {
                type: 'raw',
                format: 'plain',
                data: 'Tgl  : ' + dateStr + '\n'
            },
            {
                type: 'raw',
                format: 'plain',
                data: '------------------------------------------------\n'
            }
        ];

        // --- LOOPING ITEM PRODUK ---
        if (currentTransactionData.details && currentTransactionData.details.length > 0) {
            currentTransactionData.details.forEach(function(detail) {
                // Ambil nama produk
                const namaProduk = detail.produk ? detail.produk.name : 'Produk';
                const qtyStr = detail.jumlah + 'x';
                const hargaStr = formatRupiah(detail.harga_jual);
                const subtotalStr = formatRupiah(detail.harga_jual * detail.jumlah);

                // Baris 1: Nama Produk
                dataCetak.push({
                    type: 'raw',
                    format: 'plain',
                    data: namaProduk + '\n'
                });
                // Baris 2: Menggunakan helper rata kanan-kiri yang baru untuk 80mm
                const detailRow = formatRow80mm('  ' + qtyStr + ' ' + hargaStr, subtotalStr);
                dataCetak.push({
                    type: 'raw',
                    format: 'plain',
                    data: detailRow
                });
            });
        }

        // --- BAGIAN TOTAL & PEMBAYARAN ---
        dataCetak.push({
            type: 'raw',
            format: 'plain',
            data: '------------------------------------------------\n'
        }, {
            type: 'raw',
            format: 'plain',
            data: formatRow80mm('Total:', totalPembelian)
        });

        // Jika ada diskon, tampilkan
        if (parseFloat(currentTransactionData.diskon_nominal) > 0) {
            const diskonPersen = currentTransactionData.diskon_percentage + '%';
            dataCetak.push({
                type: 'raw',
                format: 'plain',
                data: formatRow80mm('Diskon (' + diskonPersen + '):', '-' + diskonNominal)
            });
        }

        dataCetak.push({
                type: 'raw',
                format: 'plain',
                data: formatRow80mm('Grand Total:', totalHarusBayar)
            }, {
                type: 'raw',
                format: 'plain',
                data: formatRow80mm('Bayar (' + metodeBayar + '):', dibayar)
            }, {
                type: 'raw',
                format: 'plain',
                data: formatRow80mm('Kembalian:', kembalian)
            }, {
                type: 'raw',
                format: 'plain',
                data: '------------------------------------------------\n'
            },

            // FOOTER
            {
                type: 'raw',
                format: 'plain',
                data: '\x1B\x61\x01'
            }, // Kembali ke Rata Tengah
            {
                type: 'raw',
                format: 'plain',
                data: 'Barang yang sudah dibeli tidak dapat dikembalikan\nkecuali ada perjanjian\n\n'
            }, {
                type: 'raw',
                format: 'plain',
                data: 'TERIMA KASIH\n'
            }, {
                type: 'raw',
                format: 'plain',
                data: 'JUAL SE\'ADA NYA BARELA\'AN\n'
            }, {
                type: 'raw',
                format: 'plain',
                data: '\n\n\n\n'
            }, // Feed kertas kosong ke atas agar gampang disobek
            {
                type: 'raw',
                format: 'plain',
                data: '\x1B\x69'
            } // Perintah Cut kertas (opsional)
        );

        // --- EKSEKUSI CETAK VIA QZ TRAY ---
        qz.print(config, dataCetak).then(() => {
            console.log("Cetak thermal sukses!");
        }).catch((err) => {
            console.error("Gagal mencetak: ", err);
            alert("Printer Error: " + err.message);
        });
    });

    function formatRow58mm(leftText, rightText) {
        const maxWidth = 32; // Standar karakter printer 58mm
        const spaceAvailable = maxWidth - leftText.length - rightText.length;

        if (spaceAvailable > 0) {
            return leftText + " ".repeat(spaceAvailable) + rightText + "\n";
        } else {
            // Jika nama produk terlalu panjang, potong atau biarkan turun baris
            return leftText.substring(0, maxWidth - rightText.length - 1) + " " + rightText + "\n";
        }
    }

    function formatRow80mm(leftText, rightText) {
        const maxChar = 48; // Standar jumlah karakter untuk printer 80mm font standard
        const spaceLength = maxChar - leftText.length - rightText.length;

        if (spaceLength > 0) {
            return leftText + ' '.repeat(spaceLength) + rightText + '\n';
        } else {
            // Jika teks terlalu panjang, beri minimal 1 spasi
            return leftText + ' ' + rightText + '\n';
        }
    }


    function buildCompactWaMessage(transaction) {
        console.log(transaction);
        // Membuka format monospace WhatsApp dengan ```
        let message = "```\n";
        message += `*TOKO PELANGI JAYA*\n`;
        message += `${'='.repeat(32)}\n`;
        message += `Nota: ${transaction.no_invoice}\n`;
        message += `Tgl : ${new Date().toLocaleString('id-ID')}\n`;
        message += `Telp : ${transaction.toko_telp}\n`;
        message += `${'='.repeat(32)}\n`;
        message += `Item         Qty   Harga    Total\n`;
        message += `${'-'.repeat(32)}\n`;

        transaction.details.forEach(item => {
            const subtotal = item.harga_jual * item.jumlah;
            // Truncate nama jika lebih dari 12 karakter agar kolom tidak geser
            const nameTrunc = item.name.length > 12 ? item.name.substring(0, 10) + '..' : item.name;

            // Memformat kolom agar sejajar rapi
            const itemCol = nameTrunc.padEnd(12);
            const qtyCol = item.jumlah.toString().padStart(3);
            const hargaCol = item.harga_jual.toString().padStart(7);
            const totalCol = subtotal.toString().padStart(8);

            message += `${itemCol} ${qtyCol} ${hargaCol} ${totalCol}\n`;
        });

        message += `${'-'.repeat(32)}\n`;
        message += `Grand Total: ${transaction.total_pembelian.toString().padStart(19)}\n`;

        if (transaction.diskon_percentage > 0) {
            const diskonLabel = `Diskon ${transaction.diskon_percentage}%:`;
            const diskonValue = `-${transaction.diskon_nominal}`;
            message += `${diskonLabel.padEnd(12)} ${diskonValue.padStart(19)}\n`;
        }

        message += `${'='.repeat(32)}\n`;
        message += `Total Bayar: ${transaction.total_harus_dibayar.toString().padStart(19)}\n`;
        message += `Dibayar:     ${transaction.dibayar.toString().padStart(19)}\n`;
        message += `Kembalian:   ${transaction.kembalian.toString().padStart(19)}\n`;
        message += `${'='.repeat(32)}\n`;
        message += `Metode: ${transaction.tipe_pembayaran_name}\n`;
        message += `${'='.repeat(32)}\n`;
        message += `${new Date().toLocaleTimeString('id-ID')}\n`;
        message += `${'='.repeat(32)}\n`; // Pembatas sebelum footer

        const centerText = (text) => {
            const padding = Math.max(0, Math.floor((32 - text.length) / 2));
            return ' '.repeat(padding) + text;
        };

        message += `${centerText("Barang yang sudah dibeli tidak")}\n`;
        message += `${centerText("dapat dikembalikan kecuali")}\n`;
        message += `${centerText("ada perjanjian")}\n\n`;

        message += `${centerText("TERIMA KASIH")}\n`;
        message += `${centerText("JUAL SE'ADA NYA BARELA'AN")}\n`;

        // Menutup format monospace WhatsApp
        message += "```";

        return message;
    }

    // Gunakan di tombol sendWA
    document.getElementById('sendWABtn').addEventListener('click', function() {
        if (!currentTransactionData) return;

        let customerPhone = document.getElementById('customerPhone').value.trim();
        if (!customerPhone) {
            alert('Please enter phone number first!');
            return;
        }

        let phone = customerPhone.replace(/\D/g, '');
        if (phone.startsWith('0')) phone = '62' + phone.substring(1);
        if (!phone.startsWith('62')) phone = '62' + phone;

        // PERBAIKAN: Generate message terlebih dahulu sebelum dibaca oleh console / URL
        const message = buildCompactWaMessage(currentTransactionData);

        // console.log(`https://wa.me/${phone}?text=${encodeURIComponent(message)}`);

        const whatsappUrl = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');
    });
</script>