@extends('app')

@section('title')

@endsection

@section('content')

<section class="content">

    <div class="row mb-3">
        <div class="col-md-12">
            <h2>Formulario</h2>
        </div>
    </div>

    <div class="tab-content" id="animateLineContent-4">
        <div class="tab-pane fade show active" id="animated-underline-home" role="tabpanel"
            aria-labelledby="animated-underline-home-tab">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                    <form class="section general-info" action=" {{ route('guardar') }}" method="POST">
                        @csrf
                        <div class="info">
                            <h6 class="">Cargar el formulario <span>(Todos los campos son obligatorios *)</span></h6>
                            <div class="row">
                                <div class="col-lg-11 mx-auto">
                                    <div class="row">

                                        <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                            <div class="form">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="country">Tipo de documento</label>
                                                            <select class="form-select mb-3" id="country"
                                                                name="tipo_documento">
                                                                @foreach ($tipo_documento as $value)
                                                                    <option value="{{ $value->Codigo }}"
                                                                        {{ $value->Codigo == $tipo_doc ? 'selected' : '' }}>
                                                                        {{ $value->Descripcion }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="profession">Número de documento</label>
                                                            <input type="text" class="form-control mb-3" name="documento"
                                                                placeholder="Ingrese su documento"
                                                                value="{{ $numero_documento }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="location">Nombre</label>
                                                            <input type="text" class="form-control mb-3" name="nombre"
                                                                placeholder="Ingrese su nombre" value="{{ $nombre }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="address">Apellido</label>
                                                            <input type="text" class="form-control mb-3" name="apellido"
                                                                placeholder="Ingrese su apellido"
                                                                value="{{ $apellido }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="phone">Ocupación</label>
                                                            <input type="text" class="form-control mb-3" name="ocupacion"
                                                                placeholder="Ingrese su ocupación">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="email">Fecha de nacimiento</label>
                                                            <input type="text" class="form-control mb-3"
                                                                id="fecha_nacimiento" name="fecha_nacimiento"
                                                                placeholder="Ingrese la fecha">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="country">Sexo</label>
                                                            <select class="form-select mb-3" name="sexo">
                                                                <option value="F">Femenino</option>
                                                                <option value="M" selected>Masculino</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="country">Nacionalidad</label>
                                                            <select class="form-select mb-3" name="nacionalidad">
                                                                @foreach ($paises as $value)
                                                                    <option value="{{ $value->Codigo }}">
                                                                        {{ $value->Descripcion }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="country">País de residencia</label>
                                                            <select class="form-select mb-3" name="residencia">
                                                                @foreach ($paises as $value)
                                                                    <option value="{{ $value->Codigo }}">
                                                                        {{ $value->Descripcion }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="website1">Teléfono</label>
                                                            <input type="text" class="form-control mb-3" name="telefono"
                                                                id="telefono" placeholder="Ingrese el teléfono">
                                                        </div>
                                                    </div>


                                                    <div class="col-md-12 mt-1">
                                                        <div class="form-group text-end">
                                                            <button type="submit" id="saveButton"
                                                                class="btn btn-secondary">Guardar
                                                            </button>
                                                            <button id="loadingButton" class="btn btn-info btn-lg mb-2 me-4"
                                                                style="display: none;">
                                                                <span
                                                                    class="spinner-border text-white me-2 align-self-center loader-sm "></span>
                                                                Loading
                                                            </button>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
