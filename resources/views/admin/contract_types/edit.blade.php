{!! Form::model($contract_type, [
    'route' => ['admin.contract_types.update', $contract_type],
    'method' => 'PUT',
]) !!}
@include('admin.contract_types.template.form')
<button type="submit" class="btn btn-primary">Actualizar</button>
{!! Form::close() !!}
