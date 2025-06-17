<div class="row">
    <div class="col-md-7">
        <div class="form-row">
            <div class="form-group col-md-12">
                {!! Form::label('name', 'Nombre') !!}
                {!! Form::text('name', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese el nombre',
                    'required',
                ]) !!}
            </div>
            <div class="form-group col-md-12">
                {!! Form::label('load_requirement', 'Carga Requerida') !!}
                {!! Form::text('load_requirement', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese la carga requerida',
                    'required',
                ]) !!}
            </div>

            {{-- Selector de distritos --}}
            <div class="form-group col-md-12">
                {!! Form::label('district_id', 'Distrito') !!}
                {!! Form::select('district_id', $districts, null, [
                    'class' => 'form-control',
                    'required',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-row">
            <div class="form-group col-md-12">
                {!! Form::label('description', 'Descripción') !!}
                {!! Form::textarea('description', null, [
                    'class' => 'form-control',
                    'placeholder' => 'Ingrese la descripción',
                    'rows' => 6,
                    'required',
                ]) !!}
            </div>
            {{-- <div class="form-group col-md-12">
                {!! Form::label('status', 'Estado') !!}
                {!! Form::select('status', [1 => 'Activo', 0 => 'Inactivo'], null, [
                    'class' => 'form-control',
                    'required',
                ]) !!}
            </div> --}}
        </div>
    </div>
