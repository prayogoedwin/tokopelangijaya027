<x-layouts.app>
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('dashboard') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('Kasir') }}</span>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Pilih Toko') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('') }}</p>
    </div>

    <div class="container">
        <h2>Pilih Toko untuk Kasir</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($tokos as $toko)
            <div class="col-lg-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ $toko->name }}</h5>
                        <p>{{ $toko->alamat }}</p>
                        <form action="{{ route('kasir.simpantoko') }}" method="POST">
                            @csrf
                            <input type="hidden" name="toko_id" value="{{ $toko->id }}">
                            <button type="submit" class=" w-100 flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                                Pilih Toko Ini
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>