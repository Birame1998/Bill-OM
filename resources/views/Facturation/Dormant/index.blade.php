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
            @slot('title') Liste des partenaires dormants @endslot
            @endcomponent
        </div>
        <!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <form>
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-3 mb-4">
                                <div class="input-group">
                                    <select class="select2 form-control mb-3" style="width: 100%; height:36px;" name="search2" data-column="0">
                                        @if(isset($nom_partenaire))
                                        <option value="">Nom partenaire</option>
                                        @forelse ($partenaires as $value)
                                        @if ($value->id== $nom_partenaire)
                                        <option value="{{$value->nom_partenaire}}" selected>{{$value->nom_partenaire}}</option>
                                        @else
                                        <option value="{{$value->nom_partenaire}}">{{$value->nom_partenaire}}</option>
                                        @endif
                                        @empty
                                        <option value="">Aucun partenaire disponible</option>
                                        @endforelse
                                        @else
                                        <option value="" selected>Nom partenaire</option>
                                        @forelse ($partenaires as $value)
                                        <option value="{{$value->nom_partenaire}}">{{$value->nom_partenaire}}</option>
                                        @empty
                                        <option value="">Aucun partenaire disponible</option>
                                        @endforelse
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 mb-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button> &nbsp;
                                <a href="{{ route('catalogue.index') }}" class="btn btn-dark">
                                    <span style="color:white">Tous</span>
                                </a>
                            </div>
                        </div>
                    </form>
                    <br>
                    <table class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>Num.AP</th>
                                <th>Nom partenaire</th>
                                <th>Sim head</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($partenaires as $value)
                            <tr>
                                <td>{{ $value->num_ap }}</td>
                                <td>
                                    {{ $value->nom_partenaire }}
                                    @if($value->commentaire!=null) &nbsp;
                                    <i class="fas fa-comment text-orange font-15"></i>
                                    @endif
                                </td>
                                <td>
                                    @foreach($value->sim_designation as $val)
                                    <li style="list-style-type: none;">{{ $val->sim_head }}</li>
                                    @endforeach
                                </td>
                            </tr>
                            @empty
                            <li class="list-group-item list-group-item-danger">Pas de partenaires dormants</li>
                            @endforelse
                        </tbody>
                    </table>
                    @if ($partenaires->hasPages())
                    <div class="pagination-wrapper d-flex justify-content-center">
                        {{ $partenaires->appends($_GET)->links()}}
                    </div>
                    @endif
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