<x-layouts.app>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Panduan Print (Thermer Android)') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">
            {{ __('Ikuti langkah-langkah di bawah ini agar komputer kasir dapat mencetak nota 80mm.') }}
        </p>
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
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Install Aplikasi Thermal</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                            Thermer (Bluetooth Thermal Printer App) adalah software jembatan aplikasi kasir Android menuju hardware printer lokal via bluetooth. Unduh versi stabil yang disarankan, lalu pasang di perangkat Android kasir hingga selesai.
                        </p>
                            <div class="mt-3">
                            <a href="https://play.google.com/store/apps/details?id=mate.bluetoothprint&pcampaignid=web_share" target="_blank" class="inline-flex items-center px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-sm transition duration-150">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download Aplikasi Thermer Resmi Playstore
                            </a>
                        </div>
                    </div>

                    <div class="relative pl-6 md:pl-8">
                        <span class="absolute -left-[11px] top-0 flex items-center justify-center w-5 h-5 rounded-full bg-blue-600 text-white font-mono text-xs font-bold ring-4 ring-white dark:ring-gray-800">2</span>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Nyalakan Browser Print</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                            Masuk ke halaman "developer help", pilih "Browser Print", lalu pastikan tombol "Enable Browser Print" sudah aktif. Jika belum, klik tombol tersebut untuk mengaktifkan fitur ini. Fitur ini memungkinkan browser untuk berkomunikasi dengan aplikasi Thermer di perangkat Android.
                        </p>
                        
                    </div>

                    <div class="relative pl-6 md:pl-8">
                        <span class="absolute -left-[11px] top-0 flex items-center justify-center w-5 h-5 rounded-full bg-blue-600 text-white font-mono text-xs font-bold ring-4 ring-white dark:ring-gray-800">3</span>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Pastikan Aplikasi Thermer nyala di background</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                            Setelah Thermer terpasang, jalankan aplikasinya.
                        </p>

                    </div>

                    <div class="relative pl-6 md:pl-8">
                        <span class="absolute -left-[11px] top-0 flex items-center justify-center w-5 h-5 rounded-full bg-blue-600 text-white font-mono text-xs font-bold ring-4 ring-white dark:ring-gray-800">4</span>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Izinkan Hak Akses Keamanan </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                            Buka kembali atau refresh halaman kasir/dashboard ini. 
                        </p>

                    </div>

                    


                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 flex flex-col justify-between">
                

                <div class="mt-6 border-t border-gray-100 dark:border-gray-700/50 pt-4">
                    <a href="my.bluetoothprint.scheme://{{ route('android.print.test') }}" target="_blank" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Uji Coba Cetak (Bluetooth)
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>
