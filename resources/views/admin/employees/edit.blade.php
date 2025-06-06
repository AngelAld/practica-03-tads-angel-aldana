{!! Form::model($employee, [
    'route' => ['admin.employees.update', $employee],
    'method' => 'PUT',
    'files' => true,
]) !!}
@include('admin.employees.template.form')
<button type="submit" class="btn btn-primary">Actualizar</button>
{!! Form::close() !!}
