<?php

namespace App\Http\Controllers;

use ZipArchive;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Classes\GestionFile;
use App\Models\Facturation\RecyclageUV;
use Illuminate\Http\Request;
use App\Models\SuiviReco\ErqAction;
use Illuminate\Support\Facades\File;
use Route;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;


class ExportFile extends Controller
{
    /********************************* START DOWNLOAD CONTROLE INTERNE ************************/
    public function download_ci(Request $request){
        try{
            $path = resource_path('data_controle_interne\\').$request->file;
            return response()->download($path);
        } catch (FileNotFoundException $e) {
            return redirect('/404');
        }
    }

    public function download_file_action(Request $request){
        try{
            $path = resource_path('c2c_ow/'.$request->file);
            return response()->download($path);
        } catch (FileNotFoundException $e) {
            session()->flash("message","Le fichier selectionné est introuvable.");
            $route=url()->previous();
            return redirect($route);
        }
    }

    public function download_zip_ci(Request $request){
        $delete = new GestionFile();
        $delete->deleteZip(resource_path('data_controle_interne\\'));
        $liste_fichier = json_decode($request->file);
        $zip = new ZipArchive();
        $mytime = Carbon::now()->format('Ymd-Hi');
        $filename = 'myZip'.$mytime.'.zip';
        $file= File::files(resource_path('data_controle_interne\\'));
        $path = resource_path('data_controle_interne\\').$filename;

        if($zip->open($path,ZipArchive::CREATE)===TRUE){
            foreach($file as $key=>$value){
                if (in_array(basename($value), $liste_fichier)) {
                    $zip->addFile($value,basename($value));
                }
            }
        }
        $zip->close();
        return response()->download($path);
    }

    public function download_zip_file_action(Request $request){
        $recyclage = RecyclageUV::where('id', $request->id)->first();
        $liste_fichier = Array();
        $liste_fichier = [$recyclage->c2c,$recyclage->ow];
        
        $delete = new GestionFile();
        $delete->deleteZip(resource_path('c2c_ow\\'));

        $zip = new ZipArchive();
        $filename = 'EXPORT_ZIP_C2C_OW'.$recyclage->date.'.zip';
        $file= File::files(resource_path('c2c_ow\\'));
        $path = resource_path('c2c_ow\\').$filename;

        if($zip->open($path,ZipArchive::CREATE)===TRUE){
            foreach($file as $key=>$value){
                if (in_array(basename($value), $liste_fichier)) {
                    $zip->addFile($value,basename($value));
                }
            }
        }
        $zip->close();
        return response()->download($path);
    }
    /********************************* END DOWNLOAD CONTROLE INTERNE ************************/




}
