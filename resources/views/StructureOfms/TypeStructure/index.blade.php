@extends('layouts.backend')
@section('headerStyle')
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
                    @slot('title') Liste des types @endslot
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
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-animation="bounce" data-target="#ajout"><i class="fas fa-plus"></i> &nbsp;Ajouter</button>
                        </div>
                        <br>
                        <table id="datatable-type" class="table table-striped table-bordered w-100">
                            <thead>
                            <tr>
                                <th>Libellé</th>
                                <th>Description</th>
                                <th class="action">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($type_structure as $value)
                                    <tr>
                                        <td class="libelle">{{ $value->libelle }}</td>
                                        <td class="description">{{ $value->description }}</td>
                                        <td align ="center">
                                            <a class="mr-2 update" data-toggle="modal" data-animation="bounce" data-id="{{$value->id}}" data-target="#update"><i class="fas fa-edit text-info font-14"></i></a>
                                            <a href="#"><i class="fas fa-trash-alt text-danger font-14"></i></a>
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
    <div class="modal fade" tabindex="-1" id="ajout" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Création type structure</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-parsley" novalidate="" method="POST" action="{{ route('types_structure.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="validationCustom01">Nom du type </label>
                            <input type="text" class="form-control" name="libelle" placeholder="Direction" required="">
                        </div><!--end col-->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="description">
                        </div><!--end form-row-->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> &nbsp;Ajouter</button>
                            <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times"></i> &nbsp;Annuler</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Modification du type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-parsley" novalidate="" method="POST" action="{{ route('types_structure.update','type_id') }}">
                        @method('PATCH')
                        @csrf
                        <input type="hidden" class="id" name="id" required>
                        <div class="form-group">
                            <label for="validationCustom01">Libellé du type</label>
                            <input type="text" class="form-control libelle" name="libelle" required="">
                        </div><!--end form-row-->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control description" name="description">
                        </div><!--end form-row-->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i>&nbsp;Modifier</button>
                            <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times"></i> &nbsp;Annuler</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="Supprimer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="exampleModalLabel">Suppression</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="supprimer">
                    @method('DELETE')
                    @csrf
                    <div class="modal-body">
                        <h5 align="center" style="color: black">Voulez-vous supprimer le type ?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" style="color: white"><i class="fas fa-trash"></i> &nbsp;Supprimer</button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-times"></i> &nbsp;Annuler</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- update js --}}
    <script>
        $(document).on('click','a.update',function()
        {
            var _this = $(this).parents('tr');
            $('.libelle').val(_this.find('.libelle').text());
            $('.description').val(_this.find('.description').text());
            $('.id').val( $(this).data('id'))
        });
    </script>
@stop

@section('footerScript')
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
            $('#supprimer').attr("action","/types_structure/"+id)
        }
    </script>
@stop
