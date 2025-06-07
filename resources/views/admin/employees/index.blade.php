@extends('adminlte::page')

@section('title', 'Empleados')

@section('content')
    <div class="p-2"></div>
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary float-right" id="btnNuevo"><i class="fas fa-folder-plus"></i>
                Nuevo</button>
            <h3>Empleados</h3>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered text-center" id="datatable">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>DNI</th>
                        <th>Fecha Nacimiento</th>
                        <th>Licencia</th>
                        <th>Dirección</th>
                        <th>Email</th>
                        <th>Foto</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->names }}</td>
                            <td>{{ $employee->lastnames }}</td>
                            <td>{{ $employee->dni }}</td>
                            <td>{{ $employee->birthday }}</td>
                            <td>{{ $employee->license }}</td>
                            <td>{{ $employee->address }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>
                                @if ($employee->photo)
                                    <img src="{{ asset('storage/' . $employee->photo) }}" alt="Foto" width="40">
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $employee->phone }}</td>
                            <td>
                                @if ($employee->status)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-success btn-sm btnEditar" id="{{ $employee->id }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </td>
                            <td>
                                <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST"
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
        const destroyRoute = "{{ route('admin.employees.destroy', ['employee' => 'EMPLOYEE_ID']) }}";
        const csrfToken = "{{ csrf_token() }}";
    </script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                ajax: '{{ route('admin.employees.index') }}',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'names'
                    },
                    {
                        data: 'lastnames'
                    },
                    {
                        data: 'dni'
                    },
                    {
                        data: 'birthday'
                    },
                    {
                        data: 'license'
                    },
                    {
                        data: 'address'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'photo',
                        render: function(data) {
                            if (data) {
                                return `<img src="/storage/${data}" alt="Foto" width="40">`;
                            }
                            return '-';
                        }
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'status',
                        render: function(data) {
                            return data ? '<span class="badge badge-success">Activo</span>' :
                                '<span class="badge badge-danger">Inactivo</span>';
                        }
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
                            // Reemplaza EMPLOYEE_ID por el id real
                            let actionUrl = destroyRoute.replace('EMPLOYEE_ID', data);
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
                    url: "{{ route('admin.employees.create') }}",
                    type: "GET",
                    success: function(response) {
                        $('#ModalLongTitle').html("Nuevo empleado");
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
                                    // Agrega la nueva fila a la tabla
                                    $('#datatable').DataTable().ajax.reload(
                                        null, false
                                    ); // Si usas AJAX en DataTable
                                    // O, si no usas AJAX en DataTable, puedes hacer una petición para obtener la nueva fila y agregarla manualmente
                                },
                                error: function(xhr) {
                                var response = xhr.responseJSON;
                                let msg = "Ocurrió un error";
                                if (response && response.errors) {
                                    msg = Object.values(response.errors).join('\n');
                                } else if (response && response.message) {
                                    msg = response.message;
                                } else if (xhr.responseText) {
                                    msg = xhr.responseText;
                                }
                                Swal.fire({
                                    title: "Error",
                                    icon: "error",
                                    text: msg,
                                    draggable: true
                                });
                            }
                        });
                    });
                });
            });

            // Botón Editar
            $(document).on('click', '.btnEditar', function() {
                var id = $(this).attr("id");
                $.ajax({
                    url: "{{ route('admin.employees.edit', 'id') }}".replace('id', id),
                    type: "GET",
                    success: function(response) {
                        $('.modal-title').html("Editar empleado");
                        $('#ModalCenter .modal-body').html(response);
                        $('#ModalCenter').modal('show');
                        // Solución: quitar handlers anteriores antes de agregar uno nuevo
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
                                    // Actualiza la fila editada
                                    $('#datatable').DataTable().ajax.reload(
                                        null, false);
                                },
                                error: function(xhr) {
                                var response = xhr.responseJSON;
                                let msg = "Ocurrió un error";
                                if (response && response.errors) {
                                    msg = Object.values(response.errors).join('\n');
                                } else if (response && response.message) {
                                    msg = response.message;
                                } else if (xhr.responseText) {
                                    msg = xhr.responseText;
                                }
                                Swal.fire({
                                    title: "Error",
                                    icon: "error",
                                    text: msg,
                                    draggable: true
                                });
                            }
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
                                // Elimina la fila del DOM
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
                            let msg = "Ocurrió un error";
                            if (response && response.errors) {
                                msg = Object.values(response.errors).join('\n');
                            } else if (response && response.message) {
                                msg = response.message;
                            } else if (xhr.responseText) {
                                msg = xhr.responseText;
                            }
                            Swal.fire({
                                title: "Error",
                                icon: "error",
                                text: msg,
                                draggable: true
                            });
                        }
                    });
                });
            });
        });
    </script>
@endsection

@section('css')
    {{-- Aquí puedes agregar estilos personalizados --}}
@stop
