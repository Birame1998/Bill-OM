<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\RoleRepository;

class RoleComposer {
    private $roleRepository;
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function compose(View $view)
    {
        $view->with('roles_no_super', $this->roleRepository->getAllNoSuper());
        $view->with('roles', $this->roleRepository->getAllWithepermissions());

    }
}
