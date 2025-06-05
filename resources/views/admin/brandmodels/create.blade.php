{!! Form::open(['route' => 'admin.brandmodels.store', 'method' => 'POST']) !!}
    @include('admin.brandmodels.template.form')
    <button type="submit" class="btn btn-primary">Registrar</button>
{!! Form::close() !!}