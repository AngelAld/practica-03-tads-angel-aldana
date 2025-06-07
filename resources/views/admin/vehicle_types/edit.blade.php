{!! Form::model($vehicle_type, [
    'route' => ['admin.vehicle_types.update', $vehicle_type],
    'method' => 'PUT',
]) !!}
@include('admin.vehicle_types.template.form')
<button type="submit" class="btn btn-primary">Actualizar</button>
{!! Form::close() !!}
