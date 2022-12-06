@extends('layouts.backend')
@section('headerStyle')
<link href="{{ URL::asset('plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
<link href="{{ URL::asset('plugins/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('plugins/timepicker/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
<link href="{{ URL::asset('plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" />

<!-- DataTables -->
<link href="{{ URL::asset('plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ URL::asset('plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

@stop

@section('content')
<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            @component('common-components.breadcrumb')
            @slot('title') Liste des catalogues @endslot
            @endcomponent
        </div>
        <!--end col-->
    </div>
    <!-- end page title end breadcrumb -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    {{-- <form class="form-parsley" novalidate="" method="POST" action="/catalogue/search"> --}}
                    <form>
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-3 mb-4">
                                {{-- <input type="text" class="form-control" name="nom_partenaire" required> --}}
                                {{-- <div class="input-group">
                                       <input type="text" class="form-control" name="nom_partenaire" placeholder="nom partenaire">
                                    </div> --}}
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
                            <div class="col-md-4 mb-4">
                                <select class="form-control mb-3" name="search" data-column="1">
                                    <option value="">Choisir un onglet</option>
                                    @if(isset($onglet))
                                    @forelse ($onglet_facturation as $value)
                                    @if ($value['id']== $onglet)
                                    <option value="{{$value['libelle']}}" selected>{{$value['libelle']}}</option>
                                    @else
                                    <option value="{{$value['libelle']}}">{{$value['libelle']}}</option>
                                    @endif
                                    @empty
                                    <option value="">Aucun partenaire disponible</option>
                                    @endforelse
                                    @else
                                    @forelse ($onglet_facturation as $value)
                                    <option value="{{ $value['libelle'] }}">{{ $value['libelle'] }}</option>
                                    @empty
                                    <option value="">Aucun onglet de facturation disponible</option>
                                    @endforelse
                                    @endif
                                </select>
                            </div>
                            {{-- <div class="col-md-2 mb-6">
                                    <form>
                                        <input type="search" class="form-control" placeholder="Choisir un onglet ici" name="search" value="{{ request('search') }}">
                    </form>
                </div> --}}
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
            {{-- </form> --}}
            @can('creation_catalogue')
            <h4 class="mt-0 header-title"></h4>
            <div class="pull-right">
                <a href="{{ route('catalogue.create') }}" class="btn btn-primary mb-2 mb-lg-3"><i class="fas fa-plus"></i> &nbsp;Ajouter</a>
            </div>
            @endcan
            <br>

            <table id="datatable-catalogue" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Num. AP</th>
                        <th>Nom partenaire</th>
                        <th>Type</th>
                        <th>Inclure</th>
                        <th>Taux com.</th>
                        <th>ID désignation</th>
                        <th>Compte bancaire</th>
                        <th>Mode reversement</th>
                        <th>Sim head</th>
                        <th>Onglet facturation</th>
                        <th class="action">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($catalogue as $value)

                    <tr>
                        <td>{{ $value->num_ap }}</td>
                        <td>
                            {{ $value->nom_partenaire }}
                            @if($value->commentaire!=null) &nbsp;
                            <i class="fas fa-comment text-orange font-15"></i>
                            @endif
                        </td>
                        <td>{{ $type_partenaire[$value->type_partenaire_id]['libelle'] }}</td>
                        <td>{{ $inclure[$value->inclure_id]['libelle'] }}</td>
                        <td>{{ $value->taux_commission }}</td>
                        <td>
                            @foreach($value->sim_designation as $val)
                            @if ($val->identifiant_designation)
                            <li style="list-style-type: none;">{{ $val->identifiant_designation }}</li>
                            @endif
                            @endforeach
                        </td>
                        <td>{{ $value->compte_bancaire }}</td>
                        <td>{{ $mode_reversement[$value->mode_reversement_id]['libelle'] }}</td>
                        <td>
                            @foreach($value->sim_designation as $val)
                            <li style="list-style-type: none;">{{ $val->sim_head }}</li>
                            @endforeach
                        </td>
                        <td>
                            @foreach($value->sim_designation as $val)
                            <li style="list-style-type: none;">{{ $onglet_facturation[$val->onglet_facturation_id]['libelle'] }}</li>
                            @endforeach
                        </td>
                        <td align="center">
                            @can("modification_catalogue")
                            <a href="{{ route('catalogue.edit', encrypt($value->id)) }}" class="mr-1"><i class="fas fa-edit text-info font-14"></i></a>
                            @endcan
                            <a href="#" data-toggle="modal" data-target="#Afficher" onclick="DetailsCatalogue('{{$value->id}}');" class="mr-1"><i class="fas fa-eye text-orange font-14"></i></a>
                            @can("suppression_catalogue")
                            <a href="#" data-toggle="modal" data-target="#Supprimer" onclick="Suppression('{{$value->id}}')" class="mr-1"><i class="fas fa-trash-alt text-danger font-14"></i></a>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <li class="list-group-item list-group-item-danger">Catalogue non trouvé</li>
                    @endforelse
                </tbody>
            </table>
            @if ($catalogue->hasPages())
            <div class="pagination-wrapper d-flex justify-content-center">
                {{ $catalogue->appends($_GET)->links()}}
            </div>
            @endif
        </div>
    </div>
