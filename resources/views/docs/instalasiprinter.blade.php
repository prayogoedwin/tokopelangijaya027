<x-layouts.app>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Panduan Print (QZ Tray)') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">
            {{ __('Ikuti langkah-langkah di bawah ini agar komputer kasir dapat mencetak nota 58mm.') }}
        </p>
    </div>

    <div class="mb-6 p-4 rounded-xl bg-blue-50/50 dark:bg-blue-950/20 border border-blue-100 dark:border-blue-900/50 flex items-start gap-3">
        <div class="p-2 bg-blue-500 rounded-lg text-white shrink-0 mt-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <h4 class="text-sm font-bold text-blue-900 dark:text-blue-300">Informasi Penting Nama Printer</h4>
            <p class="text-xs text-blue-700 dark:text-blue-400 mt-1 leading-relaxed">
                Sistem POS ini dikonfigurasi khusus untuk menembak nama printer: <span class="px-2 py-0.5 font-mono font-bold bg-white dark:bg-gray-800 border border-blue-200 dark:border-blue-800 rounded text-blue-800 dark:text-blue-300">POS-80B</span>. Jika nama printer di Windows kasir berbeda, struk tidak akan keluar.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="xl:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Langkah-Langkah Instalasi
                </h2>

                <div class="relative border-l-2 border-gray-200 dark:border-gray-700 ml-3 md:ml-4 space-y-8">

                    <div class="relative pl-6 md:pl-8">
                        <span class="absolute -left-[11px] top-0 flex items-center justify-center w-5 h-5 rounded-full bg-blue-600 text-white font-mono text-xs font-bold ring-4 ring-white dark:ring-gray-800">1</span>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Ganti Nama Printer di Windows</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                            Buka <span class="font-semibold">Control Panel</span> &rarr; <span class="font-semibold">Devices and Printers</span>. Cari driver printer thermal Anda, klik kanan, pilih <span class="font-semibold">Printer Properties</span>. Pada kolom teks paling atas, ubah namanya menjadi tepat: <code class="px-1.5 py-0.5 bg-gray-100 dark:bg-gray-900 rounded font-bold font-mono text-rose-600 dark:text-rose-400">POS-80B</code>.
                        </p>
                    </div>

                    <div class="relative pl-6 md:pl-8">
                        <span class="absolute -left-[11px] top-0 flex items-center justify-center w-5 h-5 rounded-full bg-blue-600 text-white font-mono text-xs font-bold ring-4 ring-white dark:ring-gray-800">2</span>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Unduh & Install QZ Tray</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                            QZ Tray adalah software jembatan aplikasi kasir menuju hardware printer lokal. Unduh versi stabil yang disarankan, lalu pasang di komputer Windows kasir hingga selesai.
                        </p>
                        <div class="mt-3">
                            <a href="https://qz.io/download/" target="_blank" class="inline-flex items-center px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-sm transition duration-150">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download QZ Tray Resmi
                            </a>
                        </div>
                    </div>

                    <div class="relative pl-6 md:pl-8">
                        <span class="absolute -left-[11px] top-0 flex items-center justify-center w-5 h-5 rounded-full bg-blue-600 text-white font-mono text-xs font-bold ring-4 ring-white dark:ring-gray-800">3</span>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Pastikan Aplikasi QZ Tray sudah berjalan</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                            Setelah QZ Tray terpasang, jalankan aplikasinya. Biasanya akan muncul ikon QZ Tray di system tray (pojok kanan bawah layar). Jika tidak muncul, coba cari di menu Start dan jalankan QZ Tray.
                        </p>

                    </div>

                    <div class="relative pl-6 md:pl-8">
                        <span class="absolute -left-[11px] top-0 flex items-center justify-center w-5 h-5 rounded-full bg-blue-600 text-white font-mono text-xs font-bold ring-4 ring-white dark:ring-gray-800">4</span>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Izinkan Hak Akses Keamanan </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                            Buka kembali atau refresh halaman kasir/dashboard ini. Aplikasi QZ Tray di Windows akan selalu memunculkan sebuah kotak dialog konfirmasi keamanan (*Dialog Warning Request*). Allow untuk memberi izin browser berkomunikasi dengan Aplikasi QZ.
                        </p>

                    </div>

                    


                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 flex flex-col justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4">Cek Status Koneksi</h3>

                    <div id="statusBox" class="p-4 rounded-xl border flex items-center gap-3 bg-gray-50 dark:bg-gray-900/50 border-gray-200 dark:border-gray-700">
                        <div id="statusDot" class="w-3 h-3 rounded-full bg-gray-400 animate-pulse"></div>
                        <div>
                            <span id="statusText" class="text-sm font-bold text-gray-700 dark:text-gray-300">Memeriksa QZ Tray...</span>
                            <p id="statusDesc" class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">Menghubungkan ke lokal port...</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 border-t border-gray-100 dark:border-gray-700/50 pt-4">
                    <button type="button" id="btnTestPrint" disabled
                        class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-gray-400 border border-transparent rounded-md shadow-sm cursor-not-allowed focus:outline-none transition-all duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Uji Coba Cetak (POS-80B)
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsrsasign/10.5.25/jsrsasign-all-min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qz-tray@2.2.4/qz-tray.min.js"></script>

    <script>
        const statusBox = document.getElementById('statusBox');
        const statusDot = document.getElementById('statusDot');
        const statusText = document.getElementById('statusText');
        const statusDesc = document.getElementById('statusDesc');
        const btnTestPrint = document.getElementById('btnTestPrint');


        const qzCertificate = `{!! str_replace(["\r", "\n"], '\n', config('qztray.certificate')) !!}`;
        const qzPrivateKey = `{!! str_replace(["\r", "\n"], '\n', config('qztray.private_key')) !!}`;

        qz.security.setSignaturePromise(function(toSign) {
            return function(resolve, reject) {
                try {
                    var pk = KEYUTIL.getKey(qzPrivateKey);
                    var sig = new KJUR.crypto.Signature({
                        "alg": "SHA1withRSA"
                    });
                    sig.init(pk);
                    sig.updateString(toSign);
                    var hex = sig.sign();
                    resolve(stob64(hextob64(hex)));
                } catch (err) {
                    reject(err);
                }
            };
        });

        // Cek koneksi lokal otomatis saat halaman dibuka
        document.addEventListener("DOMContentLoaded", function() {
            if (!qz.websocket.isActive()) {
                qz.websocket.connect().then(() => {
                    // Update UI jika terhubung sukses
                    statusBox.className = "p-4 rounded-xl border flex items-center gap-3 bg-emerald-50/50 dark:bg-emerald-950/10 border-emerald-200 dark:border-emerald-900/50";
                    statusDot.className = "w-3 h-3 rounded-full bg-emerald-500 shadow shadow-emerald-500 animate-none";
                    statusText.className = "text-sm font-bold text-emerald-800 dark:text-emerald-400";
                    statusText.innerText = "Terhubung Aktif!";
                    statusDesc.innerText = "Siap melakukan cetak instan.";

                    // Aktifkan Tombol Test Print
                    btnTestPrint.disabled = false;
                    btnTestPrint.className = "w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 border border-transparent rounded-md shadow-sm focus:outline-none transition-all duration-150 cursor-pointer";
                }).catch((err) => {
                    // Update UI jika aplikasi qz tray lokal mati/belum diinstall
                    statusBox.className = "p-4 rounded-xl border flex items-center gap-3 bg-rose-50/50 dark:bg-rose-950/10 border-rose-200 dark:border-rose-900/50";
                    statusDot.className = "w-3 h-3 rounded-full bg-rose-500 shadow shadow-rose-500 animate-none";
                    statusText.className = "text-sm font-bold text-rose-800 dark:text-rose-400";
                    statusText.innerText = "Belum Terhubung";
                    statusDesc.innerText = "Aplikasi QZ Tray belum aktif di PC ini.";
                });
            }
        });

        // Trigger Cetak Percobaan
        btnTestPrint.addEventListener('click', function() {
            const config = qz.configs.create("POS-80B"); // Menggunakan nama printer target Anda

            // Format data text thermal standard 32 char baris
            let dataCetak = [{
                    type: 'raw',
                    format: 'plain',
                    data: '\x1B\x61\x01'
                }, // Center
                {
                    type: 'raw',
                    format: 'plain',
                    data: 'TES KONEKSI POS-80B\n'
                },
                {
                    type: 'raw',
                    format: 'plain',
                    data: '================================\n'
                },
                {
                    type: 'raw',
                    format: 'plain',
                    data: '\x1B\x61\x00'
                }, // Left
                {
                    type: 'raw',
                    format: 'plain',
                    data: 'Status Printer : Berhasil Aktif\n'
                },
                {
                    type: 'raw',
                    format: 'plain',
                    data: 'Sistem Integrasi: Laravel - QZ\n'
                },
                {
                    type: 'raw',
                    format: 'plain',
                    data: '================================\n'
                },
                {
                    type: 'raw',
                    format: 'plain',
                    data: '\x1B\x61\x01'
                },
                {
                    type: 'raw',
                    format: 'plain',
                    data: 'SIAP DIGUNAKAN BERTRANSAKSI\n\n\n\n'
                },
                {
                    type: 'raw',
                    format: 'plain',
                    data: '\x1B\x69'
                } // Paper cut
            ];

            qz.print(config, dataCetak).then(() => {
                alert("Perintah cetak percobaan berhasil dikirim ke printer POS-80B!");
            }).catch((err) => {
                alert("Gagal mencetak! Periksa apakah driver printer bernama 'POS-80B' sudah terpasang. Detail: " + err.message);
            });
        });
    </script>

</x-layouts.app>