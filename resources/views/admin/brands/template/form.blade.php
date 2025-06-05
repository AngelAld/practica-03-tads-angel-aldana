<div class="row">
    <div class="col-8">
        <div class="form-group">
            {!! Form::label('name', 'Nombre de la Marca') !!}
            {!! Form::text('name', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese el nombre de la marca',
                'required',
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('description', 'Descripción de la Marca') !!}
            {!! Form::textarea('description', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese la descripción de la marca',
                'rows' => 4,
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::file('logo', ['class' => 'form-control-file d-none', 'accept' => 'image/*', 'id' => 'imgInput']) !!}
        </div>
    </div>
    <div class="col-4">
    <div class="form-group text-center">
        <div class="p-2 m-2" style="border: 1px solid #ccc; border-radius: 8px; background: #fafbfc;">
            <img
                id="imageButton"
                src="{{ isset($brand) && $brand->logo ? asset('storage/' . $brand->logo) : asset('storage/brand_logo/no_image.png') }}"
                alt="Logo de la Marca"
                class="img-fluid"
                style="max-width: 180px; max-height: 180px; object-fit: contain; border-radius: 8px; cursor: pointer; background: #fff;"
            >
            <div class="mt-2 text-muted" style="font-size: 0.95em;">
                Haz clic en la imagen para seleccionar un logo
            </div>
        </div>
    </div>
</div>
</div>

<script>
    document.getElementById('imageButton').addEventListener('click', function() {
        document.getElementById('imgInput').click();
    });

    document.getElementById('imgInput').addEventListener('change', function() {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imageButton').src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    });
</script>
