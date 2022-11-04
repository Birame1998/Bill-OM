<?php
namespace App\Classes;


use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GestionFile
{
    function csvToArrayStructure($filename = '', $delimiter = ';')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;
        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {

            $header = null;
            $data = array();
            while (($row = fgetcsv($handle, 1000,";")) !== false)
            {
                $row = array_map("utf8_encode", $row); //added

                if($row[1]=='') {
                    $row[1] = null;
                }
                if (!$header){
                    $header = $row;
                }
                else{
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
            return $data ;
        }
    }
    public function deleteZip($path){
        $files = File::allFiles($path);
        foreach($files as $media)
        {
            if(Str::contains($media, 'EXPORT_ZIP')){
                File::delete($media);
            }
        }
    }
}
