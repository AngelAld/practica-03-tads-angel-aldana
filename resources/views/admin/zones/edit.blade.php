{!! Form::model($zone, [
    'route' => ['admin.zones.update', $zone],
    'method' => 'PUT',
    'files' => true,
]) !!}
@include('admin.zones.template.form')
<button type="submit" class="btn btn-primary">Actualizar</button>
{!! Form::close() !!}
