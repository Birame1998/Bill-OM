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
                        <form class="form-parsley" novalidate="" method="POST" action="/facturation_valide/search">
                            @csrf
                            @include("Facturation.Facturation.recherche")
                        </form>
                        <br>
                        <div class="row justify-content-center">
                            <span style="background-color: #50BE87"><strong>{{ $statut_validation[2]['libelle'] }}</strong></span>
                        </div>
                        {{-- <form action="{{ route('facturation_envalidation.store') }}" method="POST"> --}}
                            <form action="/facturation_valide/export_pdf" method="POST">
                            @csrf
                            @can('export_facture')
                                <h4 class="mt-0 header-title"></h4>
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-dark mb-2 mb-lg-3"><i class="fas fa-print"></i>&nbsp;Export PDF</button>
                                </div>
                            @endcan
                            
                            <div class="checkbox checkbox-pink">
                                <input id="checkbox6b" type="checkbox" name="select_all" onclick="caseCocherAll('{{json_encode(array_column($onglet_facturation, 'id'))}}')" >
                                <label for="checkbox6b" id="texte">
                                    &nbsp;Toutes les factures (0)
                                </label>
                            </div>

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
                                                        <input type="checkbox" onclick="caseCocherOutside('{{$val['id']}}')" class="outside" id="select_all_outside{{$val['id']}}">&nbsp;<span class="case{{$val['id']}}" style="font-size:12px">0 ligne(s) cochée(s)</span>
                                                        (Total transaction: {{number_format($facturation->where('onglet_facturation_id', $val['id'])->sum('transaction_amount'))}})
                                                    </h5>
                                                </div>
                                                <div id="collapse{{$val['id']}}" class="collapse" aria-labelledby="heading{{$val['id']}}" data-parent="#accordionExample-faq">
                                                    <div class="card-body" style="overflow-x: auto;">
                                                        <table class="table table-striped table-bordered nowrap">
                                                            <thead>
                                                                <tr>
                                                                    <th><input type="checkbox" name="select_all" onclick="caseCocherInside('{{$val['id']}}')" class="inside" id="select_all_inside{{$val['id']}}">&nbsp;Tous</th>
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
                                                                            <td>
                                                                                <input type="checkbox" name="selected_id[]" class="checkbox one selectCb{{$facture->onglet_facturation_id}}" onclick="caseCocherOne('{{$facture->onglet_facturation_id}}')" value="{{$facture->id}}">
                                                                            </td>
                                                                            <td>{{ $facture->num_ap }}</td>
                                                                            <td><pre class="format-pre">{{ $facture->nom_partenaire }}</pre></td>
                                                                            <td>{{ $facture->sim_head }}</td>
                                                                            <td>{{ number_format($facture->transaction_amount, 2, ","," ") }}</td>
                                                                            <td>{{ number_format($facture->commission, 2, ","," " )}}</td>
                                                                            <td>{{ number_format($facture->a_reverser, 2, ","," " ) }}</td>
                                                                            <td>{{ date('d/m/Y', strtotime($facture->date_transaction)) }}</td>
                                                                            {{-- <td>
                                                                                @if ($facture->statut)
                                                                                    <span class="badge badge badge-{{ $statut_validation[$facture->statut]['couleur'] }}">{{ $statut_validation[$facture->statut]['libelle'] }}</span>
                                                                                @endif
                                                                            </td> --}}
                                                                            <td align ="center">
                                                                                <a href="#" data-toggle="modal" data-target="#Afficher" onclick="DetailsCatalogue('{{$facture->id}}')" class="mr-1"><i class="fas fa-eye text-orange font-18"></i></a>
                                                                                {{-- <a href="#" class="mr-1"><i class="fas fa-file-pdf text-black font-16"></i></a> --}}
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
                                                    @if ($facturation->where('onglet_facturation_id', $val['id'])->count()!=0)
                                                        <input type="checkbox" onclick="caseCocherOutside('{{$val['id']}}')" class="outside" id="select_all_outside{{$val['id']}}">&nbsp;<span class="case{{$val['id']}}" style="font-size:12px">0 ligne(s) cochée(s)</span>
                                                    @endif
                                                    (Total transaction: {{number_format($facturation->where('onglet_facturation_id', $val['id'])->sum('transaction_amount'))}})
                                                </h5>
                                            </div>
                                            <div id="collapse{{$val['id']}}" class="collapse" aria-labelledby="heading{{$val['id']}}" data-parent="#accordionExample-faq">
                                                <div class="card-body" style="overflow-x: auto;">
                                                    <table class="table table-striped table-bordered nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" name="select_all" onclick="caseCocherInside('{{$val['id']}}')" class="inside" id="select_all_inside{{$val['id']}}">&nbsp;Tous</th>
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
                                                                        <td>
                                                                            <input type="checkbox" name="selected_id[]" class="checkbox one selectCb{{$facture->onglet_facturation_id}}" onclick="caseCocherOne('{{$facture->onglet_facturation_id}}')" value="{{$facture->id}}">
                                                                        </td>
                                                                        <td>{{ $facture->num_ap }}</td>
                                                                        <td><pre class="format-pre">{{ $facture->nom_partenaire }}</pre></td>
                                                                        <td>{{ $facture->sim_head }}</td>
                                                                        <td>{{ number_format($facture->transaction_amount, 2, ","," ") }}</td>
                                                                        <td>{{ number_format($facture->commission, 2, ","," " )}}</td>
                                                                        <td>{{ number_format($facture->a_reverser, 2, ","," " ) }}</td>
                                                                        <td>{{ date('d/m/Y', strtotime($facture->date_transaction)) }}</td>
                                                                        <td align ="center">
                                                                            <a href="#" data-toggle="modal" data-target="#Afficher" onclick="DetailsCatalogue('{{$facture->id}}')" class="mr-1"><i class="fas fa-eye text-orange font-18"></i></a>
                                                                            {{-- <a href="#" class="mr-1"><i class="fas fa-file-pdf text-black font-16"></i></a> --}}
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
                <span style="text-align: center;"><strong style="background-color:#50BE87">{{ $statut_validation[2]['libelle'] }}</strong></span>
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
                            <tr>
                                <th scope="row">Validée par</th>
                                <td id="valider_par"></td>
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
    <script>
        function Suppression(id){
            $('#supprimer').attr("action","/catalogue/"+id)
        }
        function DetailsCatalogue(id){
            $.get('facturation_valide/'+id , function (valeur) {
                $('#nom_partenaire').html(valeur.data.nom_partenaire)
                $('#num_ap').html(valeur.data.num_ap)
                $('#compte_bancaire').html(valeur.data.compte_bancaire)
                $('#a_reverser').html(parseInt(valeur.data.a_reverser).toLocaleString("fr-FR", {minimumFractionDigits: 2, maximumFractionDigits: 2}))
                $('#transaction_amount').html(parseInt(valeur.data.transaction_amount).toLocaleString("fr-FR", {minimumFractionDigits: 2, maximumFractionDigits: 2}))
                $('#commission').html(parseInt(valeur.data.commission).toLocaleString("fr-FR", {minimumFractionDigits: 2, maximumFractionDigits: 2}))
                $('#sim_head').html(valeur.data.sim_head)
                $('#onglet_facturation').html(valeur.onglet_facturation)
                $('#date_facturation').html(valeur.data.date_transaction)
                $('#valider_par').html(valeur.data.valider_par)

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

    </script>
@stop