</div> <!-- end col -->
</div> <!-- end row -->
</div><!-- container -->

<div class="modal fade bs-example-modal-lg" id="Afficher" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Détails catalogue</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="4" style="text-align: center;background-color: #f79240;color: white;">
                                Nom du partenaire : <strong id="nom_partenaire"></strong>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="3">Numéro AP</th>
                            <td id="num_ap"></td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="3">Type de partenaire</th>
                            <td id="type"></td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="3">Inclure</th>
                            <td id="inclure"></td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="3">Taux de commission</th>
                            <td id="taux"></td>
                        </tr>
                        <tr>
                        <tr rowspan="3">
                            <th scope="row">Sim head</th>
                            <th scope="row">Identifiant désignation</th>
                            <th scope="row">Onglet facturation</th>
                            <th scope="row">Blacklist C2C</th>
                        </tr>
                        </tr>
                        <tr>
                            <td>
                                <ul id="sim_head" style="list-style-type:none;padding-left: 0px;margin-bottom:0px"></ul>
                            </td>
                            <td>
                                <ul id="id_designation" style="list-style-type:none;padding-left: 0px;margin-bottom:0px"></ul>
                            </td>
                            <td>
                                <ul id="onglet_facturation" style="list-style-type:none;padding-left: 0px;margin-bottom:0px"></ul>
                            </td>
                            <td>
                                <ul id="blacklist_c2c" style="list-style-type:none;padding-left: 0px;margin-bottom:0px"></ul>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="3">Compte bancaire</th>
                            <td id="compte_bancaire"></td>
                        </tr>
                        <tr>
                            <th scope="row" colspan="3">Mode reversement</th>
                            <td id="mode_reversement"></td>
                        </tr>

                        <tr>
                            <th scope="row" colspan="1">Commentaire</th>
                            <td id="commentaire" colspan="6"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="Supprimer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalLabel">Suppression catalogue</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="supprimer">
                @method('DELETE')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <h5 align="center" style="color: black">Voulez-vous supprimer le catalogue ?</h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" style="color: white"><i class="fas fa-trash"></i> &nbsp;Supprimer</button>
                    <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times"></i> &nbsp;Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
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

<script src="{{ URL::asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<!-- Buttons examples -->
<script src="{{ URL::asset('plugins/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{ URL::asset('plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('plugins/datatables/jszip.min.js')}}"></script>
<script src="{{ URL::asset('plugins/datatables/pdfmake.min.js')}}"></script>
<script src="{{ URL::asset('plugins/datatables/vfs_fonts.js')}}"></script>
<script src="{{ URL::asset('plugins/datatables/buttons.html5.min.js')}}"></script>
<script src="{{ URL::asset('plugins/datatables/buttons.print.min.js')}}"></script>
<script src="{{ URL::asset('plugins/datatables/buttons.colVis.min.js')}}"></script>
<!-- Responsive examples -->
<script src="{{ URL::asset('plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{ URL::asset('plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/pages/jquery.datatable.init.js')}}"></script>

<script>
    function Suppression(id) {
        $('#supprimer').attr("action", "/catalogue/" + id)
    }

    function DetailsCatalogue(id) {
        $.get('/catalogue/' + id, function(valeur) {
            console.log($('#nom_partenaire').html(valeur.data.nom_partenaire));
            $('#num_ap').html(valeur.data.num_ap)
            $('#type').html(valeur.type)
            $('#inclure').html(valeur.inclure)
            $('#commentaire').html(valeur.data.commentaire)
            $('#taux').html(valeur.data.taux_commission + "%")
            $('.id_designation').remove()
            for (var i = 0; i < valeur.data.sim_designation.length; i++) {
                $('#id_designation').append('<li class="id_designation">' + valeur.data.sim_designation[i].identifiant_designation + '</li>')
            }
            $('#compte_bancaire').html(valeur.data.compte_bancaire)
            $('#mode_reversement').html(valeur.mode_reversement)
            $('.sim_head').remove()
            for (var i = 0; i < valeur.data.sim_designation.length; i++) {
                $('#sim_head').append('<li class="sim_head">' + valeur.data.sim_designation[i].sim_head + '</li>')
            }
            $('.onglet_facturation').remove()
            for (var i = 0; i < valeur.onglet_facturation.length; i++) {
                $('#onglet_facturation').append('<li class="onglet_facturation">' + valeur.onglet_facturation[i]['onglet_facturation'] + '</li>')
            }

            $('.blacklist_c2c').remove()
            for (var i = 0; i < valeur.blacklist_c2c.length; i++) {
                $('#blacklist_c2c').append('<li class="blacklist_c2c">' + valeur.blacklist_c2c[i]['blacklist_c2c'] + '</li>')
            }
        })
    }

    // $(document).ready(function() {
    //     $('#datatable-catalogue').DataTable({
    //         order: [
    //             [0, 'desc']
    //         ],
    //     });
    // });
</script>
@stop