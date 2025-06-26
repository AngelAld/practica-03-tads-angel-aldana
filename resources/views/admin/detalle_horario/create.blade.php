{!! Form::open([
    'route' => ['admin.mantenimientos.horarios.detalles.store', $mantenimiento, $horario],
    'method' => 'POST',
    'files' => true,
]) !!}
@include('admin.detalle_horario.template.form')
<button type="submit" class="btn btn-primary">Registrar</button>
{!! Form::close() !!}
