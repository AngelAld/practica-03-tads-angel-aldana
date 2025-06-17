<div class="row">
    <div class="col-12">
        <div class="form-group">
            {!! Form::label('name', 'Nombre del Feriado') !!}
            {!! Form::text('name', null, [
                'class' => 'form-control',
                'placeholder' => 'Ingrese el nombre del feriado',
                'required',
                'id' => 'name',
            ]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('date', 'Fecha') !!}
            {!! Form::date('date', null, [
                'class' => 'form-control',
                'required',
                'id' => 'date',
            ]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('period_id', 'Periodo') !!}
            {!! Form::select('period_id', $periods, null, [
                'class' => 'form-control',
                'required',
                'placeholder' => 'Seleccione un periodo',
                'id' => 'period_id',
            ]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('status', 'Estado') !!}
            {!! Form::select('status', ['1' => 'Activo', '0' => 'Inactivo'], null, [
                'class' => 'form-control',
                'required',
                'id' => 'status',
            ]) !!}
        </div>
    </div>
</div>
