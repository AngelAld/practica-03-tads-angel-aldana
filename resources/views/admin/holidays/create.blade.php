{!! Form::open(['route' => 'admin.holidays.store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
    @include('admin.holidays.template.form')
    <div class="text-end">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
{!! Form::close() !!}
