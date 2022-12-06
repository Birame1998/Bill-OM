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
                    @slot('title') Modification d'une facturation @endslot
                @endcomponent
            </div><!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title"></h4>
                        <form class="form-parsley" novalidate="" method="POST" action="{{ route('facturation_envalidation.update', $facturation,$facturation->id) }}">
                            @method('PATCH')
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="directeur_id">Nom partenaire</label>
                                    <input type="text" class="form-control" name="nom_partenaire" value="{{ $facturation->nom_partenaire }}" required>
                                </div><!--end col-->
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom01">Numéro AP</label>
                                    <input type="number" class="form-control" name="num_ap"  value="{{ $facturation->num_ap }}" min="0" required>
                                </div><!--end col-->
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom05" class="my-2">Transaction amount</label>
                                    <input type="number"  step="any" min="0" class="form-control" name="transaction_amount" value="{{ $facturation->transaction_amount }}" required>
                                </div><!--end col-->
                                <div class="col-md-6 mb-3">
                                    <label for="type_action_id" class="my-2">Commission</label>
                                    <input type="number"  step="any" min="0" class="form-control" name="commission" value="{{ $facturation->commission }}" required>
                                </div><!--end col-->    
                                <div class="col-md-6 mb-3">
                                    <label>A reverser</label>
                                    <input type="number"  step="any" min="0" class="form-control" name="a_reverser" value="{{ $facturation->a_reverser }}" required>
                                </div><!--end col-->
                                    <div class="col-md-6 mb-3">
                                    <label class="my-2">Sim head</label>
                                    <input type="text" class="form-control" name="sim_head" value="{{ $facturation->sim_head }}" required>
                                    </div><!--end col-->                                      
                            </div>                            
                                    <br>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i>&nbsp;Modifier</button>
                                <a href="{{ route('facturation_envalidation.index') }}" class="btn btn-dark"><i class="fas fa-times-circle"></i>&nbsp;Annuler</a>
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
