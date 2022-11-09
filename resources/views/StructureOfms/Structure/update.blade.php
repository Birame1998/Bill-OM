@extends('layouts.backend')
@section('headerStyle')
<link href="{{ URL::asset('plugins/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                @component('common-components.breadcrumb')
                    @slot('title') Modification structure @endslot
                @endcomponent
            </div><!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title"></h4>
                        <form class="form-parsley" novalidate="" method="POST" action="{{ route('structures.update',$struct_update) }}">
                            @method('PATCH')
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">Nom</label>
                                    <input type="text" class="form-control" name="libelle" id="libelle" placeholder="DG" value="{{$struct_update->libelle}}" required="">
                                </div><!--end col-->
                                <div class="col-md-6 mb-3">
                                    <label for="type_structue" >Type structure</label>
                                    <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="type_structure_id">
                                        <option value="">Choisir le type</option>
                                        @forelse ($type_structures as $value)
                                            @if ($value->id == $struct_update->type_structure_id)
                                                <option value="{{$value->id}}" selected>{{$value->libelle}}</option>
                                            @else
                                                <option value="{{$value->id}}">{{$value->libelle}}</option>
                                            @endif
                                        @empty
                                            <option value="">Aucun type disponible</option>
                                        @endforelse
                                    </select>
                                </div><!--end col-->
                            </div><!--end form-row-->
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="directeur_id">Responsable de la structure</label>
                                        <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="directeur_id">
                                            <option value="">Choisir un responsable</option>
                                            @forelse ($users as $value)
                                                @if ($value->id == $struct_update->directeur_id)
                                                    <option value="{{$value->id}}" selected>{{$value->prenom}} {{$value->nom}} - {{ $value->liste_structure }}</option>
                                                @else
                                                    <option value="{{$value->id}}">{{$value->prenom}} {{$value->nom}} - {{ $value->liste_structure }}</option>
                                                @endif
                                            @empty
                                                <option value="">Aucun responsable disponible</option>
                                            @endforelse
                                        </select>
                                </div><!--end col-->
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom05">Structure rattachée</label>
                                        <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="structure_parent_id">
                                            <option value="" selected>Choisir une structure</option>
                                            @forelse ($structures as $value)
                                                @if ($value->id == $struct_update->structure_parent_id)
                                                    <option value="{{ $value->id }}" selected>{{ $value->liste_structure }}</option>
                                                @else
                                                    <option value="{{ $value->id }}">{{ $value->liste_structure }}</option>
                                                @endif
                                                @empty
                                                <option value="">Aucune structure disponible</option>
                                            @endforelse
                                        </select>
                                </div><!--end col-->
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">Description de la structure</label>
                                    <input type="text" name='description' class="form-control" id="validationCustom01" placeholder="Direction Générale" value="{{$struct_update->description}}" required="">
                                </div><!--end col-->
                            </div><!--end form-row-->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> &nbsp;Modifier</button>
                                <a href="{{ route('structures.index') }}" class="btn btn-dark"><i class="fas fa-times"></i> &nbsp;Annuler</a>
                            </div>
                        </form>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end col-->
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
@stop
