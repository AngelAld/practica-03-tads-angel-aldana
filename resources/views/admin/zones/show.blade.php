@extends('adminlte::page')

@section('title', 'Detalle de la Zona')

@section('content')
    <div class="p-2"></div>
    <div class="card">
        <div class="card-header">
            <h3>Detalle de la Zona</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 card">
                    <div class="row card-body">
                        <div class="col-md-6">
                            <p><strong>Nombre:</strong> {{ $zone->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Descripción:</strong> {{ $zone->description }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Carga Requerida:</strong> {{ $zone->load_requirement }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Distrito:</strong> {{ $zone->district->name }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-[90]">
                        <div class="card-header">
                            <h3>Coordenadas</h3>
                        </div>
                        <div class="card-body">
                            <div id="coords-list">
                                <!-- Aquí se renderiza la lista de coordenadas vía JS -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>Mapa</h3>
                        </div>
                        <div class="card-body">
                            <div id="map" style="width: 100%; height: 400px;"></div>
                        </div>
                    </div>
                </div>

                <div class="cards">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Guardar Coordenadas</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        let map;
        let drawingManager;
        let polygon = null;
        let polygonCoords = [];

        // Si tienes coordenadas existentes, pásalas desde PHP (sino, será null o [])
        const initialPolygonCoords = @json($vertice ?? []);

        // Renderiza la lista de coordenadas con botones de eliminar
        function renderCoordsList() {
            const listDiv = document.getElementById('coords-list');
            if (!listDiv) return;
            if (polygonCoords.length === 0) {
                listDiv.innerHTML = '<p>No hay coordenadas.</p>';
                return;
            }
            let html = '';
            polygonCoords.forEach((coord, idx) => {
                html += `<div class='card card-body mb-2 p-2'>
                    <div class='row align-items-center'>
                        <div class='col-5'><strong>Lat:</strong> ${coord.lat.toFixed(6)}</div>
                        <div class='col-5'><strong>Lng:</strong> ${coord.lng.toFixed(6)}</div>
                        <div class='col-2 text-end'>
                            <button class='btn btn-danger btn-sm' onclick='removeCoord(${idx})' title='Eliminar coordenada'>&times;</button>
                        </div>
                    </div>
                </div>`;
            });
            listDiv.innerHTML = html;
        }

        // Elimina una coordenada y actualiza el polígono
        window.removeCoord = function(idx) {
            if (polygonCoords.length <= 3) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No permitido',
                    text: 'Un polígono debe tener al menos 3 coordenadas.',
                });
                return;
            }
            Swal.fire({
                title: '¿Eliminar coordenada?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    polygonCoords.splice(idx, 1);
                    if (polygon) {
                        polygon.setPath(polygonCoords);
                        updatePolygonCoords(polygon); // Sincroniza lista y array con el polígono real
                    } else {
                        renderCoordsList();
                    }
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminada!',
                        text: 'La coordenada fue eliminada.'
                    });
                }
            });
        }

        function initMap() {
            // Si hay coordenadas, centra el mapa en la primera; si no, usa ubicación del navegador
            if (initialPolygonCoords.length > 0) {
                const center = initialPolygonCoords[0];
                loadMap(center.lat, center.lng, initialPolygonCoords);
            } else if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    loadMap(position.coords.latitude, position.coords.longitude, []);
                });
            } else {
                // Fallback: centro genérico // USAT
                loadMap(-6.7604091251747125, -79.86302451147284, []);
            }
        }

        function loadMap(lat, lng, coords) {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat,
                    lng
                },
                zoom: 17,
            });

            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: coords.length === 0 ? google.maps.drawing.OverlayType.POLYGON : null,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: ['polygon'],
                },
                polygonOptions: {
                    editable: true,
                    draggable: false,
                },
            });

            drawingManager.setMap(map);

            // Si ya hay polígono, dibújalo y hazlo editable
            if (coords.length > 0) {
                polygon = new google.maps.Polygon({
                    paths: coords,
                    editable: true,
                    map: map,
                });
                updatePolygonCoords(polygon);

                // Escucha cambios en el polígono
                google.maps.event.addListener(polygon.getPath(), 'set_at', () => updatePolygonCoords(polygon));
                google.maps.event.addListener(polygon.getPath(), 'insert_at', () => updatePolygonCoords(polygon));
                google.maps.event.addListener(polygon.getPath(), 'remove_at', () => updatePolygonCoords(polygon));
            }

            // Cuando se termine de dibujar un polígono
            google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
                if (polygon) polygon.setMap(null); // Elimina el anterior
                polygon = event.overlay;
                polygon.setEditable(true);
                updatePolygonCoords(polygon);

                // Escucha cambios en el nuevo polígono
                google.maps.event.addListener(polygon.getPath(), 'set_at', () => updatePolygonCoords(polygon));
                google.maps.event.addListener(polygon.getPath(), 'insert_at', () => updatePolygonCoords(polygon));
                google.maps.event.addListener(polygon.getPath(), 'remove_at', () => updatePolygonCoords(polygon));
            });
        }

        function updatePolygonCoords(poly) {
            polygonCoords = poly.getPath().getArray().map(latlng => ({
                lat: latlng.lat(),
                lng: latlng.lng()
            }));
            renderCoordsList();
            // document.getElementById('polygon-coords').textContent = JSON.stringify(polygonCoords, null, 2);

            console.log(polygonCoords);
            // Aquí puedes preparar el envío al backend cuando lo necesites
        }

        window.initMap = initMap;

        // Inicializa la lista al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(renderCoordsList, 500); // Espera a que JS cargue coords iniciales

            // Evento para guardar coordenadas
            const saveBtn = document.querySelector('button.btn.btn-primary[data-dismiss="modal"]');
            if (saveBtn) {
                saveBtn.addEventListener('click', function() {
                    Swal.fire({
                        title: '¿Guardar coordenadas?',
                        text: '¿Deseas guardar los cambios en las coordenadas del polígono?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#aaa',
                        confirmButtonText: 'Sí, guardar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Aquí puedes hacer el envío al backend si lo deseas
                            Swal.fire({
                                icon: 'success',
                                title: '¡Guardado!',
                                text: 'Las coordenadas han sido guardadas.'
                            });
                        }
                    });
                });
            }
        });
    </script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=drawing&callback=initMap"
        async defer></script>

@endsection
