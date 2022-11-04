@extends('layouts.authLayout')

@section('content')
    <!-- Log In page -->
    <div class="container">
        <div class="row vh-100 ">
            <div class="col-12 align-self-center">
                <div class="auth-page">
                    <div class="card auth-card shadow-lg">
                        <div class="card-body">
                            <div class="px-3">
                                <div class="auth-logo-box">
                                    <a class="logo logo-admin"><img src="{{ URL::asset('assets/images/logo-sm.jpg') }}" height="55" alt="logo" class="auth-logo"></a>
                                </div>
                                <!--end auth-logo-box-->
                                <div class="text-center auth-logo-text">
                                    <h4 class="mt-0 mb-3 mt-5">Bill'OM</h4>
                                    <p class="text-muted mb-0">Automatisation facturation des partenaires</p>
                                </div>
                                <!--end auth-logo-text-->
                                <form class="form-horizontal auth-form my-4" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">Login</label>
                                        <div class="input-group mb-3">
                                            <span class="auth-form-icon">
                                                <i class="dripicons-user"></i>
                                            </span>
                                            <input id="email" type="text" placeholder="Login windows" class="form-control" name="login_windows" required autocomplete="email" autofocus>

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end form-group-->

                                    <div class="form-group">
                                        <label for="userpassword">Mot de passe</label>
                                        <div class="input-group mb-3">
                                            <span class="auth-form-icon">
                                                <i class="dripicons-lock"></i>
                                            </span>
                                            <input id="password" type="password" placeholder="Password" class="form-control" name="password" required>

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end form-group-->

                                    <div class="form-group row mt-1"></div>
                                    <!--end form-group-->
                                    <div class="form-group mb-0 row">
                                        <div class="col-12 mt-2">
                                            <button class="btn btn-gradient-primary btn-round btn-block waves-effect waves-light" type="submit">Se connecter <i class="fas fa-sign-in-alt ml-1"></i></button>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end form-group-->
                                </form>
                                <!--end form-->
                            </div>
                            <!--end /div-->
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end account-social-->
                </div>
                <!--end auth-page-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
<!--end container-->
<!-- End Log In page -->
@if (session()->has('message'))
        <script type="text/javascript">
            $(function() {
                setTimeout(function() {
                    $.bootstrapGrowl("{{session()->get('message')}}", {
                        type: 'danger',
                        position:"top",
                        align: 'center',
                        width:"auto"
                    });
                }, 2000);
            });
        </script>
    @endif
@endsection
