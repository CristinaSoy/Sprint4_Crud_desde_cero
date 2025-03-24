
<h1>{{ $modo }} empleado </h1>

@if (count($errors)>0)
    <div class="alert alert-danger" role ="alert">
        <ul>
            @foreach($errors->all() as $error)
            <li> {{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <label for="Nombre">Nombre</label>
    <input type="text" class="form-control" name="Nombre" 
        value = "{{ isset($empleado->Nombre) ? $empleado->Nombre : old('Nombre') }}" id="Nombre">
</div>

<div class="form-group">
    <label for="Apellido1">Apellido1</label>
    <input type="text" class="form-control" name="Apellido1" 
        value = "{{ isset($empleado->Apellido1) ? $empleado->Apellido1 : old('Apellido1') }}" id="Apellido1">
</div>

<div class="form-group">
    <label for="Apellido2">Apellido2</label>
    <input type="text" class="form-control" name="Apellido2" 
        value = "{{ isset($empleado->Apellido2) ? $empleado->Apellido2 : old('Apellido2') }}" id="Apellido2">
</div>

<div class="form-group">
    <label for="Correo">Correo</label>
    <input type="text" class="form-control" name="Correo" 
        value = "{{ isset($empleado->Correo) ? $empleado->Correo : old('Correo') }}" id="Correo">
</div>

<!-- Foto -->
<div class="form-group">
    <label for="Foto"></label>
    @if(isset($empleado->Foto))
        <img class="img-thumbnail img-fluid" src="{{ asset('storage').'/'.$empleado->Foto }}" 
        width="50" alt="">
    @endif
    <input type="file" class="form-control" name="Foto" value="" id="Foto">
</div>

<!--botones de accion:-->
<input class="btn btn-success" type="submit" value="{{ $modo }} datos">

<a class="btn btn-primary" href="{{ url('empleado') }}"> Regresar </a>
