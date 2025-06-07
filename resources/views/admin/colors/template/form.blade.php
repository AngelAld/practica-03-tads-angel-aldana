<div class="form-group">
    {!! Form::label('name', 'Nombre del Color') !!}
    {!! Form::text('name', null, [
        'class' => 'form-control',
        'placeholder' => 'Ingrese el nombre del color',
        'required',
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('hex_code', 'Código HEX') !!}
    {!! Form::color('hex_code', null, [
        'class' => 'form-control',
        'placeholder' => '#FFFFFF',
        'required',
    ]) !!}
</div>