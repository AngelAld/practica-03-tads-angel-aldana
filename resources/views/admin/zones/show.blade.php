@extends('adminlte::page')

@section('title', 'Detalle de la Zona')

@section('content')
    <div class="p-2"></div>
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Detalles de la Zona</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt fa-lg text-primary mr-2"></i>
                                        <span class="fw-bold me-2 mr-1">Nombre: </span> <span>{{ $zone->name }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-align-left fa-lg text-primary mr-2"></i>
                                        <span class="fw-bold me-2 mr-1">Descripción: </span>
                                        <span>{{ $zone->description }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-bolt fa-lg text-primary mr-2"></i>
                                        <span class="fw-bold me-2 mr-1">Carga Requerida: </span>
                                        <span>{{ $zone->load_requirement }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-city fa-lg text-primary mr-2"></i>
                                        <span class="fw-bold me-2 mr-1">Distrito: </span>
                                        <span>{{ $zone->district->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"> <i class="fas fa-map-marker-alt mr-2"></i>Mapa</h4>
                        </div>
                        <div class="card-body">
                            <div id="map" style="width: 100%; height: 400px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card h-[90]">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="fas fa-map-marker-alt mr-2"></i>Coordenadas</h4>
                        </div>
                        <div class="card-body coords-scroll">
                            <style>
                                .coords-scroll {
                                    height: 440px;
                                    overflow-y: auto;
                                    transition: box-shadow 0.2s;
                                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
                                }
                            </style>
                            <div id="coords-list">
                                <!-- Aquí se renderiza la lista de coordenadas vía JS -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Guardar Coordenadas</button>
        </div>
    </div>
@stop

@section('js')
    @php
        $coords = $zone->zone_coordinates->map(function($coord) {
            return ['lat' => (float)$coord->latitude, 'lng' => (float)$coord->longitude];
        })->values();
    @endphp
    <script>
        let map;
        let drawingManager;
        let polygon = null;
        let polygonCoords = @json($coords);

        // Si tienes coordenadas existentes, pásalas desde PHP (sino, será null o [])
        const initialPolygonCoords = @json($coords);

        // Markers para identificar los vértices
        let vertexMarkers = [];

        // Renderiza la lista de coordenadas con botones de eliminar y agrega markers numerados
        function renderCoordsList() {
            const listDiv = document.getElementById('coords-list');
            if (!listDiv) return;
            if (polygonCoords.length === 0) {
                listDiv.innerHTML = '<p>No hay coordenadas.</p>';
                clearVertexMarkers();
                return;
            }
            let html = '';
            polygonCoords.forEach((coord, idx) => {
                html += `<div class='card card-body mb-2 p-2'>
                    <div class='row align-items-center'>
                        <div class='col-2 text-center'><span class='badge bg-primary' style='font-size:1rem;'>${idx+1}</span></div>
                        <div class='col-4'><strong>Latitud:</strong> ${coord.lat.toFixed(6)}</div>
                        <div class='col-4'><strong>Longitud:</strong> ${coord.lng.toFixed(6)}</div>
                        <div class='col-2 text-end'>
                            <button class='btn btn-danger btn-sm' onclick='removeCoord(${idx})' title='Eliminar coordenada'>&times;</button>
                        </div>
                    </div>
                </div>`;
            });
            listDiv.innerHTML = html;
            updateVertexMarkers();
        }

        // Borra todos los markers de vértices
        function clearVertexMarkers() {
            vertexMarkers.forEach(marker => marker.setMap(null));
            vertexMarkers = [];
        }

        // Crea/actualiza los markers numerados para cada vértice
        function updateVertexMarkers() {
            clearVertexMarkers();
            if (!map || !polygonCoords || polygonCoords.length === 0) return;
            polygonCoords.forEach((coord, idx) => {
                const marker = new google.maps.Marker({
                    position: coord,
                    map: map,
                    label: {
                        text: String(idx + 1),
                        color: 'white',
                        fontWeight: 'bold',
                        fontSize: '14px',
                        backgroundColor: '#007bff',
                    },
                    icon: {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 10,
                        fillColor: '#007bff',
                        fillOpacity: 1,
                        strokeWeight: 2,
                        strokeColor: 'white',
                        anchor: new google.maps.Point(0, 1.5), // Mueve el círculo arriba de la coordenada
                        // labelOrigin: new google.maps.Point(0, -1) // Mueve el label aún más arriba
                    },
                    zIndex: 999,
                });
                vertexMarkers.push(marker);
            });
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
                    if (polygon) {
                        // Elimina el punto directamente del path del polígono
                        polygon.getPath().removeAt(idx);
                        // Los listeners ya actualizan la lista y el array
                    } else {
                        polygonCoords.splice(idx, 1);
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
                            fetch('{{ route('admin.zones.storeCoords') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    },
                                    body: JSON.stringify({
                                        zone_id: {{ $zone->id }},
                                        coords: polygonCoords
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success || data.status === 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: '¡Guardado!',
                                            text: data.message ||
                                                'Las coordenadas han sido guardadas.'
                                        }).then(() => {
                                            // retroceder a la lista de zonas
                                            window.location.href = "{{ route('admin.zones.index') }}";
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: data.message ||
                                                'Ocurrió un error al guardar las coordenadas.'
                                        });
                                    }
                                })
                                .catch(error => {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Error al guardar las coordenadas.'
                                    });
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
