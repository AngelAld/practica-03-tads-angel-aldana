{!! Form::model($detalle, [
    'route' => ['admin.mantenimientos.horarios.detalles.update', $mantenimiento, $horario, $detalle],
    'method' => 'PUT',
    'files' => true,
]) !!}
@include('admin.detalle_horario.template.form')
<button type="submit" class="btn btn-primary">Actualizar</button>
{!! Form::close() !!}
