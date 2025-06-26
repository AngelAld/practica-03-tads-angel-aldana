<div class="form-group">
    {!! Form::label('dia_de_la_semana', 'Día de la semana') !!}
    {!! Form::select(
        'dia_de_la_semana',
        [
            'Lunes' => 'Lunes',
            'Martes' => 'Martes',
            'Miércoles' => 'Miércoles',
            'Jueves' => 'Jueves',
            'Viernes' => 'Viernes',
            'Sábado' => 'Sábado',
            'Domingo' => 'Domingo',
        ],
        null,
        ['class' => 'form-control', 'required'],
    ) !!}
</div>
<div class="form-group">
    {!! Form::label('vehicle_id', 'Vehículo') !!}
    {!! Form::select('vehicle_id', \App\Models\Vehicle::pluck('name', 'id'), null, [
        'class' => 'form-control',
        'required',
        'placeholder' => 'Seleccione',
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('employee_id', 'Empleado') !!}
    {!! Form::select(
        'employee_id',
        \App\Models\Employee::selectRaw("CONCAT(names, ' ', lastnames) as nombre_completo, id")->pluck(
            'nombre_completo',
            'id',
        ),
        null,
        [
            'class' => 'form-control',
            'required',
            'placeholder' => 'Seleccione',
        ],
    ) !!}
</div>
<div class="form-group">
    {!! Form::label('tipo', 'Tipo') !!}
    {!! Form::select(
        'tipo',
        [
            'LIMPIEZA' => 'LIMPIEZA',
            'REPARACIÓN' => 'REPARACIÓN',
        ],
        null,
        [
            'class' => 'form-control',
            'required',
            'placeholder' => 'Seleccione',
        ],
    ) !!}
</div>
<div class="form-group">
    {!! Form::label('hora_inicio', 'Hora inicio') !!}
    {!! Form::time(
        'hora_inicio',
        isset($horario) ? \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') : null,
        ['class' => 'form-control', 'required'],
    ) !!}
</div>
<div class="form-group">
    {!! Form::label('hora_fin', 'Hora fin') !!}
    {!! Form::time('hora_fin', isset($horario) ? \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') : null, [
        'class' => 'form-control',
        'required',
    ]) !!}
</div>
