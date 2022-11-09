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
                    @slot('title') Liste des permissions @endslot
                 @endcomponent
            </div><!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title"></h4>
                        <table id="datatable-permission" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $value)
                                    <tr>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                        <p align="center">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> &nbsp;Ajouter</button>
                        </p>
                    </form>
                    </div>
                    <!-- end page title end breadcrumb -->
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div><!-- container -->
@stop

@section('footerScript')
    <script>

        $('#select_all').click(function(event) {  //on click
            var checked = this.checked;
            if(checked){
                $('.selectCb').prop('checked', true);
            }
            else{
                $('.selectCb').prop('checked', false);
            }
        });

    </script>
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
@stop
