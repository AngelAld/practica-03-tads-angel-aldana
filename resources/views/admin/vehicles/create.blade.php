{!! Form::open(['route' => 'admin.vehicles.store', 'method' => 'POST']) !!}
@include('admin.vehicles.template.form')
<button type="submit" class="btn btn-primary">Registrar</button>
{!! Form::close() !!}
