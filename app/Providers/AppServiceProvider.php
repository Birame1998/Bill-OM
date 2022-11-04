<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\RoleComposer;
use App\Http\ViewComposers\UserComposer;
use App\Http\ViewComposers\StructureComposer;
use App\Http\ViewComposers\FacturationComposer;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        $viewStructureCreate = 'StructureOfms.Structure.create';
        $viewStructureUpdate = 'StructureOfms.Structure.update';
        $viewUserIndex = 'Securite.users.index';
        $viewUserCreate = 'Securite.users.create';
        $viewUserUpdate = 'Securite.users.update';
        $viewRolesIndex = 'Securite.roles.index';
        $viewInterimIndex = 'Securite.Interim.index';
        $viewFactureValidationIndex = 'Facturation.Facturation.index_envalidation';
        $viewFactureValideIndex = 'Facturation.Facturation.index_valide';
        $viewFactureRejeteIndex = 'Facturation.Facturation.index_rejetee';
        $viewCatalogueIndex = 'Facturation.Catalogue.index';


        View::composers([
            UserComposer::class => [$viewStructureCreate, $viewStructureUpdate, $viewUserIndex,
                                    $viewInterimIndex],

            StructureComposer::class => [$viewStructureCreate, $viewUserUpdate, $viewUserCreate],
            FacturationComposer::class => [$viewFactureValidationIndex, $viewFactureValideIndex, $viewFactureRejeteIndex,$viewCatalogueIndex],
            RoleComposer::class => [$viewUserCreate, $viewUserUpdate, $viewRolesIndex]
        ]);
    }
}
