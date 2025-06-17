{!! Form::model($period, ['route' => ['admin.periods.update', $period->id], 'method' => 'PUT', 'autocomplete' => 'off']) !!}
    @include('admin.periods.template.form')
    <div class="text-end">
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </div>
{!! Form::close() !!}
