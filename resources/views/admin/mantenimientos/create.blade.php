{!! Form::open(['route' => 'admin.mantenimientos.store', 'method' => 'POST']) !!}
@include('admin.mantenimientos.template.form')
<button type="submit" class="btn btn-primary">Registrar</button>
{!! Form::close() !!}
