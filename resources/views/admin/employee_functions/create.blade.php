{!! Form::open(['route' => 'admin.employee_functions.store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
    @include('admin.employee_functions.template.form')
    <div class="text-end">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
{!! Form::close() !!}
