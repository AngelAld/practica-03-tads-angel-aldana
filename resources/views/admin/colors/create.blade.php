{!! Form::open(['route' => 'admin.colors.store', 'method' => 'POST']) !!}
    @include('admin.colors.template.form')
    <button type="submit" class="btn btn-primary">Registrar</button>
{!! Form::close() !!}