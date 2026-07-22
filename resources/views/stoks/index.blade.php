<x-layouts.app>
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('dashboard') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ $title }}</span>
    </div>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $title }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Pengelolaan {{ $title }}</p>
        </div>
        <div class="flex gap-2">
            @if(auth()->user()->hasPermission('download-' . $tablename))
            @if (($canDownload ?? true) !== false)
            <a href="{{ route(strtolower($tablename) . '.export') }}">
                <x-button type="secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    {{ __('Download Excel') }}
                </x-button>
            </a>
            @endif
            @endif
            @if(auth()->user()->hasPermission('create-' . strtolower($tablename)))
            @if (($canCreate ?? true) !== false)
            <a href="{{ route(strtolower($tablename) . '.create') }}">
                <x-button type="primary">{{ __('Create ' . $title) }}</x-button>
            </a>
            @endif
            @endif


        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

        <!-- Section Wrapper Form Filter -->
        <div class="p-5 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30">

            <div class="flex flex-col sm:flex-row sm:items-end gap-4 max-w-3xl">


                <!-- Toko Select Group -->
                <div class="flex-1">
                    <label for="toko" class="block text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1.5">
                        Toko
                    </label>
                    <div class="relative">
                        <select id="toko" name="toko" class="block w-full px-3 py-2 text-sm text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:focus:border-blue-500 transition-colors">
                            <option value="">Semua Toko</option>
                            @foreach($tokos as $toko)
                            <option value="{{ $toko->id }}" {{ request('toko') == $toko->id ? 'selected' : '' }}>
                                {{ $toko->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <!-- Action Buttons -->
                <div class="flex items-center gap-2 pt-2 sm:pt-0">
                    <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-all cursor-pointer h-[38px]" onclick="tableReload()">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 8.293A1 1 0 013 7.586V4z" />
                        </svg>
                        Filter
                    </button>


                </div>
            </div>
        </div>

        <div class="p-4 overflow-x-auto">
            <table id="dynamic-table" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Toko</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                        

                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Aksi') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.tailwindcss.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script>
        

        $(document).ready(function() {
            $('#dynamic-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route(strtolower($tablename) . ".index") }}',
                    data: function(d) {
                        const urlParams = new URLSearchParams(window.location.search);
                        d.produk_id = urlParams.get('produk_id');
                        d.toko = document.getElementById('toko').value;
                    }
                },
                columns: [
                    {
                        data: 'produk.name',
                        name: 'produk.name'
                    },
                    {
                        data: 'toko',
                        name: 'toko'
                    },
                    {
                        data: 'tipe',
                        name: 'tipe'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah',

                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        
                    }
                    
                ],
                
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari " + "{{ $title }}",
                    lengthMenu: "Perlihatkan _MENU_ data",
                    info: "Memperlihatkan _START_ sampai _END_ dari _TOTAL_ {{ strtolower($title) }}",
                    infoEmpty: "tidak ada data {{ strtolower($title) }} ditemukan",
                    infoFiltered: "(filtered from _MAX_ total {{ strtolower($title) }})",
                    zeroRecords: "tidak ada data {{ strtolower($title) }} ditemukan",
                    emptyTable: "tidak ada {{ strtolower($title) }}"
                },
                dom: '<"flex flex-col md:flex-row justify-between items-center mb-4"lf>rt<"flex flex-col md:flex-row justify-between items-center mt-4"ip>',
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                stripeClasses: ['bg-white dark:bg-gray-800', 'bg-gray-50 dark:bg-gray-900']
            });
        });

        function tableReload() {
            const table = $('#dynamic-table').DataTable();
            const urlParams = new URLSearchParams(window.location.search);
            const tokoId = document.getElementById('toko').value;

            if (tokoId) {
                urlParams.set('toko', tokoId);
            } else {
                urlParams.delete('toko');
            }

            const newUrl = window.location.pathname + '?' + urlParams.toString();
            window.history.pushState({}, '', newUrl);

            table.ajax.reload();
        }
    </script>

    <style>
        /* Table borders and styling */
        #dynamic-table {
            border-collapse: separate !important;
            border-spacing: 0;
        }

        #dynamic-table thead th {
            border-bottom: 2px solid #e5e7eb;
            background-color: #f9fafb;
        }

        .dark #dynamic-table thead th {
            border-bottom-color: #374151;
            background-color: #1f2937;
        }

        #dynamic-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
        }

        .dark #dynamic-table tbody tr {
            border-bottom-color: #374151;
        }

        /* Alternating row colors (striping) */
        #dynamic-table tbody tr.odd {
            background-color: #ffffff;
        }

        #dynamic-table tbody tr.even {
            background-color: #f9fafb;
        }

        .dark #dynamic-table tbody tr.odd {
            background-color: #1f2937;
        }

        .dark #dynamic-table tbody tr.even {
            background-color: #111827;
        }

        #dynamic-table tbody tr:hover {
            background-color: #e5e7eb !important;
        }

        .dark #dynamic-table tbody tr:hover {
            background-color: #374151 !important;
        }

        #dynamic-table tbody td {
            border-right: 1px solid #e5e7eb;
            padding: 12px 24px;
        }

        .dark #dynamic-table tbody td {
            border-right-color: #374151;
        }

        #dynamic-table tbody td:last-child {
            border-right: none;
        }

        #dynamic-table thead th {
            border-right: 1px solid #e5e7eb;
        }

        .dark #dynamic-table thead th {
            border-right-color: #374151;
        }

        #dynamic-table thead th:last-child {
            border-right: none;
        }

        /* Action links styling - keep inline */
        #dynamic-table tbody td a,
        #dynamic-table tbody td form {
            display: inline;
            white-space: nowrap;
        }

        /* DataTables controls styling */
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            @apply px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply px-3 py-1 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 mx-1;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply bg-blue-600 text-white border-blue-600;
        }

        .dataTables_wrapper .dataTables_info {
            @apply text-sm text-gray-600 dark:text-gray-400;
        }
    </style>
</x-layouts.app>