<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\FacturationRepository;

class FacturationComposer {

    private $facturationRepository;
    public function __construct(FacturationRepository $facturationRepository)
    {
        $this->facturationRepository = $facturationRepository;
    }

    public function compose(View $view)
    {
        $view->with('partenaires', $this->facturationRepository->getAll());
    }

}
