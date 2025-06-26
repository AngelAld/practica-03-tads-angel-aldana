{!! Form::model($horario, [
    'route' => ['admin.mantenimientos.horarios.update', $mantenimiento, $horario],
    'method' => 'PUT',
]) !!}
@include('admin.horarios.template.form')
<button type="submit" class="btn btn-primary">Actualizar</button>
{!! Form::close() !!}
