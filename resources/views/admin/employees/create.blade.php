{!! Form::open(['route' => 'admin.employees.store', 'method' => 'POST', 'files' => true]) !!}
@include('admin.employees.template.form')
<button type="submit" class="btn btn-primary">Registrar</button>
{!! Form::close() !!}
