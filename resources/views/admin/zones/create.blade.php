{!! Form::open(['route' => 'admin.zones.store', 'method' => 'POST', 'files' => true]) !!}
@include('admin.zones.template.form')
<button type="submit" class="btn btn-primary">Registrar</button>
{!! Form::close() !!}
