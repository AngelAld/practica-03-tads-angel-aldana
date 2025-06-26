@extends('adminlte::page')

@section('title', 'Horarios de Mantenimiento')

@section('content')
    <div class="p-2"></div>
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary float-right" id="btnNuevoHorario">
                <i class="fas fa-folder-plus"></i> Nuevo
            </button>
            <h3>{{ $mantenimiento->nombre }}</h3>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered text-center" id="datatable-horarios">
                <thead class="thead-dark">
                    <tr>

                        <th>Día</th>
                        <th>Vehículo</th>
                        <th>Responsable</th>
                        <th>Tipo</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Actividades</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ModalHorario" tabindex="-1" role="dialog" aria-labelledby="ModalHorarioTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalHorarioTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        const destroyRoute =
            "{{ route('admin.mantenimientos.horarios.destroy', [$mantenimiento, 'horario' => 'HORARIO_ID']) }}";
        const csrfToken = "{{ csrf_token() }}";

        $(document).ready(function() {
            let table = $('#datatable-horarios').DataTable({
                ajax: "{{ route('admin.mantenimientos.horarios.index', $mantenimiento) }}",
                columns: [{
                        data: 'dia_de_la_semana'
                    },
                    {
                        data: 'vehicle.name'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {

                            if (row.employee) {
                                return row.employee.names + ' ' + row.employee.lastnames;
                            }
                            return '';
                        }
                    },
                    {
                        data: 'tipo'
                    },
                    {
                        data: 'hora_inicio',
                        render: function(data) {

                            if (data && data.length >= 5) return data.substring(0, 5);
                            return data ?? '';
                        }
                    },
                    {
                        data: 'hora_fin',
                        render: function(data) {
                            if (data && data.length >= 5) return data.substring(0, 5);
                            return data ?? '';
                        }
                    },
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            let url =
                                "{{ route('admin.mantenimientos.horarios.detalles.index', [$mantenimiento, 'horario' => 'HORARIO_ID']) }}"
                                .replace('HORARIO_ID', data);
                            return `<a href="${url}" class="btn btn-secondary btn-sm" title="Ver detalles">
                                        <i class="fas fa-tools"></i>
                                    </a>`;
                        }
                    },
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `<button class="btn btn-success btn-sm btnEditarHorario" id="${data}"><i class="fas fa-pen"></i></button>`;
                        }
                    },
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            let actionUrl = destroyRoute.replace('HORARIO_ID', data);
                            return `
                                <form action="${actionUrl}" method="POST" class="frmDeleteHorario" style="display:inline;">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            `;
                        }
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
                }
            });

            // Botón Nuevo
            $('#btnNuevoHorario').click(function() {
                $.ajax({
                    url: "{{ route('admin.mantenimientos.horarios.create', $mantenimiento) }}",
                    type: "GET",
                    success: function(response) {
                        $('#ModalHorarioTitle').html("Nuevo horario");
                        $('#ModalHorario .modal-body').html(response);
                        $('#ModalHorario').modal('show');
                        $('#ModalHorario').off('submit', 'form').on('submit', 'form', function(
                            e) {
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
                                    $('#ModalHorario').modal('hide');
                                    Swal.fire({
                                        title: "Proceso exitoso",
                                        icon: "success",
                                        text: response.message,
                                        draggable: true
                                    });
                                    table.ajax.reload(null, false);
                                },
                                error: function(xhr) {
                                    var response = xhr.responseJSON;
                                    Swal.fire({
                                        title: "Error",
                                        icon: "error",
                                        text: response && response
                                            .message ? response
                                            .message : (xhr
                                                .responseText ? xhr
                                                .responseText :
                                                "Ocurrió un error"),
                                        draggable: true
                                    });
                                }
                            });
                        });
                    }
                });
            });

            // Botón Editar
            $(document).on('click', '.btnEditarHorario', function() {
                var id = $(this).attr("id");
                $.ajax({
                    url: "{{ route('admin.mantenimientos.horarios.edit', [$mantenimiento, 'horario' => 'id']) }}"
                        .replace('id', id),
                    type: "GET",
                    success: function(response) {
                        $('#ModalHorarioTitle').html("Editar horario");
                        $('#ModalHorario .modal-body').html(response);
                        $('#ModalHorario').modal('show');
                        $('#ModalHorario').off('submit', 'form').on('submit', 'form', function(
                            e) {
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
                                    $('#ModalHorario').modal('hide');
                                    Swal.fire({
                                        title: "Proceso exitoso",
                                        icon: "success",
                                        text: response.message,
                                        draggable: true
                                    });
                                    table.ajax.reload(null, false);
                                },
                                error: function(xhr) {
                                    var response = xhr.responseJSON;
                                    Swal.fire({
                                        title: "Error",
                                        icon: "error",
                                        text: response && response
                                            .message ? response
                                            .message : (xhr
                                                .responseText ? xhr
                                                .responseText :
                                                "Ocurrió un error"),
                                        draggable: true
                                    });
                                }
                            });
                        });
                    }
                });
            });

            // Botón Eliminar
            $(document).on('submit', '.frmDeleteHorario', function(e) {
                e.preventDefault();
                var form = $(this);
                Swal.fire({
                    title: "Está seguro de eliminar?",
                    text: "Este proceso no es reversible!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, eliminar!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            type: form.attr('method'),
                            data: form.serialize(),
                            success: function(response) {
                                Swal.fire({
                                    title: "Proceso exitoso",
                                    icon: "success",
                                    text: response.message,
                                    draggable: true
                                });
                                table.ajax.reload(null, false);
                            },
                            error: function(xhr) {
                                var response = xhr.responseJSON;
                                Swal.fire({
                                    title: "Error",
                                    icon: "error",
                                    text: response && response.message ?
                                        response.message : (xhr.responseText ?
                                            xhr.responseText :
                                            "Ocurrió un error"),
                                    draggable: true
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
