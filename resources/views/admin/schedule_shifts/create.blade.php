{!! Form::open(['route' => 'admin.schedule_shifts.store', 'method' => 'POST']) !!}
@include('admin.schedule_shifts.template.form')
<button type="submit" class="btn btn-primary">Registrar</button>
{!! Form::close() !!}
