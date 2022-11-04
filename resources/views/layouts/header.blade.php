<!-- Top Bar Start -->
<div class="topbar">
    <!-- Navbar -->
    <nav class="navbar-custom">
        <ul class="list-unstyled topbar-nav float-right mb-0">
            <li class="dropdown notification-list">
                {{-- <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <i class="ti-bell noti-icon"></i>
                    @if (1==2)
                        <span class="badge badge-danger badge-pill noti-icon-badge">2</span>
                    @endif
                </a> --}}

                <div class="dropdown-menu dropdown-menu-right dropdown-lg pt-0">

                    <h6 class="dropdown-item-text font-15 m-0 py-3 bg-primary text-white d-flex justify-content-between align-items-center">
                        Notifications <span class="badge badge-light badge-pill">2</span>
                    </h6>

                    <div class="slimscroll notification-list3" >

                    </div>
                </div>
            </li>
            <li class="dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <img src="{{ URL::asset('assets/images/account.png')}}" alt="profile-user" class="rounded-circle"/>
                    <span class="ml-1 nav-user-name hidden-sm"> {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                        <i class="mdi mdi-chevron-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="/logout"><i class="dripicons-exit text-muted mr-2"></i> Se déconnecter</a>
                </div>
            </li>
            {{-- <li class="dropdown notification-list">
                <a class="nav-link" data-toggle="modal" href="#" data-animation="fade" data-target=".modal-rightbar" style="padding-left: 0px;">
                    <i class="ti-bell noti-icon"></i>
                     <span class="badge badge-danger badge-pill noti-icon-badge">{{count(json_decode($notification))}}</span> 
                </a>
            </li> --}}
        </ul><!--end topbar-nav-->

        <ul class="list-unstyled topbar-nav mb-0">
            <li>
                <a href="/crm/crm-index">
                    <span class="responsive-logo">
                        <img src="{{ URL::asset('assets/images/logo-sm.jpg')}}" alt="logo-small" class="logo-sm align-self-center" height="34">
                    </span>
                </a>
            </li>
            <li>
                <button class="button-menu-mobile nav-link">
                    <i data-feather="menu" class="align-self-center"></i>
                </button>
            </li>
        </ul>
    </nav>
    <!-- end navbar-->
</div>

<!-- Top Bar End -->
<div class="modal modal-rightbar fade" tabindex="-1" role="dialog" aria-labelledby="MetricaRightbar" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#FF7900 ">
                <h5 class="modal-title mt-0" id="MetricaRightbar" style="color: white">Notification</h5>
                <button type="button" class="btn btn-sm btn-soft-dark btn-circle btn-dark" data-dismiss="modal" aria-hidden="true"><i class="mdi mdi-close"></i></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills nav-justified mt-2 mb-4" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" data-toggle="tab" href="#ActivityTab" role="tab">Non Chargées</a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-toggle="tab" href="#SettingsTab" role="tab">Non Validées</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active " id="ActivityTab" role="tabpanel">
                        <div class="slimscroll scroll-rightbar">
                            <div class="activity">
                                {{-- @foreach (json_decode($notification) as $value)
                                    @if ($value->type=="charger")
                                        <div class="activity-info">
                                            <div class="icon-info-activity">
                                                <i class="mdi mdi-alert bg-soft-pink"></i>
                                            </div>
                                            <div class="activity-info-text mb-2">
                                                <div class="mb-1">
                                                    Données du <a href="#" class="m-0 w-75">{{$value->date}}</a>
                                                    <small class="text-muted d-block mb-1">Pas encore chargées</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach --}}
                            </div><!--end activity-->
                        </div><!--end activity-scroll-->
                    </div><!--end tab-pane-->
                    <div class="tab-pane" id="SettingsTab" role="tabpanel">
                        <div class="slimscroll scroll-rightbar">
                            <div class="activity">
                                {{-- @foreach (json_decode($notification) as $value)
                                    @if ($value->type=="valider")
                                        <div class="activity-info">
                                            <div class="icon-info-activity">
                                                <i class="mdi mdi-alert-decagram bg-soft-warning"></i>
                                            </div>
                                            <div class="activity-info-text mb-2">
                                                Données du <a href="#" class="m-0 w-75">{{$value->date}}</a>
                                                <small class="text-muted d-block mb-1">Pas encore validées</small>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach --}}
                            </div><!--end activity-->
                        </div><!--end activity-scroll-->
                    </div><!--end tab-pane-->
                </div> <!--end tab-content-->
            </div><!--end modal-body-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
