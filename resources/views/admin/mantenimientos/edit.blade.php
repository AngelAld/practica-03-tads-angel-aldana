{!! Form::model($mantenimiento, ['route' => ['admin.mantenimientos.update', $mantenimiento], 'method' => 'PUT']) !!}
@include('admin.mantenimientos.template.form')
<button type="submit" class="btn btn-primary">Actualizar</button>
{!! Form::close() !!}
