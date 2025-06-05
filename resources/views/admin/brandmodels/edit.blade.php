{!! Form::model($brandmodel, ['route' => ['admin.brandmodels.update', $brandmodel], 'method' => 'PUT']) !!}
    @include('admin.brandmodels.template.form')
    <button type="submit" class="btn btn-primary">Actualizar</button>
{!! Form::close() !!}