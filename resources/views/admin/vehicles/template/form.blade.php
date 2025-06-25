<div class="row">
    <div class="col-md-8">
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('name', 'Nombre') !!}
                {!! Form::text('name', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el nombre',
                    'required',
                ]) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('code', 'Código') !!}
                {!! Form::text('code', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el código',
                    'required',
                ]) !!}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('plate', 'Placa') !!}
                {!! Form::text('plate', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese la placa',
                    'required',
                ]) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('year', 'Año') !!}
                {!! Form::number('year', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el año',
                    'required',
                    'min' => 1900,
                    'max' => date('Y'),
                ]) !!}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('load_capacity', 'Capacidad de carga (kg)') !!}
                {!! Form::number('load_capacity', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese la capacidad de carga',
                    'required',
                    'min' => 0,
                ]) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('fuel_capacity', 'Capacidad de combustible (L)') !!}
                {!! Form::number('fuel_capacity', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese la capacidad de combustible',
                    'step' => '0.01',
                    'min' => 0,
                ]) !!}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('ocuppants', 'Ocupantes') !!}
                {!! Form::number('ocuppants', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el número de ocupantes',
                    'min' => 1,
                ]) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('status', 'Estado') !!}
                {!! Form::select('status', [1 => 'Activo', 0 => 'Inactivo'], null, [
                    'class' => 'form-control',
                    'required',
                ]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('description', 'Descripción') !!}
            {!! Form::textarea('description', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese una descripción',
                'rows' => 2,
            ]) !!}
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('brand_id', 'Marca') !!}
                {!! Form::select('brand_id', $brands, null, [
                    'class' => 'form-control',
                    'placeholder' => 'Seleccione una marca',
                    'required',
                ]) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('model_id', 'Modelo') !!}
                {!! Form::select('model_id', $models, null, [
                    'class' => 'form-control',
                    'placeholder' => 'Seleccione un modelo',
                    'required',
                ]) !!}
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('color_id', 'Color') !!}
                {!! Form::select('color_id', $colors, null, [
                    'class' => 'form-control',
                    'placeholder' => 'Seleccione un color',
                    'required',
                ]) !!}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                {!! Form::label('type_id', 'Tipo de vehículo') !!}
                {!! Form::select('type_id', $types, null, [
                    'class' => 'form-control',
                    'placeholder' => 'Seleccione un tipo',
                    'required',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <strong>Galería de imágenes</strong>
            </div>
            <div class="card-body">
                <div id="galleryImages" class="mb-3"></div>
                <input type="file" id="imagesInput" name="images[]" class="form-control mb-2" accept="image/*"
                    multiple>
                <small class="text-muted">Puedes seleccionar varias imágenes</small>
            </div>
        </div>
    </div>
</div>

<script>
    window.vehicleId = @json(isset($vehicle) ? $vehicle->id : null);
    window.imagesArray = [];
    window.portadaIndex = null;
    window.existingImages = [];
    window.portadaExistingId = null;

    window.renderGallery = function() {
        let html = '';

        // Imágenes existentes (del backend)
        existingImages.forEach((img, idx) => {
            html += `
            <div class="d-flex align-items-center mb-2" data-existing-id="${img.id}">
                <img src="/storage/${img.image_path}" style="width:80px;height:80px;object-fit:cover;border-radius:6px;">
                <div class="ml-2">
                    <button type="button" class="btn btn-danger btn-sm btnDeleteImage" data-id="${img.id}">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-${img.is_profile ? 'success' : 'secondary'} btnSetProfileExisting" data-id="${img.id}">
                        ${img.is_profile ? 'Portada' : 'Seleccionar portada'}
                    </button>
                </div>
            </div>`;
        });

        // Nuevas imágenes (aún no subidas)
        imagesArray.forEach((img, idx) => {
            let url = URL.createObjectURL(img);
            html += `
            <div class="d-flex align-items-center mb-2" data-idx="${idx}">
                <img src="${url}" style="width:80px;height:80px;object-fit:cover;border-radius:6px;">
                <div class="ml-2">
                    <button type="button" class="btn btn-danger btn-sm btnRemoveImage" data-idx="${idx}">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-${portadaIndex==idx?'success':'secondary'} btnSetPortada" data-idx="${idx}">
                        ${portadaIndex==idx?'Portada':'Seleccionar portada'}
                    </button>
                </div>
            </div>`;
        });

        $('#galleryImages').html(html);
    }

    function loadImages() {
        if (!vehicleId) return;
        $.get(`/admin/vehicles/${vehicleId}/images`, function(images) {
            let html = '';
            images.forEach(img => {
                html += `
                <div class="col-6 mb-2">
                    <div class="card">
                        <img src="/storage/${img.image_path}" class="card-img-top" style="height:100px;object-fit:cover;">
                        <div class="card-body p-2 text-center">
                            <button class="btn btn-sm btn-danger btnDeleteImage" data-id="${img.id}"><i class="fas fa-trash"></i></button>
                            <button class="btn btn-sm btn-${img.is_profile ? 'success' : 'secondary'} btnSetProfile" data-id="${img.id}">
                                ${img.is_profile ? 'Portada' : 'Seleccionar portada'}
                            </button>
                        </div>
                    </div>
                </div>`;
            });
            $('#vehicleImages').html(html);
        });
    }

    // Subir imagen
    $('#formUploadImage').on('submit', function(e) {
        e.preventDefault();
        if (!vehicleId) {
            alert('Guarda el vehículo antes de subir imágenes.');
            return;
        }
        let formData = new FormData(this);
        formData.append('vehicle_id', vehicleId);
        $.ajax({
            url: `/admin/vehicles/${vehicleId}/images`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function() {
                loadImages();
                $('#formUploadImage')[0].reset();
            }
        });
    });

    // Eliminar imagen
    $(document).on('click', '.btnDeleteImage', function() {
        let id = $(this).data('id');
        $.ajax({
            url: `/admin/vehicles/images/${id}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                // Elimina la imagen del arreglo local y actualiza la galería
                existingImages = existingImages.filter(img => img.id !== id);
                // Si la portada fue eliminada, asignar otra como portada
                if (portadaExistingId == id && existingImages.length) {
                    existingImages[0].is_profile = true;
                    portadaExistingId = existingImages[0].id;
                    $.post(`/admin/vehicles/images/${portadaExistingId}/set-profile`, {
                        _token: '{{ csrf_token() }}'
                    });
                } else if (portadaExistingId == id && imagesArray.length) {
                    portadaIndex = 0;
                    portadaExistingId = null;
                }
                renderGallery();
            }
        });
    });

    // Seleccionar portada
    $(document).on('click', '.btnSetProfile', function() {
        let id = $(this).data('id');
        $.post(`/admin/vehicles/images/${id}/set-profile`, {
            _token: '{{ csrf_token() }}'
        }, function() {
            loadImages();
        });
    });



    window.imagesArray = []; // Nuevas imágenes (File)
    window.portadaIndex = null; // Índice de la portada en imagesArray
    window.existingImages = []; // Imágenes ya subidas (del backend)
    window.portadaExistingId = null; // ID de la portada actual

    window.renderGallery = function() {
        let html = '';

        // Imágenes existentes (del backend)
        existingImages.forEach((img, idx) => {
            html += `
            <div class="d-flex align-items-center mb-2" data-existing-id="${img.id}">
                <img src="/storage/${img.image_path}" style="width:80px;height:80px;object-fit:cover;border-radius:6px;">
                <div class="ml-2">
                    <button type="button" class="btn btn-danger btn-sm btnDeleteImage" data-id="${img.id}">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-${img.is_profile ? 'success' : 'secondary'} btnSetProfileExisting" data-id="${img.id}">
                        ${img.is_profile ? 'Portada' : 'Seleccionar portada'}
                    </button>
                </div>
            </div>`;
        });

        // Nuevas imágenes (aún no subidas)
        imagesArray.forEach((img, idx) => {
            let url = URL.createObjectURL(img);
            html += `
            <div class="d-flex align-items-center mb-2" data-idx="${idx}">
                <img src="${url}" style="width:80px;height:80px;object-fit:cover;border-radius:6px;">
                <div class="ml-2">
                    <button type="button" class="btn btn-danger btn-sm btnRemoveImage" data-idx="${idx}">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-${portadaIndex==idx?'success':'secondary'} btnSetPortada" data-idx="${idx}">
                        ${portadaIndex==idx?'Portada':'Seleccionar portada'}
                    </button>
                </div>
            </div>`;
        });

        $('#galleryImages').html(html);
    }

    // Eliminar imagen nueva antes de guardar
    $(document).on('click', '.btnRemoveImage', function() {
        let idx = $(this).data('idx');
        imagesArray.splice(idx, 1);
        // Si la portada eliminada era la seleccionada, reasignar portada
        if (portadaIndex == idx) portadaIndex = imagesArray.length ? 0 : null;
        else if (portadaIndex > idx) portadaIndex--;
        renderGallery();
    });

    // Seleccionar portada entre nuevas imágenes
    $(document).on('click', '.btnSetPortada', function() {
        portadaIndex = $(this).data('idx');
        // Desmarcar portada existente
        portadaExistingId = null;
        existingImages.forEach(img => img.is_profile = false);
        renderGallery();
    });

    // Eliminar imagen existente (AJAX)
    $(document).on('click', '.btnDeleteImage', function() {
        let id = $(this).data('id');
        $.ajax({
            url: `/admin/vehicles/images/${id}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                // Elimina la imagen del arreglo local y actualiza la galería
                existingImages = existingImages.filter(img => img.id !== id);
                // Si la portada fue eliminada, asignar otra como portada
                if (portadaExistingId == id && existingImages.length) {
                    existingImages[0].is_profile = true;
                    portadaExistingId = existingImages[0].id;
                    $.post(`/admin/vehicles/images/${portadaExistingId}/set-profile`, {
                        _token: '{{ csrf_token() }}'
                    });
                } else if (portadaExistingId == id && imagesArray.length) {
                    portadaIndex = 0;
                    portadaExistingId = null;
                }
                renderGallery();
            }
        });
    });

    // Seleccionar portada entre imágenes existentes
    $(document).on('click', '.btnSetProfileExisting', function() {
        let id = $(this).data('id');
        $.post(`/admin/vehicles/images/${id}/set-profile`, {
            _token: '{{ csrf_token() }}'
        }, function() {
            existingImages.forEach(img => img.is_profile = (img.id == id));
            portadaExistingId = id;
            // Desmarcar portada de nuevas imágenes
            portadaIndex = null;
            renderGallery();
        });
    });

    // Seleccionar portada entre nuevas imágenes
    $(document).on('click', '.btnSetPortada', function() {
        portadaIndex = $(this).data('idx');
        // Desmarcar portada existente
        portadaExistingId = null;
        existingImages.forEach(img => img.is_profile = false);
        renderGallery();
    });

    // Submit del formulario principal
    $('#vehicleForm').off('submit').on('submit', function(e) {
        if (imagesArray.length > 0) {
            e.preventDefault();
            let form = this;
            let formData = new FormData(form);
            imagesArray.forEach((img, idx) => {
                formData.append('images[]', img);
            });
            // Si la portada es una imagen nueva
            if (portadaIndex !== null) {
                formData.append('portada', portadaIndex);
            }
            $.ajax({
                url: form.action,
                type: form.method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#ModalCenter').modal('hide');
                    Swal.fire({
                        title: "Proceso exitoso",
                        icon: "success",
                        text: response.message
                    });
                    $('#datatable').DataTable().ajax.reload(null, false);
                    // Limpia el input de archivos y el array
                    $('#imagesInput').val('');
                    imagesArray = [];
                    portadaIndex = null;
                },
                error: function(xhr) {
                    var response = xhr.responseJSON;
                    Swal.fire({
                        title: "Error",
                        icon: "error",
                        text: response && response.message ? response.message : (xhr
                            .responseText ? xhr.responseText : "Ocurrió un error"),
                    });
                }
            });
        }
        // Si no hay imágenes nuevas, deja que el submit siga su curso normal
    });

    // Evento para previsualizar y acumular imágenes seleccionadas
    $('#imagesInput').off('change').on('change', function(e) {
        const files = Array.from(e.target.files);
        // Evita duplicados: solo agrega archivos que no estén ya en imagesArray (por nombre y tamaño)
        files.forEach(file => {
            if (!imagesArray.some(img => img.name === file.name && img.size === file.size)) {
                imagesArray.push(file);
            }
        });
        // Si no hay portada seleccionada, selecciona la primera
        if (portadaIndex === null && imagesArray.length > 0) {
            portadaIndex = 0;
        }
        renderGallery();
        // Limpia el input para permitir volver a seleccionar el mismo archivo si se elimina
        $(this).val('');
    });
</script>
