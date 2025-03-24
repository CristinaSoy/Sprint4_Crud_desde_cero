<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // lo agregamos para poder eliminar foto en update

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos ['empleados'] = Empleado::paginate(2);
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
        //validamos entrada de datos
        $campos = [
            "Nombre" =>"required|string|max:100",
            "Apellido1" =>"required|string|max:100",
            "Apellido2" =>"required|string|max:100",
            "Correo" =>"required|email",
            "Foto" =>"required|max:10000|mimes:jpeg,png,jpg",
        ];
        
        //añadir aqui los mensajes de validacion de datos: min 2:18h
        $mensaje = [
            'required' => "El :attribute es requerido",
            'Foto.required' => "La foto es requerida"
        ];

        //aplicar la validación:
        $this->validate($request, $campos, $mensaje);


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
        //validacion de entrada de datos
        $campos = [
            "Nombre" =>"required|string|max:100",
            "Apellido1" =>"required|string|max:100",
            "Apellido2" =>"required|string|max:100",
            "Correo" =>"required|email",
            
        ];
        
        //añadir aqui los mensajes: min 2:18h
        $mensaje = [
            'required' => "El :attribute es requerido",  
        ];

        if($request->hasFile("Foto")) {
            $campos = ["Foto"=>"required|max:10000|mimes:jpeg,png,jpg"];
            $mensaje = ["Foto.required" => "Foto es requerida"];
        }

        //aplicar la validación:
        $this->validate($request, $campos, $mensaje);
        
        
        $datosEmpleado = request()->except(['_token', '_method']); 

           // si existe la foto la guarda en storage/app/public/uploads 1:30h
           if($request->hasFile('Foto')){
                $empleado = Empleado::findOrFail($id);
                Storage::delete("public/".$empleado->Foto);
                $datosEmpleado["Foto"]= $request ->file("Foto")->store("uploads", "public");
                
           }
         
        Empleado::where('id', '=',$id) -> update($datosEmpleado);

        //retorna al form edit ya con los datos actualizados
        $empleado = Empleado::findOrFail($id);
        //return view ("empleado.edit", compact("empleado"));

        return redirect("empleado")->with("mensaje", "Empleado modificado");
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
