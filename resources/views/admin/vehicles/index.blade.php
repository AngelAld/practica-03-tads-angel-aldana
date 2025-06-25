@extends('adminlte::page')

@section('title', 'Vehículos')

@section('content')
    <div class="p-2"></div>
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary float-right" id="btnNuevo"><i class="fas fa-folder-plus"></i>
                Nuevo</button>
            <h3>Vehículos</h3>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered text-center" id="datatable">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Placa</th>
                        <th>Año</th>
                        <th>Cap. Carga</th>
                        <th>Descripción</th>
                        <th>Cap. Combustible</th>
                        <th>Ocupantes</th>
                        <th>Estado</th>
                        <th>Modelo</th>
                        <th>Color</th>
                        <th>Marca</th>
                        <th>Tipo</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->id }}</td>
                            <td>{{ $vehicle->name }}</td>
                            <td>{{ $vehicle->code }}</td>
                            <td>{{ $vehicle->plate }}</td>
                            <td>{{ $vehicle->year }}</td>
                            <td>{{ $vehicle->load_capacity }}</td>
                            <td>{{ $vehicle->description }}</td>
                            <td>{{ $vehicle->fuel_capacity }}</td>
                            <td>{{ $vehicle->ocuppants }}</td>
                            <td>
                                @if ($vehicle->status)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>{{ $vehicle->model?->name }}</td>
                            <td>{{ $vehicle->color?->name }}</td>
                            <td>{{ $vehicle->brand?->name }}</td>
                            <td>{{ $vehicle->type?->name }}</td>
                            <td>
                                <button class="btn btn-success btn-sm btnEditar" id="{{ $vehicle->id }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </td>
                            <td>
                                <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST"
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
        const destroyRoute = "{{ route('admin.vehicles.destroy', ['vehicle' => 'VEHICLE_ID']) }}";
        const csrfToken = "{{ csrf_token() }}";
    </script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                ajax: '{{ route('admin.vehicles.index') }}',
                columns: [{
                        data: 'id',
                        title: 'ID'
                    },
                    {
                        data: 'name',
                        title: 'Nombre'
                    },
                    {
                        data: 'code',
                        title: 'Código'
                    },
                    {
                        data: 'plate',
                        title: 'Placa'
                    },
                    {
                        data: 'year',
                        title: 'Año'
                    },
                    {
                        data: 'load_capacity',
                        title: 'Cap. Carga'
                    },
                    {
                        data: 'description',
                        title: 'Descripción'
                    },
                    {
                        data: 'fuel_capacity',
                        title: 'Cap. Combustible'
                    },
                    {
                        data: 'ocuppants',
                        title: 'Ocupantes'
                    },
                    {
                        data: 'status',
                        title: 'Estado'
                    },
                    {
                        data: 'model',
                        title: 'Modelo'
                    },
                    {
                        data: 'color',
                        title: 'Color'
                    },
                    {
                        data: 'brand',
                        title: 'Marca'
                    },
                    {
                        data: 'type',
                        title: 'Tipo'
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
                            let actionUrl = destroyRoute.replace('VEHICLE_ID', data);
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
                    url: "{{ route('admin.vehicles.create') }}",
                    type: "GET",
                    success: function(response) {
                        $('#ModalLongTitle').html("Nuevo vehículo");
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

            // Botón Editar
            $(document).on('click', '.btnEditar', function() {
                var id = $(this).attr("id");

                $.ajax({
                    url: "{{ route('admin.vehicles.edit', 'id') }}".replace('id', id),
                    type: "GET",
                    success: function(response) {
                        $('.modal-title').html("Editar vehículo");
                        $('#ModalCenter .modal-body').html(response);
                        $('#ModalCenter').modal('show');
                        // Espera a que el script del formulario esté cargado
                        setTimeout(function() {
                            // Solo continúa si renderGallery ya está disponible
                            if (typeof window.renderGallery === 'function') {
                                let vehicleId = window.vehicleId;
                                if (vehicleId) {
                                    $.get(`/admin/vehicles/${vehicleId}/images`,
                                        function(images) {
                                            window.existingImages = images;
                                            window.portadaExistingId = images.find(
                                                    img => img.is_profile)?.id ||
                                                null;
                                            window.imagesArray = [];
                                            window.portadaIndex = null;
                                            window.renderGallery();
                                        });
                                }
                            }
                        }, 300);
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
