<div class="form-group">
    {!! Form::label('nombre', 'Nombre') !!}
    {!! Form::text('nombre', null, [
        'class' => 'form-control',
        'placeholder' => 'Ingrese el nombre',
        'required',
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('fecha_inicio', 'Fecha inicio') !!}
    {!! Form::date('fecha_inicio', null, [
        'class' => 'form-control',
        'required',
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('fecha_fin', 'Fecha fin') !!}
    {!! Form::date('fecha_fin', null, [
        'class' => 'form-control',
        'required',
    ]) !!}
</div>
