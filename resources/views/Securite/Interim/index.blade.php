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
@section('js_after')
    <script>
        $(document).ready(function() {
            $(function() {
                $('.custom-control-input').change(function() {
                    //alert('changed')
                    var status = $(this).prop('checked') == true ? 1 : 0;
                    var user_id = $(this).data('id');
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: '/user/update-status',
                        data: {
                            'status': status,
                            'user_id': user_id
                        },
                        success :function(response){
                            $(function() {
                                setTimeout(function() {
                                    $.bootstrapGrowl(response['message'], {
                                        type: response['color'],
                                        position:"top",
                                        align: 'center',
                                        width:"auto"
                                    });
                                }, 2000);
                            });
                        }
                    });
                })
            })
        });
    </script>
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                @component('common-components.breadcrumb')
                    @slot('title') Liste des utilisateurs @endslot
                @endcomponent
            </div><!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title"></h4>
                            <div class="pull-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-animation="bounce" data-target="#AjoutInterim"><i class="fas fa-plus"></i> &nbsp;Ajouter</button>
                            </div>
                        <br>
                        <table id="datatable-user" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Prénom & Nom</th>
                                    <th>Date début</th>
                                    <th>Date fin</th>
                                    <th>Rôle</th>
                                    <th>Structure</th>
                                    <th class="action">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($interim as $value)
                                    <tr>
                                        <td>{{ $value->prenom }} {{ $value->nom }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->login_windows }}</td>
                                        <td>{{ $value->roles[0]->description}}</td>
                                        <td>
                                            {{ $value->structure->libelle }}
                                        </td>

                                        <td align="center">
                                            <a class="mr-2 update" data-toggle="modal" data-animation="bounce" onclick="SelectInterim('{{$value->id}}')" data-target="#ModifierInterim"><i class="fas fa-edit text-info font-14"></i></a>
                                            <a href="#" data-toggle="modal" data-target="#Supprimer" onclick="Suppression('{{$value->id}}')"><i class="fas fa-power-off text-danger font-16"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div><!-- container -->

    <div class="modal fade" id="Supprimer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="exampleModalLabel">Arrêt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="supprimer">
                    @method('DELETE')
                    @csrf
                    <div class="modal-body">
                        <h5 align="center" style="color: black">Voulez-vous arrêter l'intérim ?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" style="color: white"><i class="fas fa-check"></i> &nbsp;Valider</button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times"></i> &nbsp;Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="AjoutInterim" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Ajout intérim</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-parsley" novalidate="" method="POST" action="{{ route('interim.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="validationCustom05">Agent</label>
                            <select class="form-control" style="width: 100%; height:36px;" name="users_id" required>
                                <option value="">Choisir un agent</option>
                                @forelse ($users_interim as $value)
                                    <option value="{{ $value->id }}">{{ $value->prenom }} {{ $value->nom }} - {{ $value->roles[0]->description}}</option>
                                    @empty
                                @endforelse
                            </select>
                        </div><!--end col-->
                        <div class="form-group">
                            <label for="validationCustom05">Rôle</label>
                            <select class="form-control" style="width: 100%; height:36px;" name="role_id" required>
                                <option value="">Choisir un role</option>
                                @forelse ($role as $value)
                                    <option value="{{ $value->id }}">{{ $value->description }}</option>
                                    @empty
                                @endforelse
                            </select>
                        </div><!--end col-->
                        <div class="form-row" style="margin-bottom: 25px;">
                            <div class="col-md-12">
                                <label class="my-3">Date de fin</label>
                                <input type="text" class="form-control" id="min-date" name="date_fin" required>
                            </div><!--end col-->
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;Enregistrer</button>
                            <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times"></i> &nbsp;Annuler</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="ModifierInterim" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Modification intérim</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-parsley" novalidate="" method="POST" action="{{ route('interim.update','id') }}">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label for="validationCustom05">Agent</label>
                            <select class="form-control" style="width: 100%; height:36px;" name="users_id" id="agent" required>
                                <option value="">Choisir un agent</option>
                                @forelse ($interim as $value)
                                    <option value="{{ $value->id }}">{{ $value->prenom }} {{ $value->nom }} - {{ $value->roles[0]->description}}</option>
                                    @empty
                                @endforelse
                            </select>
                        </div><!--end col-->
                        <div class="form-group">
                            <label for="validationCustom05">Rôle</label>
                            <select class="form-control" style="width: 100%; height:36px;" id="role" name="role_id" required>
                                <option value="">Choisir un role</option>
                                @forelse ($role as $value)
                                    <option value="{{ $value->id }}">{{ $value->description }}</option>
                                    @empty
                                @endforelse
                            </select>
                        </div><!--end col-->
                        <div class="form-row" style="margin-bottom: 25px;">
                            <div class="col-md-12">
                                <label class="my-3">Date de fin</label>
                                <input type="text" class="form-control" id="min-date1" name="date_fin" required>
                            </div><!--end col-->
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;Enregistrer</button>
                            <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times"></i> &nbsp;Annuler</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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

    <!-- Required datatable js -->
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
        function Suppression(id){
            $('#supprimer').attr("action","/interim/"+id)
        }
        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [day,month,year].join('/');
        }
        function SelectInterim(id){
            $.get('interim/' + id , function (valeur) {
                $("#agent").val(valeur.data.id).change();
                $("#role").val(valeur.data.roles[0].id).change();
                $("#min-date1").val(formatDate(valeur.data.date_fin_interim));
            })
        }
    </script>
    <script src="{{ URL::asset('/assets/js/jquery.core.js')}}"></script>
@stop
