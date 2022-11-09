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
                    @slot('title') Modification du rôle @endslot
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
                                        <a class="nav-link active" href="#wizard-validation-material-step1" data-toggle="tab">1. Informations du rôle</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#wizard-validation-material-step2" data-toggle="tab">2. Attribution des permissions</a>
                                    </li>
                                </ul>
                                <!-- END Step Tabs -->
                                <!-- Form -->
                                <form class="js-wizard-validation-material-form" method="POST" action="{{ route('roles.update',$ancienRole[0]) }}">
                                    @method('PATCH')
                                    @csrf
                                    <!-- Steps Content -->
                                    <div class="block-content block-content-full tab-content" style="min-height: 267px;">
                                        <!-- Step 1 -->
                                        <div class="tab-pane active" id="wizard-validation-material-step1" role="tabpanel">
                                            <div class="row"><br><br></div>
                                            <div class="row justify-content-center">
                                                <div class="col-lg-8" style="padding-left: 0px;">
                                                    <div class="form-group row">
                                                        <label for="name" class="col-sm-2 col-form-label text-right">Libellé</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text" name="libelle" value="{{$ancienRole[0]->name}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-email-input" class="col-sm-2 col-form-label text-right">Description</label>
                                                        <div class="col-sm-10">
                                                            <textarea class="form-control" rows="2" name="description">{{$ancienRole[0]->description}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END Step 1 -->

                                        <!-- Step 2 -->
                                        <div class="tab-pane" id="wizard-validation-material-step2" role="tabpanel">
                                            <div class="row"><br><br></div>
                                            <div class="form-group">
                                                <div class="row">
                                                    {{-- Accordion1 START --}}
                                                    <div class="col-md-6">
                                                        <div class="accordion" id="accordionExample">

                                                            <div class="card border mb-1 shadow-none">
                                                                <div class="card-header" id="headingOne">
                                                                    <a href="" class="collapsed text-dark" data-toggle="collapse" data-target="#collapse0" aria-expanded="false" aria-controls="collapseOne">
                                                                        Accès Rubrique
                                                                    </a>
                                                                </div>
                                                                <div id="collapse0" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                                    <div class="card-body">
                                                                        <div class="row mx-auto">
                                                                            @forelse ($permToRubrique as $perm)
                                                                                @if (in_array($perm->id ,$roleSelect))
                                                                                    <div class="col-4 custom-control custom-checkbox mb-5">
                                                                                        <input class="custom-control-input" type="checkbox"
                                                                                            name="permissions[]" checked
                                                                                            id="permissions{{ $perm->id }}"
                                                                                            value="{{ $perm->id }}">
                                                                                        <label class="custom-control-label"
                                                                                            for="permissions{{ $perm->id }}">{{ $perm->description }}</label>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="col-4 custom-control custom-checkbox mb-5">
                                                                                        <input class="custom-control-input" type="checkbox"
                                                                                            name="permissions[]"
                                                                                            id="permissions{{ $perm->id }}"
                                                                                            value="{{ $perm->id }}">
                                                                                        <label class="custom-control-label"
                                                                                            for="permissions{{ $perm->id }}">{{ $perm->description }}</label>
                                                                                    </div>
                                                                                @endif

                                                                                @empty
                                                                                    <p>Aucune permission disponible.</p>
                                                                            @endforelse
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="card mb-1 border shadow-none">
                                                                <div class="card-header" id="headingTwo">
                                                                    <a href="" class="collapsed text-dark" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapseTwo">
                                                                        Rôle
                                                                    </a>
                                                                </div>
                                                                <div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                                    <div class="card-body">
                                                                        <div class="row mx-auto">
                                                                            @forelse ($permsOnRoles as $perm)
                                                                                @if (in_array($perm->id ,$roleSelect))
                                                                                    <div class="col-4 custom-control custom-checkbox mb-5">
                                                                                        <input class="custom-control-input" type="checkbox"
                                                                                            name="permissions[]" checked
                                                                                            id="permissions{{ $perm->id }}"
                                                                                            value="{{ $perm->id }}">
                                                                                        <label class="custom-control-label"
                                                                                            for="permissions{{ $perm->id }}">{{ $perm->description }}</label>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="col-4 custom-control custom-checkbox mb-5">
                                                                                        <input class="custom-control-input" type="checkbox"
                                                                                            name="permissions[]"
                                                                                            id="permissions{{ $perm->id }}"
                                                                                            value="{{ $perm->id }}">
                                                                                        <label class="custom-control-label"
                                                                                            for="permissions{{ $perm->id }}">{{ $perm->description }}</label>
                                                                                    </div>
                                                                                @endif

                                                                                @empty
                                                                                    <p>Aucune permission disponible.</p>
                                                                            @endforelse
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card mb-1 border shadow-none">
                                                                <div class="card-header" id="headingTwo">
                                                                    <a href="" class="collapsed text-dark" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapseTwo">
                                                                        Tracking
                                                                    </a>
                                                                </div>
                                                                <div id="collapse3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                                    <div class="card-body">
                                                                        <div class="row mx-auto">
                                                                            @forelse ($permsOnTracking as $perm)
                                                                                @if (in_array($perm->id ,$roleSelect))
                                                                                    <div class="col-4 custom-control custom-checkbox mb-5">
                                                                                        <input class="custom-control-input" type="checkbox"
                                                                                            name="permissions[]" checked
                                                                                            id="permissions{{ $perm->id }}"
                                                                                            value="{{ $perm->id }}">
                                                                                        <label class="custom-control-label"
                                                                                            for="permissions{{ $perm->id }}">{{ $perm->description }}</label>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="col-4 custom-control custom-checkbox mb-5">
                                                                                        <input class="custom-control-input" type="checkbox"
                                                                                            name="permissions[]"
                                                                                            id="permissions{{ $perm->id }}"
                                                                                            value="{{ $perm->id }}">
                                                                                        <label class="custom-control-label"
                                                                                            for="permissions{{ $perm->id }}">{{ $perm->description }}</label>
                                                                                    </div>
                                                                                @endif

                                                                                @empty
                                                                                    <p>Aucune permission disponible.</p>
                                                                            @endforelse
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- Accordion1 END --}}
                                                    {{-- Accordion2 START --}}
                                                    <div class="col-md-6">
                                                        <div class="accordion" id="accordionExample">
                                                            <div class="card border mb-1 shadow-none">
                                                                <div class="card-header" id="headingOne">
                                                                    <a href="" class="collapsed text-dark" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapseOne">
                                                                        Utilisateur
                                                                    </a>
                                                                </div>
                                                                <div id="collapse5" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                                    <div class="card-body">
                                                                        <div class="row mx-auto">
                                                                            @forelse ($permsOnUsers as $perm)
                                                                                @if (in_array($perm->id ,$roleSelect))
                                                                                    <div class="col-4 custom-control custom-checkbox mb-5">
                                                                                        <input class="custom-control-input" type="checkbox"
                                                                                            name="permissions[]" checked
                                                                                            id="permissions{{ $perm->id }}"
                                                                                            value="{{ $perm->id }}">
                                                                                        <label class="custom-control-label"
                                                                                            for="permissions{{ $perm->id }}">{{ $perm->description }}</label>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="col-4 custom-control custom-checkbox mb-5">
                                                                                        <input class="custom-control-input" type="checkbox"
                                                                                            name="permissions[]"
                                                                                            id="permissions{{ $perm->id }}"
                                                                                            value="{{ $perm->id }}">
                                                                                        <label class="custom-control-label"
                                                                                            for="permissions{{ $perm->id }}">{{ $perm->description }}</label>
                                                                                    </div>
                                                                                @endif

                                                                                @empty
                                                                                    <p>Aucune permission disponible.</p>
                                                                            @endforelse
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card mb-1 border shadow-none">
                                                                <div class="card-header" id="headingTwo">
                                                                    <a href="" class="collapsed text-dark" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapseTwo">
                                                                        Permission
                                                                    </a>
                                                                </div>
                                                                <div id="collapse6" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                                    <div class="card-body">
                                                                        <div class="row mx-auto">
                                                                            @forelse ($permsOnPermissions as $perm)
                                                                                @if (in_array($perm->id ,$roleSelect))
                                                                                    <div class="col-4 custom-control custom-checkbox mb-5">
                                                                                        <input class="custom-control-input" type="checkbox"
                                                                                            name="permissions[]" checked
                                                                                            id="permissions{{ $perm->id }}"
                                                                                            value="{{ $perm->id }}">
                                                                                        <label class="custom-control-label"
                                                                                            for="permissions{{ $perm->id }}">{{ $perm->description }}</label>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="col-4 custom-control custom-checkbox mb-5">
                                                                                        <input class="custom-control-input" type="checkbox"
                                                                                            name="permissions[]"
                                                                                            id="permissions{{ $perm->id }}"
                                                                                            value="{{ $perm->id }}">
                                                                                        <label class="custom-control-label"
                                                                                            for="permissions{{ $perm->id }}">{{ $perm->description }}</label>
                                                                                    </div>
                                                                                @endif
                                                                                @empty
                                                                                    <p>Aucune permission disponible.</p>
                                                                            @endforelse
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card mb-1 border shadow-none">
                                                                <div class="card-header" id="headingTwo">
                                                                    <a href="" class="collapsed text-dark" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapseTwo">
                                                                        Facturation
                                                                    </a>
                                                                </div>
                                                                <div id="collapse10" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                                    <div class="card-body">
                                                                        <div class="row mx-auto">
                                                                            @forelse ($permsOnFacture as $perm)
                                                                                @if (in_array($perm->id ,$roleSelect))
                                                                                    <div class="col-4 custom-control custom-checkbox mb-5">
                                                                                        <input class="custom-control-input" type="checkbox"
                                                                                            name="permissions[]" checked
                                                                                            id="permissions{{ $perm->id }}"
                                                                                            value="{{ $perm->id }}">
                                                                                        <label class="custom-control-label"
                                                                                            for="permissions{{ $perm->id }}">{{ $perm->description }}</label>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="col-4 custom-control custom-checkbox mb-5">
                                                                                        <input class="custom-control-input" type="checkbox"
                                                                                            name="permissions[]"
                                                                                            id="permissions{{ $perm->id }}"
                                                                                            value="{{ $perm->id }}">
                                                                                        <label class="custom-control-label"
                                                                                            for="permissions{{ $perm->id }}">{{ $perm->description }}</label>
                                                                                    </div>
                                                                                @endif
                                                                                @empty
                                                                                    <p>Aucune permission disponible.</p>
                                                                            @endforelse
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- Accordion2 END --}}
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
<!-- Parsley js -->
    <script src="{{ URL::asset('plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{ URL::asset('assets/pages/jquery.validation.init.js')}}"></script>
    <!-- App js -->
    <script src="{{URL::asset('assets/js/jquery.core.js')}}"></script>
@stop
