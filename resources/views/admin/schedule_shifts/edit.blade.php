{!! Form::model($schedule_shift, [
    'route' => ['admin.schedule_shifts.update', $schedule_shift],
    'method' => 'PUT',
]) !!}
@include('admin.schedule_shifts.template.form')
<button type="submit" class="btn btn-primary">Actualizar</button>
{!! Form::close() !!}