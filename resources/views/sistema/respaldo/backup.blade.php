@extends('adminlte.layout')

@section('seccion', 'Copias de seguridad')

@section('title', 'Respaldos')

@section('content')
{{-- <div class="container"> --}}
<div class="row mt-3 ml-3">
    <button class="btn btn-success mb-3 " id="btn-guardar"><i class="far fa-clone"></i> Crear copia de
        seguridad</button>
    <button class="btn btn-success mb-3 " id="btn-spin" type="button" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <span class="sr-only">Loading...</span>
        Creando respaldo...</button>
</div>
<div class="card">
    <div class="card-body p-0">
        <table id="" class="table table-bordered table-hover datatables mb-5" style="width: 100%; margin-bottom: 30px;">
            <thead class="thead-light ">
                <tr>
                    <th>Disco</th>
                    <th>Fecha</th>
                    <th>Ruta</th>
                    <th>Tamaño</th>
                </tr>
            </thead>
            <tbody class="bg-light text-dark reportes-body" id="respaldos"></tbody>

        </table>

    </div><!-- /.box-body -->
</div><!-- /.box -->


@include('adminlte/scripts')
<script src="{{asset('js/respaldos/backup.js')}}"></script>

@endsection