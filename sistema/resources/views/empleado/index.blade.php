
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo Laravel</title>
</head>
<body>
    <br>
<!-- estas dos instrucciones estan más arriba en el video-->
@extends('layouts.app')
@section('content')

<div class = "container">
<!-- si hay un mensaje del controlador-->
@if(Session::has("mensaje"))
    <div class = "alert alert-success alert-dismissible" role="alert">
              {{ Session::get("mensaje") }}
       
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    
    </div>
@endif



<!-- <div class="container"> -->
    <!-- Enlace para opcion de crear nuevo empleado-->
    <a href="{{ url('empleado/create') }}" class="btn btn-success"> Registrar nuevo empleado </a>
    <br>
    <br>
    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Apellido1</th>
                <th>Apellido2</th>
                <th>Correo</th>
                <th>Foto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleados as $empleado)
            <tr>
                <td>{{ $empleado->id }}</td>

                <td>
                    <img class="img-thumbnail img-fluid" src="{{ asset('storage').'/'.$empleado->Foto }}" width="50" alt="">
                </td>
                
                <td>{{ $empleado->Nombre }}</td>
                <td>{{ $empleado->Apellido1 }}</td>
                <td>{{ $empleado->Apellido2 }}</td>
                <td>{{ $empleado->Correo }}</td>
            
                <td>
                {{-- editar empleado --}}    

                <a href="{{ url('/empleado/'.$empleado->id.'/edit')}}" class="btn btn-warning">Editar</a>
                | 
                    
                {{-- form para borrar empleado --}}
                <form action = "{{ url('/empleado/'. $empleado->id)}}" class="d-inline" method="post">
                    @csrf
                    {{method_field("DELETE")}}
                    <input type="submit" class="btn btn-danger" onclick="return confirm('Vas a borrar un empleado. ¿Continuar?')"
                    value="Borrar">
                </form>

                </td>            
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- para mostrar la paginacion-->
    {!! $empleados->links()!!}
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>