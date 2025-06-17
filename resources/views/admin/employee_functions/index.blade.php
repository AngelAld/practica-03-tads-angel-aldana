@extends('adminlte::page')

@section('title', 'Funciones de Empleado')
@section('content_header')
    <h1>Gestión de Funciones de Empleado</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary float-right" id="btnNuevo"><i class="fas fa-folder-plus"></i>
                Nuevo</button>
            <h3>Funciones</h3>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered text-center" id="datatable">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody></tbody>
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
        var editRoute = "{{ route('admin.employee_functions.edit', ['employee_function' => 'ID']) }}";
        var destroyRoute = "{{ route('admin.employee_functions.destroy', ['employee_function' => 'ID']) }}";
        var createRoute = "{{ route('admin.employee_functions.create') }}";
        var indexRoute = "{{ route('admin.employee_functions.index') }}";

        let table = $('#datatable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.3.2/i18n/es-ES.json'
            },
            responsive: true,
            autoWidth: false,
            ajax: indexRoute,
            columns: [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'description'
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        let url = editRoute.replace('ID', data);
                        return `<button class="btn btn-success btn-sm btnEditar" data-id="${data}" data-url="${url}"><i class="fas fa-pen"></i></button>`;
                    }
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        let url = destroyRoute.replace('ID', data);
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

        function refreshTable() {
            table.ajax.reload(null, false);
        }

        // Nuevo
        $('#btnNuevo').click(function() {
            $.get(createRoute, function(response) {
                $('.modal-title').html("Nueva Función");
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
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: msg
                            });
                        }
                    });
                });
            });
        });

        // Editar
        $('#datatable').on('click', '.btnEditar', function() {
            var url = $(this).data('url');
            $.get(url, function(response) {
                $('.modal-title').html("Editar Función");
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
                            let msg = xhr.responseJSON?.message ||
                            'Error al actualizar';
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: msg
                            });
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
                title: '¿Estás seguro de eliminar esta función?',
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
                                text: response.message ||
                                    'Función eliminada correctamente.'
                            });
                        },
                        error: function(xhr) {
                            let msg = xhr.responseJSON?.message || 'Error al eliminar';
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: msg
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
