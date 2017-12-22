@extends('admin.main')

@section('content')
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-select2/select2.css')}}"  type="text/css" media="screen"/>
<link rel="stylesheet" href="{{ asset('plugins/jquery-datatable/css/jquery.dataTables.css')}}"  type="text/css" media="screen"/>
<style>
textarea {
    resize: none;
}
th {
    text-align: center!important;
}
/* Change the white to any color ;) */
input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0px 1000px white inset !important;
}
.table td.text {
    max-width: 177px;
}
.table td.text span {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: inline-block;
    max-width: 100%;
}
</style>
<div class="text-center" style="margin: 20px;">
     @if(session('msg'))
    <div class="alert {{session('class')}}">
        {{session('msg')}}
    </div>
    @endif
    <h2>{{$title}}</h2>
    <div class="row-fluid">
        <div class="span12">
            <div class="grid simple ">
                <div class="grid-title">
                    @if($title != 'Historial')
                        <div id="opciones-adicionales">
                            <h4>Opciones <span class="semi-bold">adicionales</span></h4>
                            <div>
                                <button class="btn btn-default" id="download"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargar excel master</button>
                                <a href="{{url('altaNomina')}}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Nueva lista de asistencia</a>
                            </div>
                        </div>
                    @endif
                    <div class="grid-body">
                        <div class="table-responsive" id="div_tabla_empresas">
                            @include('pagos.tabla')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('plugins/jquery-datatable/js/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/jquery-datatable/extra/js/dataTables.tableTools.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/datatables.responsive.js') }}" type="text/javascript"></script>
<script src="{{ asset('plugins/datatables-responsive/js/lodash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/tabs_accordian.js') }}"></script>
<script src="{{ asset('js/datatables.js') }}"></script>
<script type="text/javascript">
    $('body').delegate('#download','click', function() {
        window.location.href = "{{url('nominas/excel_master')}}";
    });
</script>
@endsection