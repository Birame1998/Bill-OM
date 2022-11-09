@extends('layouts.backend')
@section('afterheaderStyle')
    <!-- Page JS Plugins -->
    <script src="{{  asset('assets/js/jquery.bootstrap.wizard.js') }}"></script>
    <script src="{{  URL::asset('assets/js/jquery.validate.min.js') }}"></script>
    <!-- Page JS Code -->
    <script src="{{  URL::asset('assets/js/be_forms_wizard.min.js') }}"></script>
@stop

@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                @component('common-components.breadcrumb')
                    @slot('title') Création utilisateur @endslot
                @endcomponent
            </div><!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <!--start wizard-->
                        <div class="col mx-auto">
                            <!-- Validation Wizard Material -->
                            <div class="js-wizard-validation-material block">
                                <!-- Step Tabs -->
                                <ul class="nav nav-tabs nav-tabs-alt nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#wizard-validation-material-step1" data-toggle="tab">1. Informations utilisateur</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#wizard-validation-material-step2" data-toggle="tab">2. Attribution rôle</a>
                                    </li>
                                </ul>
                                <!-- END Step Tabs -->
                                <!-- Form -->
                                <form class="js-wizard-validation-material-form" method="POST" action="{{ route('users.store') }}">
                                    @csrf
                                    <!-- Steps Content -->
                                    <div class="block-content block-content-full tab-content" style="min-height: 267px;">
                                        <!-- Step 1 -->
                                        <div class="tab-pane active" id="wizard-validation-material-step1" role="tabpanel">
                                            <div class="row"><br><br></div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="prenom">Prénom</label>
                                                        <input class="form-control" type="text" name="prenom" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="prenom">Nom</label>
                                                        <input class="form-control" type="text" name="nom" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="structure">Structure rattachée</label>
                                                    <select class="select2 form-control mb-3 custom-select" style="width: 100%; height:36px;" name="structure_id" required>
                                                        <option value="">Choisir une structure</option>
                                                        @forelse ($structures as $value)
                                                            <option value="{{$value->id}}">{{$value->libelle}}</option>
                                                            @empty
                                                            <option value="">Aucune structure disponible</option>
                                                        @endforelse
                                                    </select>
                                                </div><!--end col-->
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="login">Login Windows</label>
                                                        <input class="form-control" type="text" name="login_windows">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input class="form-control" type="text" name="email">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END Step 1 -->

                                        <!-- Step 2 -->
                                        <div class="tab-pane" id="wizard-validation-material-step2" role="tabpanel">
                                            <div class="form-group">
                                                <div class="row">
                                                    @forelse ($roles_no_super as $role)
                                                        <div class="col-md-5 custom-control custom-radio m-3 mx-auto shadow-sm rounded">
                                                            <input value="{{ $role->id }}" class="custom-control-input" type="radio"
                                                                name="role_id" id="example-radio{{ $role->id }}" required>
                                                            <label class="custom-control-label"
                                                                for="example-radio{{ $role->id }}"><strong>{{ $role->name }}</strong></label>
                                                            <p>{{ $role->description }}</p>
                                                        </div>
                                                    @empty
                                                        <p>Aucun rôle disponible.</p>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END Step 2 -->
                                    </div>
                                    <!-- END Steps Content -->

                                    <!-- Steps Navigation -->
                                    <div class="block-content block-content-sm block-content-full bg-body-light">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-dark" data-wizard="prev">
                                                    <i class="fa fa-angle-left"></i> Précedent
                                                </button>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="button" class="btn btn-primary" data-wizard="next">
                                                    Suivant <i class="fa fa-angle-right"></i>
                                                </button>
                                                <button type="submit" class="btn btn-primary" data-wizard="finish">
                                                    <i class="fa fa-check"></i> Terminer
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Steps Navigation -->
                                </form>
                                <!-- END Form -->
                            </div>
                            <!-- END Validation Wizard 2 -->
                        </div>
                        <!--end wizard-->
                    </div>
                </div><!--end card-->
            </div><!--end col-->
        </div><!-- end row -->
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
