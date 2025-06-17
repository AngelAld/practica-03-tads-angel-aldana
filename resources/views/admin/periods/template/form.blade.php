<div class="row">
    <div class="col-12">
        <div class="form-group">
            {!! Form::label('name', 'Nombre del Periodo') !!}
            {!! Form::text('name', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese el nombre del periodo',
                'required',
                'id' => 'name',
            ]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('status', 'Estado') !!}
            {!! Form::select('status', ['1' => 'Activo', '0' => 'Inactivo'], null, [
                'class' => 'form-control',
                'id' => 'status',
            ]) !!}
        </div>
    </div>
</div>
