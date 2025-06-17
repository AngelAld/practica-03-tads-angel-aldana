{!! Form::open(['route' => 'admin.periods.store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
    @include('admin.periods.template.form')
    <div class="text-end">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
{!! Form::close() !!}
