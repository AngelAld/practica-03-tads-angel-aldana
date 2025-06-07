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
    </div>
</div>
