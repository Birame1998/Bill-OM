<!-- Left Sidenav -->
<div class="left-sidenav">
    <!-- LOGO -->
    <div class="topbar-left">
        <a class="logo">
            <span>
                <img src="{{ URL::asset('assets/images/orange-money.png')}}" alt="logo-small" class="logo-sm">
            </span>
        </a>
    </div>
    <!--end logo-->
    <div class="leftbar-profile p-3 w-100">
        <div class="media position-relative">
            <div class="media-body align-self-center text-truncate ml-3">
                <h6 class="mt-0 mb-1 font-weight-semibold">Bill'OM</h6>
            </div><!--end media-body--><!--end media-body-->
        </div>
    </div>

    <ul class="metismenu left-sidenav-menu slimscroll">

    <li class="menu-label"></li>
        {{-- <li class="leftbar-menu-item {{ Route::is('dashboard_suivi_reco.*')  ? 'active mm-active' : '' }}">
            <a href="javascript: void(0);" class="menu-link">
                <i data-feather="airplay" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                <span>Dashbord</span>
                <span class="menu-arrow">
                    <i class="mdi mdi-chevron-right"></i>
                </span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                @can('dashboard_suivi_reco')
                    <li class="{{ Route::is('dashboard_suivi_reco.index')  ? 'nav-item active' : '' }}">
                        <a class="{{ Route::is('dashboard_suivi_reco.index')  ? 'nav-link active' : '' }}"
                            href="{{ route('dashboard_suivi_reco.index') }}">
                            <i class="mdi mdi-chart-donut"></i><span>TB Suivi Reco</span>
                        </a>
                    </li>
                @endcan
                @can('dashboard_fiche_controle')
                    <li class="{{ Route::is('dashboard.index')  ? 'nav-item active' : '' }}">
                        <a class="{{ Route::is('dashboard.index')  ? 'nav-link active' : '' }}"
                            href="{{ route('dashboard.index') }}">
                            <i class="mdi mdi-chart-bar"></i><span>TB contrôle</span>
                        </a>
                    </li>
                @endcan
                {{-- @can('dashboard_taches')
                <li class="{{ Route::is('accueil.index')  ? 'nav-item active' : '' }}">
                    <a class="{{ Route::is('accueil.index')  ? 'nav-link active' : '' }}"
                        href="{{ route('accueil.index') }}">
                        <i class="mdi mdi-book-open-page-variant"></i><span>Tâches</span>
                    </a>
                </li>
                @endcan

            </ul>
        </li> --}}

        {{-- @can('tbdrcc')
        <li class="menu-label">Tableau de Bord DRCC</li>
        <li class="leftbar-menu-item {{ Route::is('tbdrcc*') ? 'active mm-active' : '' }}">
            <a href="javascript: void(0);" class="menu-link">
                <i data-feather="airplay" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                <span>Dashbord DRCC</span>
                <span class="menu-arrow">
                    <i class="mdi mdi-chevron-right"></i>
                </span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                <li class="{{ Route::is('tbdrcc.*') || Route::is('processus.*') || Route::is('periode_indicateurs.*')  ? 'nav-item active' : '' }}">
                    <a class="{{ Route::is('tbdrcc')  ? 'nav-link active' : '' }}"
                        href="{{ route('tbdrcc.index') }}">
                        <i class="mdi mdi-chart-bar"></i><span>TB DRCC</span>
                    </a>
                </li>
                <li class="{{ Route::is('periode_indicateurs.*')  ? 'nav-item active' : '' }}">
                    <a class="{{ Route::is('periode_indicateurs.*')  ? 'nav-link active' : '' }}"
                        href=" {{ route('periode_indicateurs.index') }} ">
                        <i class="mdi mdi-account-convert"></i><span>Periodes indicateur</span>
                    </a>
                </li>
            </ul>
        </li>
        @endcan --}}



            {{-- <li class="menu-label">Structures</li>
            <li class="leftbar-menu-item {{ Route::is('structures.*') ? 'active mm-active' : '' }}">
                <a href="javascript: void(0);" class="menu-link">
                    <i data-feather="home" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                    <span>Gestion structures</span>
                    <span class="menu-arrow">
                        <i class="mdi mdi-chevron-right"></i>
                    </span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item {{ Route::is('structures.*')  ? 'nav-item active' : '' }}">
                        <a class="{{ Route::is('structures.*')  ? 'nav-link active' : '' }}"
                            href=" {{ route('structures.index') }} ">
                            <i class="mdi mdi-alpha-s-circle"></i><span>Structures</span>
                        </a>
                    </li>
                </ul>
            </li> --}}
            @can("gestion_facture")
                <li class="menu-label">Facturation</li>
                <li class="leftbar-menu-item active mm-active'">
                    <a href="javascript: void(0);" class="menu-link">
                        <i data-feather="file-text" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                        <span>Facturation</span>
                        <span class="menu-arrow">
                            <i class="mdi mdi-chevron-right"></i>
                        </span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="true">
                        <li class="nav-item active mm-active">
                            <a href="javascript: void(0);" class="active"><i class="mdi mdi-cash-multiple"></i>Factures<span class="menu-arrow left-has-menu"><i class="mdi mdi-chevron-right"></i></span></a>
                            <ul class="nav-second-level">
                                @can("affichage_facture_envalidation")
                                    <li><a class="{{ Route::is('facturation_envalidation.index') || Route::is('facturation_envalidation.search') ? 'nav-link active' : '' }}" href="{{ route('facturation_envalidation.index') }}"><i class="mdi mdi-progress-check"></i>En validation <span style="color: black">({{$nbre_facture_envalidation}})</span></a></li>
                                @endcan
                                @can("affichage_facture_valide")
                                    <li><a class="{{ Route::is('facturation_valide.index') || Route::is('facturation_valide.search') ? 'nav-link active' : '' }}" href="{{ route('facturation_valide.index') }}"><i class="mdi mdi-bookmark-check"></i>Validées <span style="color: black">({{$nbre_facture_valide}})</span></a></li>
                                @endcan
                                @can("affichage_facture_rejete")
                                    <li><a class="{{ Route::is('facturation_rejetee.index') ? 'nav-link active' : ''}}" href="{{ route('facturation_rejetee.index') }}"><i class="mdi mdi-bookmark-remove"></i>Rejetées <span style="color: black">({{$nbre_facture_rejete}})</span></a></li>
                                @endcan
                                @can("affichage_facture_hors_catalogue")
                                    <li><a href="{{ route('hors_catalogue.index') }}"><i class="mdi mdi-bookmark-off"></i>Hors catalogues  <span style="color: black">({{$nbre_hors_catalogue}})</span></a></li>
                                @endcan
                            </ul>
                        </li>
                    </ul>
                    @can("affichage_recyclage_uv")
                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="nav-item {{ Route::is('recyclage_uv.*')  ? 'nav-item active' : '' }}">
                                <a class="{{ Route::is('recyclage_uv.*')  ? 'nav-link active' : '' }}"
                                    href="{{ route('recyclage_uv.index') }}">
                                    <i class="mdi mdi-recycle"></i><span>Recyclage UV</span>
                                </a>
                            </li>
                        </ul>
                    @endcan
                    @can("affichage_catalogue")
                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="nav-item {{ Route::is('catalogue.*')  ? 'nav-item active' : '' }}">
                                <a class="{{ Route::is('catalogue.*')  ? 'nav-link active' : '' }}"
                                    href=" {{ route('catalogue.index') }} ">
                                    <i class="mdi mdi-folder-text"></i><span>Catalogues</span>
                                </a>
                            </li>
                        </ul>
                    @endcan
                </li>
            @endcan
            @can("gestion_acces")
                <li class="menu-label">Gestion des utilisateurs</li>
                <li class="leftbar-menu-item {{ Route::is('roles.*') || Route::is('users.*') || Route::is('interim.*')  ? 'active mm-active' : '' }}">
                    <a href="javascript: void(0);" class="menu-link">
                        <i data-feather="lock" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                        <span>Gestion accès</span>
                        <span class="menu-arrow">
                            <i class="mdi mdi-chevron-right"></i>
                        </span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        @can("affichage_utilisateur")
                            <li class="{{ Route::is('users.*')  ? 'nav-item active' : '' }}">
                                <a class="{{ Route::is('users.*')  ? 'nav-link active' : '' }}"
                                    href="{{ route('users.index') }}">
                                    <i class="mdi mdi-account-group"></i><span>Utilisateurs</span>
                                </a>
                            </li>
                        @endcan
                        @can("affichage_interim")
                            <li class="{{ Route::is('interim.*')  ? 'nav-item active' : '' }}">
                                <a class="{{ Route::is('interim.*')  ? 'nav-link active' : '' }}"
                                    href="{{ route('interim.index') }}">
                                    <i class="mdi mdi-account-switch"></i><span>Intérims</span>
                                </a>
                            </li>
                        @endcan
                        @can("affichage_role")
                            <li class="{{ Route::is('roles.*')  ? 'nav-item active' : '' }}">
                                <a class="{{ Route::is('roles.*')  ? 'nav-link active' : '' }}"
                                    href=" {{ route('roles.index') }} ">
                                    <i class="mdi mdi-account-convert"></i><span>Rôles</span>
                                </a>
                            </li>
                        @endcan
                        @can("affichage_permission")
                            <li class="nav-item">
                                <a class="{{ Route::is('permissions.*')  ? 'nav-link active' : '' }}"
                                    href=" {{ route('permissions.index') }} ">
                                    <i class="mdi mdi-account-key"></i><span>Permissions</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can("affichage_tracking")
                <li class="menu-label">Sécurité</li>
                <li class="leftbar-menu-item {{ Route::is('trackings.*') || Route::is('trackings_motif.*')  ? 'active mm-active' : '' }}">
                    <a href="javascript: void(0);" class="menu-link">
                        <i data-feather="zoom-in" class="align-self-center vertical-menu-icon icon-dual-vertical"></i>
                        <span>Trackings</span>
                        <span class="menu-arrow">
                            <i class="mdi mdi-chevron-right"></i>
                        </span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li class="nav-item {{ Route::is('trackings.*') ? 'nav-item active' : '' }}">
                            <a class="{{ Route::is('trackings.*') ? 'nav-link active' : '' }}"
                                href=" {{ route('trackings.index') }} ">
                                <i class="mdi mdi-alpha-s-circle"></i><span>Système</span>
                            </a>
                        </li>
                        {{-- <li class="nav-item {{ Route::is('trackings_motif.*') ? 'nav-item active' : '' }}">
                            <a class="{{ Route::is('trackings_motif.*') ? 'nav-link active' : '' }}"
                                href=" {{ route('trackings_motif.index') }} ">
                                <i class="mdi mdi-alpha-d-circle"></i><span>Demande motif</span>
                            </a>
                        </li> --}}
                    </ul>
                </li>
            @endcan
        </ul>
    </div>
<!-- end left-sidenav-->






