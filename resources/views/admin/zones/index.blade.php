@extends('adminlte::page')

@section('title', 'Zonas')

<!--@section('content_header')
@stop-->

@section('content')
    <div class="p-2"></div>
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary float-right" id="btnNuevo"><i class="fas fa-folder-plus"></i>
                Nuevo</button>
            <h3>Zonas</h3>
        </div>
        <div class="card-body">
            <table class="table table-sm table-bordered text-center" id="datatable">
                <thead class="thead-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Requerimiento de carga</th>
                        <th>Distrito</th>
                        <th>Ver Coordenadas</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($zones as $zone)
                        <tr>
                            <td>{{ $zone->name }}</td>
                            <td>{{ $zone->description }}</td>
                            <td>{{ $zone->load_requirement }}</td>
                            <td>{{ $zone->district->name }}</td>
                            <td> <a href="{{ route('admin.zones.show', $zone->id) }}">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i></button>
                                </a>
                            </td>
                            <td><button class="btn btn-success btn-sm btnEditar" id="{{ $zone->id }}">
                                    <i class="fas fa-pen"></i></button>
                            </td>
                            <td>
                                <form action="{{ route('admin.zones.destroy', $zone->id) }}" method="POST"
                                    class="frmDelete">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                            class="fas fa-trash"></i></button>
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
    <script>
        var showUrl = "{{ route('admin.zones.show', ['zone' => 'ZONE_ID']) }}";
        var destroyRoute = "{{ route('admin.zones.destroy', ['zone' => 'ZONE_ID']) }}";

        $(document).ready(function() {
            $('#datatable').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.3.2/i18n/es-ES.json'
                },
                responsive: true,
                autoWidth: false,
                "ajax": "{{ route('admin.zones.index') }}",
                "columns": [{
                        "data": "name"
                    },
                    {
                        "data": "description"
                    },
                    {
                        "data": "load_requirement"
                    },
                    {
                        "data": "district.name"
                    },
                    {
                        "data": "id",
                        "orderable": false,
                        "searchable": false,
                        "width": "4%",
                        "render": function(data, type, row) {
                            var url = showUrl.replace('ZONE_ID', data);
                            return '<a href="' + url + '"><button class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button></a>';
                        }
                    },
                    {
                        "data": "id",
                        "orderable": false,
                        "searchable": false,
                        "width": "4%",
                        "render": function(data, type, row) {
                            return '<button class="btn btn-success btn-sm btnEditar" id="' + data +
                                '"><i class="fas fa-pen"></i></button>';
                        }
                    },
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            // Reemplaza ZONE_ID por el id real
                            let actionUrl = destroyRoute.replace('ZONE_ID', data);
                            return `
                                <form action="${actionUrl}" method="POST" class="frmDelete">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            `;
                        }
                    }
                ]
            });
        })

        $('#btnNuevo').click(function() {
            $.ajax({
                url: "{{ route('admin.zones.create') }}",
                type: "GET",
                success: function(response) {
                    $('.modal-title').html("Nueva zona");
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
                        })
                    })
                }
            })
        })


        // $('#datatable').on('click', '.btnCoords', function() {
        //     var id = $(this).attr("id");
        //     // redireccionar a la ruta de show
        //     window.location.href = "{{ route('admin.zones.show', 'id') }}".replace('id', id);
        // })

        $(document).on('click', '.btnEditar', function() {
            var id = $(this).attr("id");
            $.ajax({
                url: "{{ route('admin.zones.edit', 'id') }}".replace('id', id),
                type: "GET",
                success: function(response) {
                    $('.modal-title').html("Editar zona");
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
                        })
                    })
                }
            })
        })

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
                    //this.submit();
                    $.ajax({
                        url: form.attr('action'),
                        type: form.attr('method'),
                        data: form.serialize(),
                        success: function(response) {
                            refreshTable();
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
        })

        function refreshTable() {
            var table = $('#datatable').DataTable();
            table.ajax.reload(null, false);
        }
    </script>


    @if (session('success'))
        <script>
            Swal.fire({
                title: "Proceso exitoso",
                icon: "success",
                text: "{{ session('success') }}",
                draggable: true
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                title: "Error",
                icon: "error",
                text: "{{ session('error') }}",
                draggable: true
            });
        </script>
    @endif
@endsection