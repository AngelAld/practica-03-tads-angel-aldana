{!! Form::model($schedule_status, [
    'route' => ['admin.schedule_statuses.update', $schedule_status],
    'method' => 'PUT',
]) !!}
@include('admin.schedule_statuses.template.form')
<button type="submit" class="btn btn-primary">Actualizar</button>
{!! Form::close() !!}
