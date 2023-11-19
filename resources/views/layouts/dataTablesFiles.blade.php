@push('styles')
    <!--DataTables Sytles-->
    {{-- <link href="{{ asset('css/plugins/datatables.min.css') }}" rel="stylesheet" /> --}}
    <link href="{{ asset('css/plugins/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    {{-- <link href="{{ asset('css/plugins/responsive.bootstrap4.min.css') }}" rel="stylesheet" /> --}}
    @if (@$button)
        <link href="{{ asset('css/plugins/buttons.bootstrap5.min') }}" rel="stylesheet" />
    @endif
@endpush

@push('scripts')
    <!--DataTables Scripts-->
    <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables.bootstrap5.min.js') }}"></script>
    {{-- <script src="{{ asset('js/plugins/dataTables.responsive.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/plugins/responsive.bootstrap4.min.js') }}"></script> --}}

    @if (@$button)
        <script src="{{ asset('js/plugins/dataTables.buttons.min.js') }}"></script>
        {{-- <script src="{{ asset('js/plugins/jszip.min.js') }}"></script> --}}
        <script src="{{ asset('js/plugins/pdfmake.min.js') }}"></script>
        <script src="{{ asset('js/plugins/vfs_fonts.js') }}"></script>
        <script src="{{ asset('js/plugins/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('js/plugins/buttons.print.min.js') }}"></script>
        <script src="{{ asset('js/plugins/buttons.colVis.min.js') }}"></script>
    @endif

    <script>
        $.fn.dataTable.ext.errMode = 'none';
    </script>
@endpush
