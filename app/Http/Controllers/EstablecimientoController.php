<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Establecimiento;
use App\Imagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\map;
use Intervention\Image\Facades\Image;

class EstablecimientoController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categorias = Categoria::all();
        return view('establecimientos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required|exists:App\Categoria,id',
            'imagen_principal' => 'required|image|max:1000',
            'direccion' => 'required',
            'colonia' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'telefono' => 'required|numeric',
            'descripcion' => 'required|min:50',
            'apertura' => 'required|date_format:H:i',
            'cierre' => 'required|date_format:H:i|after:apertura',
            'uuid' =>  'required|uuid',
        ]);

        $ruta_imagen = $request['imagen_principal']->store('principales', 'public');

        $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(800, 600);

        $img->save();

        auth()->user()->establecimiento()->create([
            'nombre' => $data['nombre'],
            'categoria_id' => $data['categoria_id'],
            'imagen_principal' => $ruta_imagen,
            'direccion' => $data['direccion'],
            'colonia' => $data['colonia'],
            'lat' => $data['lat'],
            'lng' => $data['lng'],
            'telefono' => $data['telefono'],
            'descripcion' => $data['descripcion'],
            'apertura' => $data['apertura'],
            'cierre' => $data['cierre'],
            'uuid' =>  $data['uuid'],
        ]);


        return back()->with('estado', 'Tu informacion se almaceno correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function show(Establecimiento $establecimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
        $categorias = Categoria::all();
        $establecimiento = Auth()->user()->establecimiento;
        $establecimiento->apertura = date('H:i', strtotime($establecimiento->apertura));
        $establecimiento->cierre = date('H:i', strtotime($establecimiento->cierre));

        $imagenes = Imagen::where('id_establecimiento', $establecimiento->uuid)->get();

        return view('establecimientos.edit', compact('categorias', 'establecimiento', 'imagenes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Establecimiento $establecimiento)
    {
        //
        $this->authorize('update', $establecimiento);


        $data = $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required|exists:App\Categoria,id',
            'imagen_principal' => 'image|max:1000',
            'direccion' => 'required',
            'colonia' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'telefono' => 'required|numeric',
            'descripcion' => 'required|min:50',
            'apertura' => 'required|date_format:H:i',
            'cierre' => 'required|date_format:H:i|after:apertura',
            'uuid' =>  'required|uuid',
        ]);

        $establecimiento->nombre = $data['nombre'];
        $establecimiento->categoria_id = $data['categoria_id'];
        $establecimiento->direccion = $data['direccion'];
        $establecimiento->colonia = $data['colonia'];
        $establecimiento->lat = $data['lat'];
        $establecimiento->lng = $data['lng'];
        $establecimiento->telefono = $data['telefono'];
        $establecimiento->descripcion = $data['descripcion'];
        $establecimiento->apertura = $data['apertura'];
        $establecimiento->cierre = $data['cierre'];
        $establecimiento->uuid = $data['uuid'];

        if (request('imagen_principal')) {
            $ruta_imagen = $request['imagen_principal']->store('principales', 'public');
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(800, 600);
            $img->save();
            $establecimiento->imagen_principal = $ruta_imagen;
        }

        $establecimiento->save();

        return back()->with('estado', 'Tu informacion se almaceno correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Establecimiento  $establecimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Establecimiento $establecimiento)
    {
        //
    }
}
