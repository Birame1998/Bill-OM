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
                    @slot('title') Liste hors catalogue @endslot
                @endcomponent
            </div><!--end col-->
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title"></h4>
                        @can("rejouer_facture_hors_catalogue")
                            <form action="{{ route('hors_catalogue.store') }}" method="post">
                                @csrf
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary mb-2 mb-lg-3"><i class="fas fa-undo-alt"></i> &nbsp;Rejouer</button>
                                </div>
                            </form>
                        @endcan

                        <br>
                        <table id="datatable-type" class="table table-striped table-bordered w-100">
                            <thead>
                            <tr>
                                <th>Parent msisdn</th>
                                <th>Transaction amount</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($hors_catalogue as $value)
                                    <tr>
                                        <td>{{ $value->parent_user_msisdn }}</td>
                                        <td>{{ $value->transaction_amount }}</td>
                                        <td>{{ $value->date_transaction }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div><!-- container -->

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
@stop
