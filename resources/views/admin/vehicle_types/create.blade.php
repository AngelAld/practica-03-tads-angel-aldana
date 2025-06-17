{!! Form::open(['route' => 'admin.vehicle_types.store', 'method' => 'POST']) !!}
@include('admin.vehicle_types.template.form')
<button type="submit" class="btn btn-primary">Registrar</button>
{!! Form::close() !!}
