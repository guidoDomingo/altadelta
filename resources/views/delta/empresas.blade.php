<?php
//return dd($empresas);
?>

@extends('app')

@section('estilos')
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{ asset('src/assets/css/light/components/media_object.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('src/assets/css/dark/components/media_object.css') }}" rel="stylesheet" type="text/css">
    <!--  END CUSTOM STYLE FILE  -->
@endsection

@section('title')
@endsection

@section('content')
    <section class="content">
        <div class="row">
            @foreach ($empresas as $empresa)
                <div id="card_12" class="col-md-3 layout-spacing widget">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-12">
                                    <h4>{{ $empresa['nombre_empresa'] }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <img src="{{ $empresa['imagen_empresa'] }}" class="card-img-top" alt="..." style="width: auto; height: 200px;">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">{{ $empresa['nombre_empresa'] }}</h5>
                                            <p class="card-text">Elige la empresa.</p>
                                             {!! Form::open(['route' => 'altaPasajero', 'method' => 'POST', 'role' => 'form', 'id' => 'form_' . $empresa['id_empresa']]) !!}
                                                 <input type="hidden" name="url" value="{{ $empresa['url_empresa'] }}">
                                                 <input type="hidden" name="agencia" value="{{ $empresa['agencia_empresa'] }}">
                                                 <input type="hidden" name="usuario" value="{{ $empresa['usuario_empresa'] }}">
                                                 <input type="hidden" name="clave" value="{{ $empresa['clave_empresa'] }}">
                                             {!! Form::close() !!}
                                            <button class="btn btn-secondary mt-3 ingresarBtn" data-form-id="{{ $empresa['id_empresa'] }}">Ingresar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endsection

    @section('js')

        <script>
             console.log("ingresoo console");
            $(document).ready(function() {
                $('.ingresarBtn').click(function() {
                    var formId = $(this).data('form-id');
                    $('#form_' + formId).submit();
                });
            });
        </script>

    @endsection
