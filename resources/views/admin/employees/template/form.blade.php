<div class="row">
    <div class="col-md-8">
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('names', 'Nombres') !!}
                {!! Form::text('names', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese los nombres',
                    'required',
                ]) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('lastnames', 'Apellidos') !!}
                {!! Form::text('lastnames', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese los apellidos',
                    'required',
                ]) !!}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('dni', 'DNI') !!}
                {!! Form::text('dni', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el DNI',
                    'required',
                ]) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('birthday', 'Fecha de Nacimiento') !!}
                {!! Form::date('birthday', null, [
                    'class' => 'form-control',
                    'required',
                ]) !!}
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('phone', 'Teléfono') !!}
                {!! Form::text('phone', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el teléfono',
                    'required',
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
            {!! Form::label('address', 'Dirección') !!}
            {!! Form::text('address', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese la dirección',
                'required',
            ]) !!}
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                {!! Form::label('email', 'Correo Electrónico') !!}
                {!! Form::email('email', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el correo electrónico',
                    'required',
                ]) !!}
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('license', 'Licencia') !!}
                {!! Form::text('license', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese la licencia (opcional)',
                ]) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('functions', 'Funciones') !!}
            <div class="row">
                @foreach ($functions as $id => $name)
                    <div class="col-md-6">
                        <div class="form-check">
                            {!! Form::checkbox(
                                'functions[]',
                                $id,
                                isset($employee) ? $employee->functions->where('pivot.status', 1)->contains($id) : false,
                                [
                                    'class' => 'form-check-input',
                                    'id' => "function_$id",
                                ],
                            ) !!}
                            {!! Form::label("function_$id", $name, ['class' => 'form-check-label']) !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group text-center">
            <div class="p-2 m-2" style="border: 1px solid #ccc; border-radius: 8px; background: #fafbfc;">
                {!! Form::file('photo', [
                    'class' => 'form-control-file d-none',
                    'accept' => 'image/*',
                    'id' => 'imgInput',
                ]) !!}
                <img id="imageButton"
                    src="{{ isset($employee) && $employee->photo ? asset('storage/' . $employee->photo) : asset('storage/employees/no_image.png') }}"
                    alt="Foto del Empleado" class="img-fluid"
                    style="max-width: 180px; max-height: 180px; object-fit: contain; border-radius: 8px; cursor: pointer; background: #fff;">
                <div class="mt-2 text-muted" style="font-size: 0.95em;">
                    Haz clic en la imagen para seleccionar una foto
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
        if (this.files[0]) {
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
