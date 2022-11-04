@extends('layouts.backend')
@section('headerStyle')
    <link href="{{ URL::asset('plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('plugins/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('plugins/timepicker/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" />
@stop

@section('content')
 <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                @component('common-components.breadcrumb')
                    @slot('title') Liste recyclage UV @endslot
                @endcomponent
            </div><!--end col-->
        </div>

        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title"></h4>
                        <div class="row justify-content-center">
                        <div class="col-md-4 mb-4">
                            {{-- <input type="text" class="form-control" name="nom_partenaire" required> --}}
                            <div class="input-group">
                                <input type="text" id="daterange" class="form-control" name="dates" value="{{$dates ?? date('d/m/Y',strtotime( '-1 days' )).' - '.date('d/m/Y',strtotime( '-1 days' )) }}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="dripicons-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-6">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button> &nbsp;
                            @if (Route::is('facturation_valide.search') || Route::is('facturation_valide.index'))
                                <a href="{{ route('facturation_valide.index') }}" class="btn btn-dark">
                                    <span style="color:white">Tous</span>
                                </a>
                            @elseif (Route::is('facturation_envalidation.search') || Route::is('facturation_envalidation.index'))
                                <a href="{{ route('facturation_envalidation.index') }}" class="btn btn-dark">
                                    <span style="color:white">Tous</span>
                                </a>
                            @endif
                        </div> </div>
                        <table class="table table-striped table-bordered w-100">
                            <thead>
                            <tr>
                                <th>Fichier C2C</th>
                                <th>Fichier OW</th>
                                <th>Date</th>
                                <th class="action">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($recyclage as $value)
                                    <tr>
                                        <td>
                                            <a href="/download_file_action/?file={{ $value->c2c }}" class="doc">{{ $value->c2c }}</a>
                                        </td>
                                        <td>
                                            <a href="/download_file_action/?file={{ $value->ow }}" class="doc">{{ $value->ow }}</a>
                                        </td>
                                        <td>{{ date('d/m/Y', strtotime($value->date)) }}</td>
                                        <td align ="center">
                                            <a href="/download_zip_file_action/?id={{ $value->id }}" class="mr-1"><i class="fas fa-download text-black font-16"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div><!-- container -->

@stop

@section('footerScript')
<script src="{{ URL::asset('plugins/moment/moment.js')}}"></script>
    <script src="{{ URL::asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{ URL::asset('plugins/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
    <script src="{{ URL::asset('plugins/timepicker/bootstrap-material-datetimepicker.js')}}"></script>
    <script src="{{ URL::asset('plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
    <script src="{{ URL::asset('plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js')}}"></script>
    <script src="{{ URL::asset('assets/pages/jquery.forms-advanced.js')}}"></script>
    <script src="{{ URL::asset('plugins/tinymce/tinymce.min.js')}}"></script>
    <script src="{{ URL::asset('assets/pages/jquery.form-editor.init.js')}}"></script>

    <script src="{{ URL::asset('plugins/datatables/dataTables.responsive.min.js')}}"></script>
    <script src="{{ URL::asset('plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{ URL::asset('assets/pages/jquery.datatable.init.js')}}"></script>
@stop
