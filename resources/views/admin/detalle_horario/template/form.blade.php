<div class="form-group">
    {!! Form::label('descripcion', 'Descripción') !!}
    {!! Form::text('descripcion', null, [
        'class' => 'form-control',
        'required',
        'placeholder' => 'Ingrese una descripción',
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('fecha', 'Fecha') !!}
    {!! Form::date('fecha', null, ['class' => 'form-control', 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('imagen', 'Imagen') !!}
    {!! Form::file('imagen', ['class' => 'form-control-file']) !!}
    @if (isset($detalle) && $detalle->imagen)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $detalle->imagen) }}" alt="Imagen" width="100">
        </div>
    @endif
</div>
