<?php

return [
    /*
    |--------------------------------------------------------------------------
    | DataTables Default Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can specify the default configuration for DataTables.
    | You can override these settings on a per-table basis.
    |
    */

    'defaults' => [
        'processing' => true,
        'serverSide' => true,
        'responsive' => true,
        'pageLength' => 25,
        'lengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
        'language' => [
            'url' => '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        ],
        'dom' => 'Bfrtip',
        'buttons' => [
            'excel',
            'pdf',
            'print',
            'reload'
        ],
        'order' => [[0, 'desc']],
        'columnDefs' => [
            [
                'targets' => 'no-sort',
                'orderable' => false,
            ],
            [
                'targets' => 'no-search',
                'searchable' => false,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | DataTables CSS and JS Assets
    |--------------------------------------------------------------------------
    |
    | Here you can specify the CSS and JS assets for DataTables.
    | You can use CDN or local assets.
    |
    */

    'assets' => [
        'css' => [
            'https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css',
            'https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css',
        ],
        'js' => [
            'https://code.jquery.com/jquery-3.7.0.min.js',
            'https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js',
            'https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js',
            'https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js',
            'https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js',
            'https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js',
            'https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | DataTables Export Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can configure the export options for DataTables.
    |
    */

    'export' => [
        'excel' => [
            'enabled' => true,
            'filename' => 'export',
            'extension' => 'xlsx',
        ],
        'pdf' => [
            'enabled' => true,
            'filename' => 'export',
            'extension' => 'pdf',
            'orientation' => 'landscape',
            'pageSize' => 'A4',
        ],
        'csv' => [
            'enabled' => true,
            'filename' => 'export',
            'extension' => 'csv',
        ],
    ],
];
