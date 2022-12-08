@extends('layouts.backend')
@section('headerStyle')
    <!-- Plugins css -->
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
                    @slot('title') Modification d'une catalogue @endslot
                @endcomponent
            </div><!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title"></h4>
                        <form class="form-parsley" novalidate="" method="POST" action="{{ route('catalogue.update', $catalogue) }}">
                            @method('PATCH')
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">Numéro AP</label>
                                    <input type="number" class="form-control" name="num_ap"  value="{{ $catalogue->num_ap }}" min="0" required>
                                </div><!--end col-->
                                <div class="col-md-6 mb-3">
                                    <label for="directeur_id">Nom partenaire</label>
                                    <input type="text" class="form-control" name="nom_partenaire" value="{{ $catalogue->nom_partenaire }}" required>
                                </div><!--end col-->
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label class="my-2">Compte bancaire</label>
                                    <input type="text" class="form-control" name="compte_bancaire" value="{{ $catalogue->compte_bancaire }}" required>
                                </div><!--end col-->
                            </div><!--end form-row-->
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="type_action_id" class="my-2">Type de partenaire</label>
                                    <select class="form-control mb-3 custom-select" style="width: 100%; height:36px;" name="type_partenaire_id" required>
                                        <option value="">Choisir un type de partenaire</option>
                                        @forelse ($type_partenaire as $value)
                                            @if ($value['id'] == $catalogue->type_partenaire_id)
                                                <option value="{{ $value['id'] }}" selected>{{ $value['libelle'] }}</option>
                                            @else
                                                <option value="{{ $value['id'] }}">{{ $value['libelle'] }}</option>
                                            @endif
                                            @empty
                                            <option value="">Aucun type de partenaire disponible</option>
                                        @endforelse
                                    </select>
                                </div><!--end col-->
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom05" class="my-2">Inclure</label>
                                    <select class="form-control mb-3 custom-select" style="width: 100%; height:36px;" name="inclure_id" required>
                                        <option value="">Choisir</option>
                                        @forelse ($inclure as $value)
                                            @if ($value['id'] == $catalogue->inclure_id)
                                                <option value="{{ $value['id'] }}" selected>{{ $value['libelle'] }}</option>
                                            @else
                                                <option value="{{ $value['id'] }}">{{ $value['libelle'] }}</option>
                                            @endif
                                            @empty
                                            <option value="">Aucune donnée disponible</option>
                                        @endforelse
                                    </select>
                                </div><!--end col-->
                            </div>
                            <div class="form-row">
                                {{-- <div class="col-md-6 mb-3">
                                    <label>Onglet facturation</label>
                                    <select class="form-control mb-3 custom-select" style="width: 100%; height:36px;" name="onglet_facturation_id" required>
                                        <option value="">Choisir un onglet</option>
                                        @forelse ($onglet_facturation as $value)
                                            @if ($value['id']==$catalogue->onglet_facturation_id)
                                                <option value="{{ $value['id'] }}" selected>{{ $value['libelle'] }}</option>
                                            @else
                                                <option value="{{ $value['id'] }}">{{ $value['libelle'] }}</option>
                                            @endif
                                            @empty
                                            <option value="">Aucun onglet de facturation disponible</option>
                                        @endforelse
                                    </select>
                                </div><!--end col--> --}}
                                <div class="col-md-6 mb-3">
                                    <label>Mode de reversement</label>
                                    <select class="form-control mb-3 custom-select" style="width: 100%; height:30px;" name="mode_reversement_id" required>
                                        @forelse ($mode_reversement as $value)
                                            @if ($value['id']==$catalogue->mode_reversement_id)
                                        <option value="{{ $value['id'] }}" {{ (($value['libelle']) == 'Reversement classique') ? 'selected' : '' }} >{{ $value['libelle'] }}</option>
                                            @else
                                                <option value="{{ $value['id'] }}">{{ $value['libelle'] }}</option>
                                            @endif
                                            @empty
                                            <option value="">Aucun mode de reversement disponible</option>
                                        @endforelse
                                    </select>
                                </div><!--end col-->
                                <div class="form-group">
                                    <label for="commentaire">Commentaire(Champ non obligatoire)</label>
                                    <textarea class="form-control" id="commentaire" name="commentaire" style="width: 750px;min-width:750px;max-width:750px;height:170px;min-height:170px;max-height:170px;"> {{$catalogue->commentaire}} </textarea>
                                </div>
                            </div>
                            <div class="repeater-custom-show-hide">
                                <div data-repeater-list="car">
                                    @foreach ($catalogue->sim_designation as $val)
                                        <div data-repeater-item="">
                                            <div id="first{{$loop->iteration-1}}" class="form-group row d-flex align-items-end ligne">
                                                <div class="col-md-2 mb-3">
                                                    <label>Sim head</label>
                                                    <input type="text" name="car[{{$loop->iteration-1}}][sim_head]" value="{{ $val->sim_head }}" class="form-control">
                                                </div><!--end col-->
                                                <div class="col-md-3 mb-3">
                                                    <label class="control-label">Identifiant désignation</label>
                                                    <input type="text" name="car[{{$loop->iteration-1}}][id_designation]" value="{{ $val->identifiant_designation }}" class="form-control">
                                                </div><!--end col-->
                                                <div class="col-md-2 mb-3">
                                                    <label class="control-label">Onglet facturation</label>
                                                    <select class="form-control custom-select" name="car[{{$loop->iteration-1}}][onglet_facturation_id]" required>
                                                        <option value="">Choisir un onglet</option>
                                                        @forelse ($onglet_facturation as $value)
                                                            @if ($value['id']==$val->onglet_facturation_id)
                                                                <option value="{{ $value['id'] }}" selected>{{ $value['libelle'] }}</option>
                                                            @else
                                                                <option value="{{ $value['id'] }}">{{ $value['libelle'] }}</option>
                                                            @endif
                                                            @empty
                                                            <option value="">Aucun onglet de facturation disponible</option>
                                                        @endforelse
                                                    </select>
                                                </div><!--end col-->
                                                <div class="col-md-2 mb-3">
                                                    <label for="validationCustom05" class="control-label">Blacklist C2C</label>
                                                    <select class="form-control custom-select" name="car[{{$loop->iteration-1}}][blacklist_c2c]" required>
                                                        <option value="">Choisir</option>
                                                        @forelse ($blacklist_c2c as $value)
                                                            @if ($value['id']==$val->blacklist_c2c)
                                                                <option value="{{ $value['id'] }}" selected>{{ $value['libelle'] }}</option>
                                                            @else
                                                                <option value="{{ $value['id'] }}">{{ $value['libelle'] }}</option>
                                                            @endif
                                                            @empty

                                                            <option value="">Aucune donnée disponible</option>
                                                        @endforelse
                                                    </select>
                                                </div><!--end col-->
                                                <div class="col-md-2 mb-3">
                                                    <label for="validationCustom05" class="my-2">Taux commission</label>
                                                    <input type="number"  step="any" min="0" class="form-control" name="taux_commission" value="{{ $val->taux_commission }}" required>
                                                </div><!--end col-->
                                                <div class="col-md-1" style="margin-bottom: 1.2rem !important; padding-left: 25px;">
                                                    <span data-repeater-delete="" id="supprimer{{$loop->iteration-1}}" class="btn btn-gradient-danger">
                                                        <span class="far fa-trash-alt"></span>
                                                    </span>
                                                </div><!--end col-->
                                            </div><!--end row-->
                                        </div><!--end /div-->
                                    @endforeach
                                </div><!--end repet-list-->
                                <div class="form-group row mb-0">
                                    <div class="col-sm-12">
                                        <span data-repeater-create="" class="btn btn-gradient-secondary btn-md">
                                            <span class="fa fa-plus"></span> Ajouter une sim
                                        </span>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div> <!--end repeter-->
                            <br>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i>&nbsp;Modifier</button>
                                <a href="{{ route('catalogue.index') }}" class="btn btn-dark"><i class="fas fa-times-circle"></i>&nbsp;Annuler</a>
                            </div>
                        </form>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end col-->
        </div>
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
    <script src="{{ URL::asset('plugins/repeater/jquery.repeater.min.js')}}"></script>
    <script src="{{ URL::asset('assets/pages/jquery.form-repeater.js')}}"></script>
    <script>
    $(document).ready(function () {
            $('#supprimer0').hide();
    });
    </script>
@stop
