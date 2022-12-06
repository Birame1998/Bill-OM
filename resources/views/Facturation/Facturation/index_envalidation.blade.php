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
                        @slot('title') Liste des factures du {{date('d/m/Y',strtotime( '-1 days' ))}} @endslot
                @endcomponent
            </div><!--end col-->
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <form action="">
        
                        <div class="row justify-content-center">
                            <div class="input-group w-25 justify-content-center" name="nom_partenaire">
                              <select class="select2 form-control mb-3" style="width: 100%; height:36px;" name="nom_partenaire" data-column="0">
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
                                    <div class="input-group w-25 justify-content-center ml-5">
                                    <input type="text" id="daterange" class="form-control" name="dates" value="{{$dates ?? date('d/m/Y',strtotime( '-1 days' )).' - '.date('d/m/Y',strtotime( '-1 days' )) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="dripicons-calendar"></i></span>&nbsp;
                                    </div>&nbsp;
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
                                    @elseif (Route::is('recyclage_uv.search') || Route::is('recyclage_uv.index'))
                                    <a href="{{ route('recyclage_uv.index') }}" class="btn btn-dark">
                                        <span style="color:white">Tous</span>
                                    </a>   
                                    @endif
                                </div> 
                            </div>    
                            
                        </form>
                        <br>
                        <form action="" method="POST" id="valide_rejet">
                            @csrf
                            <div class="row justify-content-center">
                                <span style="background-color: #FF7900"><strong>{{ $statut_validation[1]['libelle'] }}</strong></span>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-10">
                                    @can("validation_facture")
                                        <a href="#" data-toggle="modal" data-target="#Valider" onclick="ValidationMany()" class="btn btn-success mb-2 mb-lg-3"><i class="fas fa-check"></i> &nbsp;Valider tous</a> &nbsp; &nbsp;
                                    @endcan
                                    @can("rejet_facture")
                                        <a href="#" data-toggle="modal" data-target="#Rejeter" onclick="RejetMany()" class="btn btn-danger mb-2 mb-lg-3"><i class="fas fa-times"></i> &nbsp;Rejeter tous</a> &nbsp; &nbsp;
                                    @endcan
                                </div>
                                @can("ajout_facture")
                                    {{-- <div class="col-lg-2"><!-- use pull-right -->
                                        <a href="{{ route('catalogue.create') }}" class="btn btn-primary mb-2 mb-lg-3"><i class="fas fa-plus"></i> &nbsp;Ajouter</a> &nbsp; &nbsp;
                                    </div> --}}
                                @endcan
                            </div>
                            <div class="modal fade" id="Valider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mt-0" id="exampleModalLabel">Validation</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 align="center" style="color: black">Voulez-vous valider ces factures ?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> &nbsp;Valider tous</button> &nbsp; &nbsp;
                                            <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times"></i> &nbsp;Annuler</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="Rejeter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mt-0" id="exampleModalLabel">Rejet</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <label class="my-2">Motif de rejet</label>
                                            <input type="text" class="form-control" name="motif_rejet" id="motif_rejet" autocomplete="on" required>
                                            {{-- <h5 align="center" style="color: black">Voulez-vous rejeter ces factures ?</h5> --}}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-times"></i> &nbsp;Rejeter tous</button> &nbsp; &nbsp;
                                            <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times"></i> &nbsp;Annuler</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @can("validation_facture")
                                <div class="checkbox checkbox-pink">
                                    <input id="checkbox6b" type="checkbox" name="select_all" onclick="caseCocherAll('{{json_encode(array_column($onglet_facturation, 'id'))}}')" >
                                    <label for="checkbox6b" id="texte">
                                        &nbsp;Toutes les factures (0)
                                    </label>
                                </div>
                            @endcan

                            @foreach ($onglet_facturation as $val)
                            @if ($facturation->where('onglet_facturation_id', $val['id'])->count()==0)
                            @if (Route::is('facturation_envalidation.search') && $facturation->where('onglet_facturation_id', $val['id'])->count()!=0)
                                        <div class="accordion" id="accordionExample-faq">
                                            <div class="card shadow-none border mb-1">
                                                <div class="card-header" id="heading{{$val['id']}}">
                                                    <h5 class="my-0">
                                                        <button class="btn btn-link collapsed ml-4 shadow-none" type="button" data-toggle="collapse" data-target="#collapse{{$val['id']}}" aria-expanded="false" aria-controls="collapse{{$val['id']}}">
                                                            {{$val['libelle']}} ({{$facturation->where('onglet_facturation_id', $val['id'])->count()}})
                                                        </button>
                                                        @can("validation_facture")
                                                            <input type="checkbox" onclick="caseCocherOutside('{{$val['id']}}')" class="outside" id="select_all_outside{{$val['id']}}">&nbsp;<span class="case{{$val['id']}}" style="font-size:12px">0 ligne(s) cochée(s)</span>
                                                        @endcan
                                                        (Total reversements: {{number_format($facturation->where('onglet_facturation_id', $val['id'])->sum('a_reverser'))}})
                                                    </h5>
                                                </div>
                                                <div id="collapse{{$val['id']}}" class="collapse" aria-labelledby="heading{{$val['id']}}" data-parent="#accordionExample-faq">
                                                    <div class="card-body" style="overflow-x: auto;">
                                                        <table class="table table-striped table-bordered nowrap">
                                                            <thead>
                                                                <tr>
                                                                    @can("validation_facture")
                                                                        <th><input type="checkbox" name="select_all" onclick="caseCocherInside('{{$val['id']}}')" class="inside" id="select_all_inside{{$val['id']}}">&nbsp;Tous</th>
                                                                    @endcan
                                                                    <th>Num. AP</th>
                                                                    <th>Nom partenaire</th>
                                                                    <th>Sim head</th>
                                                                    <th>Transaction amount</th>
                                                                    <th>Commission</th>
                                                                    <th>A reverser</th>
                                                                    <th>Date transaction</th>
                                                                    <th class="action">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($facturation as $facture)
                                                                    @if ($facture->onglet_facturation_id==$val['id'])
                                                                        <tr>
                                                                            @can("validation_facture")
                                                                                <td>
                                                                                    <input type="checkbox" name="selected_id[]" class="checkbox one selectCb{{$facture->onglet_facturation_id}}" onclick="caseCocherOne('{{$facture->onglet_facturation_id}}')" value="{{$facture->id}}">
                                                                                </td>
                                                                            @endcan
                                                                            <td>{{ $facture->num_ap }}</td>
                                                                            <td>
                                                                            <pre class="format-pre">{{ $facture->nom_partenaire }}</pre>
                                                                            </td>
                                                                            <td>{{ $facture->sim_head }}</td>
                                                                            <td>{{ number_format($facture->transaction_amount, 2, ","," ") }}</td>
                                                                            <td>{{ number_format($facture->commission, 2, ","," " )}}</td>
                                                                            <td>{{ number_format($facture->a_reverser, 2, ","," " ) }}</td>
                                                                            <td>{{  date('d/m/Y', strtotime($facture->date_transaction)) }}</td>
                                                                            <td align ="center">
                                                                                @can("validation_facture")
                                                                                    <a href="#" data-toggle="modal" data-target="#ValiderUnique" onclick="ValidationUnique('{{$facture->id}}')" class="mr-1"><i class="fas fa-check-circle text-vert font-16"></i></a>
                                                                                @endcan
                                                                                @can("rejet_facture")
                                                                                    <a href="#" data-toggle="modal" data-target="#RejetUnique" onclick="RejetUnique('{{$facture->id}}')" class="mr-1"><i class="fas fa-times-circle text-danger font-16"></i></a>
                                                                                @endcan
                                                                                <a href="#" data-toggle="modal" data-target="#Afficher" onclick="DetailsCatalogue('{{$facture->id}}')" class="mr-1"><i class="fas fa-eye text-orange font-18"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--end accordion-->
                                    @endif
                                @else
                                    <div class="accordion" id="accordionExample-faq">
                                        <div class="card shadow-none border mb-1">
                                            <div class="card-header" id="heading{{$val['id']}}">
                                                <h5 class="my-0">
                                                    <button class="btn btn-link collapsed ml-4 shadow-none" type="button" data-toggle="collapse" data-target="#collapse{{$val['id']}}" aria-expanded="false" aria-controls="collapse{{$val['id']}}">
                                                        {{$val['libelle']}} ({{$facturation->where('onglet_facturation_id', $val['id'])->count()}})                          
                                                    </button>
                                                    @can("validation_facture")
                                                        @if ($facturation->where('onglet_facturation_id', $val['id'])->count()!=0)
                                                            <input type="checkbox" onclick="caseCocherOutside('{{$val['id']}}')" class="outside" id="select_all_outside{{$val['id']}}">&nbsp;<span class="case{{$val['id']}}" style="font-size:12px">0 ligne(s) cochée(s)</span>
                                                        @endif
                                                    @endcan
                                                    (Total reversements: {{number_format($facturation->where('onglet_facturation_id', $val['id'])->sum('a_reverser'))}})
                                                </h5>
                                            </div>
                                            <div id="collapse{{$val['id']}}" class="collapse" aria-labelledby="heading{{$val['id']}}" data-parent="#accordionExample-faq">
                                                <div class="card-body" style="overflow-x: auto;">
                                                    <table class="table table-striped table-bordered nowrap">
                                                        <thead>
                                                            <tr>
                                                                @can("validation_facture")
                                                                    <th><input type="checkbox" name="select_all" onclick="caseCocherInside('{{$val['id']}}')" class="inside" id="select_all_inside{{$val['id']}}">&nbsp;Tous</th>
                                                                @endcan
                                                                <th>Num. AP</th>
                                                                <th>Nom partenaire</th>
                                                                <th>Sim head</th>
                                                                <th>Transaction amount</th>
                                                                <th>Commission</th>
                                                                <th>A reverser</th>
                                                                <th>Date transaction</th>
                                                                <th class="action">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($facturation as $facture)
                                                                @if ($facture->onglet_facturation_id==$val['id'])
                                                                    <tr>
                                                                        @can("validation_facture")
                                                                            <td>
                                                                                <input type="checkbox" name="selected_id[]" class="checkbox one selectCb{{$facture->onglet_facturation_id}}" onclick="caseCocherOne('{{$facture->onglet_facturation_id}}')" value="{{$facture->id}}">
                                                                            </td>
                                                                        @endcan
                                                                        <td>{{ $facture->num_ap }}</td>
                                                                        <td><pre class="format-pre">{{ $facture->nom_partenaire }}</pre></td>
                                                                        <td>{{ $facture->sim_head }}</td>
                                                                        <td>{{ number_format($facture->transaction_amount, 2, ","," ") }}</td>
                                                                        <td>{{ number_format($facture->commission, 2, ","," " )}}</td>
                                                                        <td>{{ number_format($facture->a_reverser, 2, ","," " ) }}</td>
                                                                        <td>{{  date('d/m/Y', strtotime($facture->date_transaction)) }}</td>
                                                                        <td align ="center">
                                                                            @can("validation_facture")
                                                                                <a href="#" data-toggle="modal" data-target="#ValiderUnique" onclick="ValidationUnique('{{$facture->id}}')" class="mr-1"><i class="fas fa-check-circle text-vert font-16"></i></a>
                                                                            @endcan
                                                                            @can("modification_facture")
                                                                            <a href="{{route('facturation_envalidation.edit', encrypt($facture->id))}}" class="mr-1"><i class="fas fa-edit text-info font-14"></i></a>
                                                                            @endcan
                                                                            @can("rejet_facture")
                                                                                <a href="#" data-toggle="modal" data-target="#RejetUnique" onclick="RejetUnique('{{$facture->id}}')" class="mr-1"><i class="fas fa-times-circle text-danger font-16"></i></a>
                                                                            @endcan
                                                                            <a href="#" data-toggle="modal" data-target="#Afficher" onclick="DetailsCatalogue('{{$facture->id}}')" class="mr-1"><i class="fas fa-eye text-orange font-18"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--end accordion-->
                                @endif
                            @endforeach
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div><!-- container -->
</div>
    <div class="modal fade bs-example-modal-lg" id="Afficher" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Détails catalogue</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <br>
                <span style="text-align: center;"><strong style="background-color:#FF7900">{{ $statut_validation[1]['libelle'] }}</strong></span>
                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="2" style="text-align: center;background-color: #f79240;color: white;">
                                    Nom du partenaire : <strong id="nom_partenaire"></strong>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Numéro AP</th>
                                <td id="num_ap"></td>
                            </tr>
                            <tr>
                                <th scope="row">Transaction Amount</th>
                                <td id="transaction_amount"></td>
                            </tr>
                            <tr>
                                <th scope="row">Commission</th>
                                <td id="commission"></td>
                            </tr>
                            <tr>
                                <th scope="row">A reverser</th>
                                <td id="a_reverser"></td>
                            </tr>
                            <tr>
                                <th scope="row">Sim head</th>
                                <td><ul id="sim_head" style="list-style-type:none;padding-left: 0px;margin-bottom:0px"></ul></td>
                            </tr>
                            <tr>
                                <th scope="row">Compte bancaire</th>
                                <td id="compte_bancaire"></td>
                            </tr>
                            <tr>
                                <th scope="row">Date facturation</th>
                                <td id="date_facturation"></td>
                            </tr>
                            <tr>
                                <th scope="row">Onglet facturation</th>
                                <td id="onglet_facturation"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="ValiderUnique" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="exampleModalLabel">Validation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-parsley" novalidate="" method="POST" action="{{ route('facturation_envalidation.store') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="idValidationUnique" name="selected_id[]" required>
                        <h5 align="center" style="color: black">Voulez-vous valider la facture ?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> &nbsp;Valider</button> &nbsp; &nbsp;
                        <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times"></i> &nbsp;Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="RejetUnique" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="exampleModalLabel">Rejet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-parsley" novalidate="" method="POST" action="/facturation_envalidation/rejet">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="idRejetUnique" name="selected_id[]" required>
                        <h5 align="center" style="color: black">Voulez-vous rejeter la facture ?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger"><i class="fas fa-check"></i> &nbsp;Rejeter</button> &nbsp; &nbsp;
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
    <script>
        function Suppression(id){
            $('#supprimer').attr("action","/catalogue/"+id)
        }
        function DetailsCatalogue(id){
            $.get('facturation_envalidation/'+id , function (valeur) {
                $('#nom_partenaire').html(valeur.data.nom_partenaire)
                $('#num_ap').html(valeur.data.num_ap)
                $('#compte_bancaire').html(valeur.data.compte_bancaire)
                $('#a_reverser').html(parseInt(valeur.data.a_reverser).toLocaleString("fr-FR", {minimumFractionDigits: 2, maximumFractionDigits: 2}))
                $('#transaction_amount').html(parseInt(valeur.data.transaction_amount).toLocaleString("fr-FR", {minimumFractionDigits: 2, maximumFractionDigits: 2}))
                $('#commission').html(parseInt(valeur.data.commission).toLocaleString("fr-FR", {minimumFractionDigits: 2, maximumFractionDigits: 2}))
                $('#sim_head').html(valeur.data.sim_head)
                $('#onglet_facturation').html(valeur.onglet_facturation)
                $('#date_facturation').html(valeur.data.date_transaction)
            })
        }
        function caseCocherAll(substr){
            var checked = $('#checkbox6b').is(":checked");
            if(checked){
                $('.one').prop('checked', true);
                $('.outside').prop('checked', true);
                $('.inside').prop('checked', true);
                $('#texte').text("Toutes les factures ("+$('.one').length+")");
                JSON.parse(substr).forEach(function(item) {
                    $('.case'+item).text(" "+$('.selectCb'+item).length+" ligne(s) cochée(s)");
                });
            }
            else{
                $('.one').prop('checked', false);
                $('.outside').prop('checked', false);
                $('.inside').prop('checked', false);
                $('#texte').text("Toutes les facture (0)");
                JSON.parse(substr).forEach(function(item) {
                    $('.case'+item).text(" 0 ligne(s) cochée(s)");
                });
            }
        }

        function caseCocherInside(id){
            var checked = $('#select_all_inside'+id).is(":checked");
            if(checked){
                $('.selectCb'+id).prop('checked', true);
                $('#select_all_outside'+id).prop('checked', true);
                $('#texte').text("Toutes les factures ("+$('.one').filter(':checked').length+")");
                $('.case'+id).text(" "+$('.selectCb'+id).length+" ligne(s) cochée(s)");
            }
            else{
                $('.selectCb'+id).prop('checked', false);
                $('#select_all_outside'+id).prop('checked', false);
                $('#texte').text("Toutes les factures ("+$('.one').filter(':checked').length+")");
                $('.case'+id).text(" 0 ligne(s) cochée(s)");
            }
        }

        function caseCocherOutside(id){
            var checked = $('#select_all_outside'+id).is(":checked");
            if(checked){
                $('.selectCb'+id).prop('checked', true);
                $('#select_all_inside'+id).prop('checked', true);
                $('#texte').text("Toutes les factures ("+$('.one').filter(':checked').length+")");
                $('.case'+id).text(" "+$('.selectCb'+id).length+" ligne(s) cochée(s)");
            }
            else{
                $('.selectCb'+id).prop('checked', false);
                $('#select_all_inside'+id).prop('checked', false);
                $('#texte').text("Toutes les factures ("+$('.one').filter(':checked').length+")");
                $('.case'+id).text(" 0 ligne(s) cochée(s)");
            }
        }

        function caseCocherOne(id){
            var checked = $('.selectCb'+id).is(":checked");
            if(checked){
                $('#texte').text("Toutes les factures ("+$('.one').filter(':checked').length+")");
                $('.case'+id).text(" "+$('.selectCb'+id).filter(':checked').length+" ligne(s) cochée(s)");
            }
            else{
                $('#texte').text("Toutes les factures ("+$('.one').filter(':checked').length+")");
                $('.case'+id).text(" "+$('.selectCb'+id).filter(':checked').length+" ligne(s) cochée(s)");
            }
        }

        function dateChange(){
            $date = $('#daterange').val().split('-');

            if ($date[0].trim()==$date[1].trim()){
                $('.page-title').text("Liste des factures du "+$date[0]);
            }
            else{
                $('.page-title').text("Liste des factures du "+$date[0]+" au "+$date[1]);
            }
        }

        $("#daterange").change(function(){
            dateChange()
        });

        function ValidationUnique(id){
            $('#idValidationUnique').val(id)
        }

        function RejetUnique(id){
            $('#idRejetUnique').val(id)
        }

        function ValidationMany(){
            $('#valide_rejet').attr("action","/facturation_envalidation")
            $('#motif_rejet').prop('required',false);
        }

        function RejetMany(){
            $('#valide_rejet').attr("action","/facturation_envalidation/rejet")
            $('#motif_rejet').prop('required',true);
        }

    </script>
@stop
