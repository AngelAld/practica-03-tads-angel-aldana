@extends('adminlte::page')

@section('title', 'Periodos')
@section('content_header')
    <h1>Gestión de Periodos</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary float-right" id="btnNuevo"><i class="fas fa-folder-plus"></i>
                Nuevo</button>
            <h3>Periodos</h3>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered text-center" id="datatable">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($periods as $period)
                        <tr>
                            <td>{{ $period->id }}</td>
                            <td>{{ $period->name }}</td>
                            <td>
                                @if ($period->status)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-success btn-sm btnEditar" id="{{ $period->id }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </td>
                            <td>
                                <form action="{{ route('admin.periods.destroy', $period->id) }}" method="POST"
                                    class="frmDelete">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    // Rutas base para reemplazo dinámico
    var editRoute = "{{ route('admin.periods.edit', ['period' => 'PERIOD_ID']) }}";
    var destroyRoute = "{{ route('admin.periods.destroy', ['period' => 'PERIOD_ID']) }}";
    var createRoute = "{{ route('admin.periods.create') }}";
    var indexRoute = "{{ route('admin.periods.index') }}";

    // Inicializa DataTable
    let table = $('#datatable').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.3.2/i18n/es-ES.json'
        },
        responsive: true,
        autoWidth: false,
        ajax: indexRoute,
        columns: [
            { data: 'id' },
            { data: 'name' },
            { 
                data: 'status',
                render: function(data) {
                    return data
                        ? '<span class="badge badge-success">Activo</span>'
                        : '<span class="badge badge-danger">Inactivo</span>';
                }
            },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data) {
                    let url = editRoute.replace('PERIOD_ID', data);
                    return `<button class="btn btn-success btn-sm btnEditar" data-id="${data}" data-url="${url}">
                                <i class="fas fa-pen"></i>
                            </button>`;
                }
            },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data) {
                    let url = destroyRoute.replace('PERIOD_ID', data);
                    return `<form action="${url}" method="POST" class="frmDelete" style="display:inline;">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>`;
                }
            }
        ]
    });

    // Refresca la tabla
    function refreshTable() {
        table.ajax.reload(null, false);
    }

    // Nuevo
    $('#btnNuevo').click(function() {
        $.get(createRoute, function(response) {
            $('.modal-title').html("Nuevo Periodo");
            $('#ModalCenter .modal-body').html(response);
            $('#ModalCenter').modal('show');

            $('#ModalCenter form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formdata = new FormData(this);
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#ModalCenter').modal('hide');
                        refreshTable();
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.message
                        });
                    },
                    error: function(xhr) {
                        let msg = xhr.responseJSON?.message || 'Error al guardar';
                        Swal.fire({ icon: 'error', title: 'Error', text: msg });
                    }
                });
            });
        });
    });

    // Editar
    $('#datatable').on('click', '.btnEditar', function() {
        var url = $(this).data('url');
        $.get(url, function(response) {
            $('.modal-title').html("Editar Periodo");
            $('#ModalCenter .modal-body').html(response);
            $('#ModalCenter').modal('show');

            $('#ModalCenter form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formdata = new FormData(this);
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#ModalCenter').modal('hide');
                        refreshTable();
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.message
                        });
                    },
                    error: function(xhr) {
                        let msg = xhr.responseJSON?.message || 'Error al actualizar';
                        Swal.fire({ icon: 'error', title: 'Error', text: msg });
                    }
                });
            });
        });
    });

    // Eliminar con confirmación
    $('#datatable').on('submit', '.frmDelete', function(e) {
        e.preventDefault();
        var form = $(this);
        Swal.fire({
            title: '¿Estás seguro de eliminar este periodo?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        refreshTable();
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            text: response.message || 'Periodo eliminado correctamente.'
                        });
                    },
                    error: function(xhr) {
                        let msg = xhr.responseJSON?.message || 'Error al eliminar';
                        Swal.fire({ icon: 'error', title: 'Error', text: msg });
                    }
                });
            }
        });
    });
</script>
@endsection
