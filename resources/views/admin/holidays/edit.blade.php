{!! Form::model($holiday, ['route' => ['admin.holidays.update', $holiday->id], 'method' => 'PUT', 'autocomplete' => 'off']) !!}
    @include('admin.holidays.template.form')
    <div class="text-end">
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </div>
{!! Form::close() !!}
