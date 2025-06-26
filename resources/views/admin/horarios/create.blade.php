{!! Form::open(['route' => ['admin.mantenimientos.horarios.store', $mantenimiento], 'method' => 'POST']) !!}
@include('admin.horarios.template.form')
<button type="submit" class="btn btn-primary">Registrar</button>
{!! Form::close() !!}
