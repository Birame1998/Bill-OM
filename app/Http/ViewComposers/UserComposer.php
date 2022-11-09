<?php
namespace App\Http\ViewComposers;

use App\User;
use Illuminate\View\View;
use App\Repositories\UserRepository;
use App\Models\GestionStructure\Structure;

class UserComposer {
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function compose(View $view)
    {
        $view->with('users', $this->userRepository->getAll());
        $view->with('users_responsable', $this->userRepository->getAllResponsable());
    }
}
