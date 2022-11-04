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
                    @slot('title') Liste des structures @endslot
                @endcomponent
            </div><!--end col-->
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mt-0"></h4>
                        <div class="pull-right">
                            <a href="{{ route('structures.create') }}" class="btn btn-primary mb-2 mb-lg-3"><i class="fas fa-plus"></i> &nbsp;Ajouter</a>
                        </div>
                        <br>
                        <table id="datatable-structure" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Structure </th>
                                    <th>Responsable</th>
                                    <th>Description</th>
                                    <th class="action">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($structure as $value)
                                    <tr>
                                        <td>
                                            {{ $value->liste_structure }}
                                        </td>
                                        <td>{{ $value->type_structure->libelle}}</td>
                                        <td>
                                            @if ($value->directeur)
                                                {{ $value->directeur->prenom }} {{ $value->directeur->nom }}
                                            @endif
                                        </td>
                                        <td>{{ $value->description }}</td>
                                        <td align ="center">
                                            <a href="{{ route('structures.edit',encrypt($value->id)) }}" class="mr-2"><i class="fas fa-edit text-info font-14"></i></a>
                                            <a href="#" data-toggle="modal" data-target="#Supprimer" onclick="Suppression('{{$value->id}}')"><i class="fas fa-trash-alt text-danger font-14"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!-- container -->
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
                        <h5 align="center" style="color: black">Voulez-vous supprimer la structure ?</h5>
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
            $('#supprimer').attr("action","/structures/"+id)
        }
    </script>
@stop




