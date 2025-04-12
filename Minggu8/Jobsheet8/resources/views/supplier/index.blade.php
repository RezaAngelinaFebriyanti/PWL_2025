@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/supplier/import') }}')" class="btn btn-info">Import </button>
                <a href="{{ url('/supplier/export_excel') }}" class="btn btn-primary">
                    <i class="fa fa-file-excel"></i>
                    Export Supplier (.xlsx)
                </a>
                <a href="{{ url('/supplier/export_pdf') }}" class="btn btn-warning">
                    <i class="fa fa-file-excel"></i>
                    Export Supplier (.pdf)
                </a>
                <button onclick="modalAction('{{ url('/supplier/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
            </div>
        </div>

        <div class="card-body">
            {{-- Filter --}}
            <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm row text-sm mb-0">
                            <label for="filter_date" class="col-md-1 col-form-label">Filter</label>
                            <div class="col-md-3">
                                <select name="filter_supplier" class="form-control form-control-sm filter_supplier">
                                    <option value="">- Semua -</option>
                                    @foreach($supplier_kode as $l)
                                        <option value="{{ $l->supplier_kode }}">{{ $l->supplier_kode }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Kategori Barang</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Flash Message --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            {{-- Tabel --}}
            <table class="table table-bordered table-striped table-hover table-sm" id="table_supplier">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Supplier</th>
                    <th>Nama Supplier</th>
                    <th>Alamat Supplier</th>
                    <th>Aksi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data- backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = ''){
            $('#myModal').load(url,function(){
            $('#myModal').modal('show')
        });
        }

    var dataSupplier;
        $(document).ready(function() {
            dataSupplier = $('#table_supplier').DataTable({
                processing: true,
                serverSide: true, 
                ajax: {
                    "url": "{{ url('supplier/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    data: function(d) {
                        d.filter_supplier = $('.filter_supplier').val();
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex", // nomor urut dari laravel datatable addIndexColumn()
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "supplier_kode",
                        className: "",
                        orderable: true, 
                        searchable: true 
                    },
                    {
                        data: "supplier_nama",
                        className: "",
                        orderable: true, 
                        searchable: true
                    },
                    {
                        data: "supplier_alamat",
                        className: "",
                        orderable: true, 
                        searchable: true 
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false, 
                        searchable: false 
                    }
                ]
            });
            $('#table_supplier_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) {
                    dataSupplier.search(this.value).draw();
                }
            });

            $('.filter_supplier').change(function() {
                dataSupplier.draw();
            });
        });
    </script>
@endpush