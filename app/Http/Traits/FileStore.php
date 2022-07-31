<?php 
namespace App\Http\Traits;
use File;

trait FileStore
{
    /**
     * @param  $file
     * @param  $path
     * @param  string|null  ...$old
     */
	public function upload($file, $path, $old = null){
	   	if(!file_exists($path)){
			mkdir($path, 0755, true);
		}
	    if(!$path) throw new Exception('File could not been created.');
	    if($old){
	    	self::fileRemove($path . '/' . $old);
	    }
	    $filename = uniqid().'.'.$file->getClientOriginalExtension();
	    $file->move($path,$filename);
	    return $filename;
	}

	/**
     * @param  $request
     * @param  $path
     * @param  string|null  ...$old
     */
    public function fileRemove($path)
    {
        return file_exists($path) && is_file($path) ? @unlink($path) : false;
    }

    /**
     * @param $path
     */
    public function fileCreate($path)
    {
    	if(!file_exists($path)){
			mkdir($path, 0755, true);
		}
		$filename = uniqid().'.csv';
        $csv = $path.'/'.$filename;
        $handle = fopen($csv, "w");
        fclose($handle);
        return $filename;
    }

    /**
     * @param $schemaPath
     * @param $csvPath
     */
    public function setCsvColumn($schemaPath, $csvPath):void
    {
        $data = self::jsonSchemaPath($schemaPath);
        $columns = array();
        foreach($data->form as $key => $value){
        	if(in_array($value->type, self::inputType())){
            	array_push($columns, $value->name);
        	}
        }
        $csvpath = public_path()."/file/csv/".$csvPath;
        $csvData = array();
        if (($handle = fopen($csvpath, "r")) !== FALSE) {
            $csvData[] = $columns;
            fclose($handle);
        }
        $handle = fopen($csvpath, 'w');
        foreach($csvData as $line){
           fputcsv($handle,$line);
        }
        fclose($handle);
    }

    /**
     * @param $csvPath
     */
    public function storeCsvData($csvPath):void
    {
        $path =  public_path()."/file/csv/".$csvPath;
        $list = array();
        if (($handle = fopen($path, "r")) !== FALSE) {
            while(($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                array_push($list, $data);
            }
            fclose($handle);
        }
        array_push($list,request()->except('_token'));
        $file=fopen($path, "w");
        foreach($list as $value){
            fputcsv($file, $value);
        }
        fclose($file); 
    }

    public function inputType()
    {
        return array('text', 'select', 'checkbox', 'radio', 'textarea');
    }

     /**
     * @param $schemaPath
     */
    public function jsonSchemaPath($schemaPath)
    {
        return json_decode(File::get(public_path()."/file/json/".$schemaPath));
    }
}