@extends('adminlte::page')

@section('title', 'Estados de Horario')

@section('content')
    <div class="p-2"></div>
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary float-right" id="btnNuevo"><i class="fas fa-folder-plus"></i>
                Nuevo</button>
            <h3>Estados de Horario</h3>
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
                <tbody>
                    @foreach ($schedulestatuses as $schedulestatus)
                        <tr>
                            <td>{{ $schedulestatus->id }}</td>
                            <td>{{ $schedulestatus->name }}</td>
                            <td>{{ $schedulestatus->description }}</td>
                            <td>
                                <button class="btn btn-success btn-sm btnEditar" id="{{ $schedulestatus->id }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </td>
                            <td>
                                <form action="{{ route('admin.schedule_statuses.destroy', $schedulestatus->id) }}" method="POST"
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
    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLongTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- Aquí se carga el formulario --}}
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
        const destroyRoute = "{{ route('admin.schedule_statuses.destroy', ['schedule_status' => 'SCHEDULE_STATUS_ID']) }}";
        const csrfToken = "{{ csrf_token() }}";
    </script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                ajax: '{{ route('admin.schedule_statuses.index') }}',
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
                            return `<button class="btn btn-success btn-sm btnEditar" id="${data}"><i class="fas fa-pen"></i></button>`;
                        }
                    },
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            let actionUrl = destroyRoute.replace('SCHEDULE_STATUS_ID', data);
                            return `
                                <form action="${actionUrl}" method="POST" class="frmDelete">
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
            $('#btnNuevo').click(function() {
                $.ajax({
                    url: "{{ route('admin.schedule_statuses.create') }}",
                    type: "GET",
                    success: function(response) {
                        $('#ModalLongTitle').html("Nuevo estado de horario");
                        $('#ModalCenter .modal-body').html(response);
                        $('#ModalCenter').modal('show');
                        $('#ModalCenter').off('submit', 'form').on('submit', 'form', function(
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
                                    $('#ModalCenter').modal('hide');
                                    Swal.fire({
                                        title: "Proceso exitoso",
                                        icon: "success",
                                        text: response.message,
                                        draggable: true
                                    });
                                    $('#datatable').DataTable().ajax.reload(
                                        null, false
                                    );
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
            $(document).on('click', '.btnEditar', function() {
                var id = $(this).attr("id");
                $.ajax({
                    url: "{{ route('admin.schedule_statuses.edit', 'id') }}".replace('id', id),
                    type: "GET",
                    success: function(response) {
                        $('.modal-title').html("Editar estado de horario");
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
                                    Swal.fire({
                                        title: "Proceso exitoso",
                                        icon: "success",
                                        text: response.message,
                                        draggable: true
                                    });
                                    $('#datatable').DataTable().ajax.reload(
                                        null, false);
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
            $(document).on('submit', '.frmDelete', function(e) {
                e.preventDefault();
                var form = $(this);
                Swal.fire({
                    title: "¿Está seguro de eliminar?",
                    text: "¡Este proceso no es reversible!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "¡Sí, eliminar!",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            type: form.attr('method'),
                            data: form.serialize(),
                            success: function(response) {
                                form.closest('tr').remove();
                                Swal.fire({
                                    title: "Proceso exitoso",
                                    icon: "success",
                                    text: response.message,
                                    draggable: true
                                });
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

@section('css')
    {{-- Aquí puedes agregar estilos personalizados --}}
@stop
