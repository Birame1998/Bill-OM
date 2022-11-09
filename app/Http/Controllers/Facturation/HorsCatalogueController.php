<?php

namespace App\Http\Controllers\Facturation;

use App\Http\Controllers\Controller;
use App\Models\Facturation\HorsCatalogue;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class HorsCatalogueController extends Controller
{
    public function index()
    {
        $hors_catalogue = HorsCatalogue::get();
        return view('Facturation.Facturation.index_hors_catalogue',compact('hors_catalogue'));
    }

    public function store(Request $request)
    {
        $process = new Process(['py', resource_path('script\\').'hors_catalogue.py']);
        $process->run();
        $out= $process->getOutput(); 

        // dump($out);
        // $command = escapeshellcmd('C:\Users\tmp_gueye56762\Documents\OFMS_DIGITAL\DTI\xayma\resources\script\hors_catalogue.py');
        // $output = shell_exec($command);
        session()->flash("message_success","Tester");
        return redirect()->route('hors_catalogue.index');
    }

}
