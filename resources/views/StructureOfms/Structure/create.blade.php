@extends('layouts.backend')
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                @component('common-components.breadcrumb')
                    @slot('title') Création structure @endslot
                @endcomponent
            </div><!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title"></h4>
                        <form class="form-parsley" novalidate="" method="POST" action="{{ route('structures.store') }}">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">Nom</label>
                                    <input type="text" class="form-control" name="libelle" id="libelle" placeholder="OFMS" required>
                                </div><!--end col-->
                                <div class="col-md-6 mb-3">
                                    <label for="type_structue" >Type structure</label>
                                    <select class="form-control" name="type_structure_id" required>
                                        <option value="">Choisir le type</option>
                                        @forelse ($type_structures as $value)
                                             <option value="{{ $value->id }}">{{ $value->libelle }}</option>
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
                                            <option value="{{ $value->id }}">{{ $value->prenom }} {{ $value->nom }} - {{ $value->liste_structure }}</option>
                                        @empty
                                            <option value="">Aucun responsable disponible</option>
                                        @endforelse
                                    </select>
                                </div><!--end col-->
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom05">Structure rattachée</label>
                                    <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="structure_parent_id">
                                        <option value="">Choisir une structure</option>
                                        @forelse ($structures as $value)
                                            <option value="{{ $value->id }}">{{ $value->liste_structure }}</option>
                                        @empty
                                            <option value="">Aucune structure disponible</option>
                                        @endforelse
                                    </select>
                                </div><!--end col-->

                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">Description de la structure</label>
                                    <input type="text" name='description' class="form-control" id="validationCustom01" placeholder="Direction Générale" required="">
                                </div><!--end col-->
                            </div><!--end form-row-->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> &nbsp;Ajouter</button>
                                <a href="{{ route('structures.index') }}" class="btn btn-dark"><i class="fas fa-times"></i> &nbsp;Annuler</a>
                            </div>
                        </form>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end col-->
        </div>
    </div><!-- container -->
@stop

@section('footerScript')
    <script src="{{ URL::asset('plugins/moment/moment.js') }}"></script>
    <script src="{{ URL::asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('plugins/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/timepicker/bootstrap-material-datetimepicker.js') }}"></script>
    <script src="{{ URL::asset('plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('assets/pages/jquery.forms-advanced.js') }}"></script>
@stop
