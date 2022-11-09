<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login_windows' => 'required',
            'password' => 'required',
        ]);

        $credentials = ['login_windows' => $request->login_windows, 'password' => 'super', 'is_active' => 1];
        $compte = User::where("login_windows",$request->login_windows)->first();

        $login = $request->login_windows;
        $mdp = $request->password;
        $ldaprdn = $login . '@orange-sonatel.com';
        $ldappass = $mdp;

         $ldapconn = ldap_connect("orange-sonatel.com") or die("Could not connect to LDAP server.");

        try{
             if ($ldapconn) {
                // $ldapbind = @ldap_bind($ldapconn, $ldaprdn, $ldappass);
                 $ldapbind=true;
                $delai_tentative = Carbon::now()->diffInMinutes($compte->date_login);
                 if ($ldapbind and $compte->is_active==1) {
                    if ((Auth::attempt($credentials))) {
                        $compte->update([
                            'date_login' => null,
                            'tentative' => null
                        ]);
                        return redirect()->intended('facturation_envalidation');
                    }
                 }
                elseif($compte->is_active!=1){
                    session()->flash("message","Votre compte a été bloqué, veuillez contacter l'administreur.");
                    return redirect("login");
                }
                else{
                    if($compte->tentative == 5){
                        session()->flash("message","Votre compte a été bloqué après 5 tentatives de connexion échouées.");
                        return redirect("login");
                    }
                    else if($delai_tentative <= 10 && $compte->tentative < 5){
                        $compte->update([
                            'date_login' => Carbon::now(),
                            'tentative' => $compte->tentative+1
                        ]);
                        if($compte->tentative==5){
                            session()->flash("message","Votre compte a été bloqué après 5 tentatives de connexion échouées.");
                            return redirect("login");
                        }
                        else{
                            session()->flash("message","Email ou mot de passe incorrect. Il vous reste ".(5-$compte->tentative)." tentatives");
                            return redirect("login");
                        }
                    }
                    else{

                        $compte->update([
                            'date_login' => Carbon::now(),
                            'tentative' => null
                        ]);

                        session()->flash("message","Email ou mot de passe incorrect.");
                        return redirect("login");
                    }
                }
             }
        }catch (Exception $e) {
            session()->flash("message","Email ou mot de passe incorrect.");
            return redirect("login");
        }
    }
}
