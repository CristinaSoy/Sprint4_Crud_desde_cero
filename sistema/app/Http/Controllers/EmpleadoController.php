<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos ['empleados'] = Empleado::paginate(5);
        return view('empleado.index', $datos);
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("empleado.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {            
        $campos = [
            "Nombre" =>"required|string|max:100",
            "Apellido1" =>"required|string|max:100",
            "Apellido2" =>"required|string|max:100",
            "Correo" =>"required|email",
            "Foto" =>"required|max:10000|mimes:jpeg,png,jpg",
        ];
        
        //añadir aqui los mensajes: min 2:18h
        
        // $datosEmpleado = request()->all();
        $datosEmpleado = request()->except('_token'); 

        // si existe la foto la guarda en storage/app/public/uploads
        if($request->hasFile('Foto')){
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads', 'public');
        }
        Empleado::insert($datosEmpleado);

       // return response()->json($datosEmpleado);
       return redirect("empleado") -> with("mensaje", "Empleado agregado con éxito");
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view ("empleado.edit", compact("empleado"));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $datosEmpleado = request()->except(['_token', '_method']); 
        Empleado::where('id', '=','$id') -> update($datosEmpleado);

        //retorna al form edit ya con los datos actualizados
        $empleado = Empleado::findOrFail($id);
        return view ("empleado.edit", compact("empleado"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $empleado=Empleado::findOrFail($id);

        if(Storage::delete('public/' . $empleado->Foto)){
            Empleado::destroy($id);
        }
       
        return redirect("empleado")->with("mensaje", "Empleado borrado");
    }
}
