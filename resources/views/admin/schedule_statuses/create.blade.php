{!! Form::open(['route' => 'admin.schedule_statuses.store', 'method' => 'POST']) !!}
@include('admin.schedule_statuses.template.form')
<button type="submit" class="btn btn-primary">Registrar</button>
{!! Form::close() !!}