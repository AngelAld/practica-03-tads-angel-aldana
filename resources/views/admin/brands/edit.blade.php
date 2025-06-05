
        {!! Form::model($brand, ['route' => ['admin.brands.update', $brand], 'method' => 'PUT', 'files' => true]) !!}
        @include('admin.brands.template.form')
        <button type="submit" class="btn btn-primary">Actualizar</button>
         
        {!! Form::close() !!}
