@extends('adminlte::page')

@section('title', 'Marcas')

<!--@section('content_header')
@stop-->

@section('content')
    <div class="p-2"></div>
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary float-right" id="btnNuevo"><i class="fas fa-folder-plus"></i>
                Nuevo</button>
            <h3>Marcas</h3>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered text-center" id="datatable">
                <thead class="thead-dark">
                    <tr>
                        <th>Logo</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Creación</th>
                        <th>Actualización</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brands as $brand)
                        <tr>
                            <td>
                                    <img src="{{ $brand->logo ? asset('storage/' . $brand->logo) : asset('storage/brand_logo/no_image.png') }}" 
                                    alt="" width="80px" height="50px">
                            </td>
                            <td>{{ $brand->name }}</td>
                            <td>{{ $brand->description }}</td>
                            <td>{{ $brand->created_at }}</td>
                            <td>{{ $brand->updated_at }}</td>
                            <td>
                                <button class="btn btn-success btn-sm btnEditar" id="{{ $brand->id }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </td>
                            <td>
                                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="frmDelete">
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
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
        $(document).ready(function() {
            // Inicializa DataTable solo para formato, paginación y búsqueda
            $('#datatable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
                }
            });

            // Botón Nuevo
            $('#btnNuevo').click(function() {
                console.log('Click en Nuevo');
                $.ajax({
                    url: "{{ route('admin.brands.create') }}",
                    type: "GET",
                    success: function(response) {
                        // Usa el id correcto para el título del modal
                        $('#ModalLongTitle').html("Nueva marca");
                        $('#ModalCenter .modal-body').html(response);
                        $('#ModalCenter').modal('show');
            
                        // Evita múltiples binds al evento submit
                        $('#ModalCenter').off('submit', 'form').on('submit', 'form', function(e) {
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
                                    }).then(() => {
                                        location.reload(); // Recarga la tabla solo después de aceptar
                                    });
                                },
                                error: function(xhr) {
                                    var response = xhr.responseJSON;
                                    Swal.fire({
                                        title: "Error",
                                        icon: "error",
                                        text: response && response.message ? response.message : (xhr.responseText ? xhr.responseText : "Ocurrió un error"),
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
                    url: "{{ route('admin.brands.edit', 'id') }}".replace('id', id),
                    type: "GET",
                    success: function(response) {
                        $('.modal-title').html("Editar marca");
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
                                    }).then(() => {
                                        location.reload(); // Recarga la tabla solo después de aceptar
                                    });
                                },
                                error: function(xhr) {
                                    var response = xhr.responseJSON;
                                    Swal.fire({
                                        title: "Error",
                                        icon: "error",
                                        text: response.message,
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
                                location.reload(); // Recarga la tabla
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
                                    text: response.message,
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
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
