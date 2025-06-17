{!! Form::model($function, ['route' => ['admin.employee_functions.update', $function->id], 'method' => 'PUT', 'autocomplete' => 'off']) !!}
    @include('admin.employee_functions.template.form')
    <div class="text-end">
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </div>
{!! Form::close() !!}
