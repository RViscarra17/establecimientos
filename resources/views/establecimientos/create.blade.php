@extends('layouts.app')

@section('styles')

    {{-- Style de Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />

    {{-- Style de Esri Geocoder --}}
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder/dist/esri-leaflet-geocoder.css" />

    {{-- Style de Dropzone --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/dropzone.min.css"
        integrity="sha512-0ns35ZLjozd6e3fJtuze7XJCQXMWmb4kPRbb+H/hacbqu6XfIX0ZRGt6SrmNmv5btrBpbzfdISSd8BAsXJ4t1Q=="
        crossorigin="anonymous" />
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center mt-4">Registrar establecimiento</h1>

        <div class="mt-5 row justify-content-center">

            <form class="col-md-9 col-xs-12 card card-body" action="{{ route('establecimiento.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <fieldset class="border p-4">
                    <legend class="text-primary">Nombre, categoria e imagen principal</legend>
                    <div class="form-group">
                        <label for="nombre">Nombre Establecimiento</label>
                        <input type="text" name="nombre" id="nombre"
                            class="form-control @error('nombre') is-invalid @enderror" placeholder="Nombre Establecimiento"
                            value="{{ old('nombre') }}">

                        @error('nombre')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="categoria_id">Categoria:</label>

                        <select class="form-control @error('categoria_id') is-invalid @enderror" name="categoria_id"
                            id="categoria_id">
                            <option value="" selected disabled>-- Seleccione --</option>

                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>

                        @error('categoria_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="imagen_principal">Imagen Principal</label>
                        <input type="file" name="imagen_principal" id="imagen_principal"
                            class="form-control @error('imagen_principal') is-invalid @enderror"
                            value="{{ old('imagen_principal') }}">

                        @error('imagen_principal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </fieldset>

                <fieldset class="border p-4 mt-5">
                    <legend class="text-primary">Ubicacion:</legend>

                    <div class="form-group">
                        <label for="formbuscador">Coloca la direccion del establecimiento</label>
                        <input type="text" name="formbuscador" id="formbuscador" placeholder="Calle del establecimiento"
                            class="form-control">

                        <p class="text-secondary mt-5 mb-3 text-center">El asistente colocara una direccion estimada o mueve
                            el pin hacia el lugar correcto</p>
                    </div>

                    <div class="form-group">
                        <div id="mapa" style="height: 400px;"></div>
                    </div>

                    <p class="informacion">Confirma que los siguientes campos son correctos</p>

                    <div class="form-group">
                        <label for="direccion">Direccion</label>

                        <input type="text" name="direccion" id="direccion" class="form-control @error('direccion') is-invalid @enderror"
                            placeholder="Direccion" value="{{ old('direccion') }}">

                        @error('direccion')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="colonia">Colonia</label>

                        <input type="text" name="colonia" id="colonia" class="form-control @error('colonia') is-invalid @enderror"
                            placeholder="Colonia" value="{{ old('colonia') }}">

                        @error('colonia')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        <input type="hidden" id="lat" name="lat" value="{{ old('lat') }}">
                        <input type="hidden" id="lng" name="lng" value="{{ old('lng') }}">

                    </div>

                </fieldset>

                <fieldset class="border p-4 mt-5">
                    <legend class="text-primary">Información Establecimiento: </legend>
                    <div class="form-group">
                        <label for="nombre">Teléfono</label>
                        <input type="tel" class="form-control @error('telefono')  is-invalid  @enderror" id="telefono"
                            placeholder="Teléfono Establecimiento" name="telefono" value="{{ old('telefono') }}">

                        @error('telefono')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>



                    <div class="form-group">
                        <label for="nombre">Descripción</label>
                        <textarea class="form-control  @error('descripcion')  is-invalid  @enderror"
                            name="descripcion">{{ old('descripcion') }}</textarea>

                        @error('descripcion')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nombre">Hora Apertura:</label>
                        <input type="time" class="form-control @error('apertura')  is-invalid  @enderror" id="apertura"
                            name="apertura" value="{{ old('apertura') }}">
                        @error('apertura')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nombre">Hora Cierre:</label>
                        <input type="time" class="form-control @error('cierre')  is-invalid  @enderror" id="cierre"
                            name="cierre" value="{{ old('cierre') }}">
                        @error('cierre')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </fieldset>

                <fieldset class="border p-4 mt-5">
                    <legend class="text-primary">Imagenes del establecimiento</legend>
                    <div class="form-group">
                        <label for="imagenes">Imagenes</label>
                        <div id="dropzone" class="dropzone form-control">

                        </div>

                    </div>
                </fieldset>

                <input type="hidden" id="uuid" name="uuid" value="{{ Str::uuid()->toString() }}">
                <input type="submit" class="btn btn-primary mt-3 d-block " value="Registrar establecimiento">
            </form>
        </div>


    </div>
@endsection

@section('scripts')
    {{-- Script de Leaflet --}}
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin="" defer></script>

    {{-- Script de Esri Leaflet --}}
    <script src="https://unpkg.com/esri-leaflet" defer></script>

    {{-- Script de Esri Geocoder --}}
    <script src="https://unpkg.com/esri-leaflet-geocoder" defer></script>

    {{-- Script de Dropzone --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/dropzone.min.js"
        integrity="sha512-Mn7ASMLjh+iTYruSWoq2nhoLJ/xcaCbCzFs0ZrltJn7ksDBx+e7r5TS7Ce5WH02jDr0w5CmGgklFoP9pejfCNA=="
        crossorigin="anonymous" defer></script>
@endsection
