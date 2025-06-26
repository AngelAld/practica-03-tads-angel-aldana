@extends('adminlte::page')

@section('title', 'Detalles de Horario')

@section('content')
    <div class="p-2"></div>
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary float-right" id="btnNuevoDetalle">
                <i class="fas fa-folder-plus"></i> Nuevo
            </button>
            <h3>{{ $mantenimiento->nombre }} - {{ $horario->dia_de_la_semana }} - {{ $horario->vehicle->name }}</h3>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered text-center" id="datatable-detalles">
                <thead class="thead-dark">
                    <tr>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Imagen</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ModalDetalle" tabindex="-1" role="dialog" aria-labelledby="ModalDetalleTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalDetalleTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
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
            "{{ route('admin.mantenimientos.horarios.detalles.destroy', [$mantenimiento, $horario, 'detalle' => 'DETALLE_ID']) }}";
        const csrfToken = "{{ csrf_token() }}";

        $(document).ready(function() {
            let table = $('#datatable-detalles').DataTable({
                ajax: "{{ route('admin.mantenimientos.horarios.detalles.index', [$mantenimiento, $horario]) }}",
                columns: [{
                        data: 'fecha'
                    },
                    {
                        data: 'descripcion'
                    },
                    {
                        data: 'imagen',
                        render: function(data) {
                            if (data) {
                                return `<img src="/storage/${data}" alt="Imagen" width="60">`;
                            }
                            return '';
                        }
                    },
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `<button class="btn btn-success btn-sm btnEditarDetalle" id="${data}"><i class="fas fa-pen"></i></button>`;
                        }
                    },
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            let actionUrl = destroyRoute.replace('DETALLE_ID', data);
                            return `
                                <form action="${actionUrl}" method="POST" class="frmDeleteDetalle" style="display:inline;">
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
            $('#btnNuevoDetalle').click(function() {
                $.ajax({
                    url: "{{ route('admin.mantenimientos.horarios.detalles.create', [$mantenimiento, $horario]) }}",
                    type: "GET",
                    success: function(response) {
                        $('#ModalDetalleTitle').html("Nuevo detalle");
                        $('#ModalDetalle .modal-body').html(response);
                        $('#ModalDetalle').modal('show');
                        $('#ModalDetalle').off('submit', 'form').on('submit', 'form', function(
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
                                    $('#ModalDetalle').modal('hide');
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
            $(document).on('click', '.btnEditarDetalle', function() {
                var id = $(this).attr("id");
                $.ajax({
                    url: "{{ route('admin.mantenimientos.horarios.detalles.edit', [$mantenimiento, $horario, 'detalle' => 'id']) }}"
                        .replace('id', id),
                    type: "GET",
                    success: function(response) {
                        $('#ModalDetalleTitle').html("Editar detalle");
                        $('#ModalDetalle .modal-body').html(response);
                        $('#ModalDetalle').modal('show');
                        $('#ModalDetalle').off('submit', 'form').on('submit', 'form', function(
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
                                    $('#ModalDetalle').modal('hide');
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
            $(document).on('submit', '.frmDeleteDetalle', function(e) {
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
