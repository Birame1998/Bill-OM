<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\StructureRepository;
use App\Models\GestionStructure\Structure;

class StructureComposer {

    private $structureRepository;
    public function __construct(StructureRepository $structureRepository)
    {
        $this->structureRepository = $structureRepository;
    }

    public function compose(View $view)
    {
        $view->with('structures', $this->structureRepository->getAll());
    }

}
