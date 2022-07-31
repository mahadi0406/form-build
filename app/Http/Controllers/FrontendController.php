<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use App\Http\Traits\FileStore;

class FrontendController extends Controller
{
    use FileStore;
    public function index()
    {
        $title = "Home";
        return view('welcome', compact('title'));
    }

    public function link($hash)
    {
        $title = "Form";
        $form = Form::where('hash_code', $hash)->active()->first();
        abort_if(!$form, 403, "Form Expired");
        $elements = $this->jsonSchemaPath($form->schema_path);
        return view('form', compact('form', 'title', 'elements'));
    }

    public function store(Request $request, $id)
    {
        $form = Form::where('id',$id)->active()->first();
        abort_if(!$form, 403, "Form Expired");
        $data = $this->jsonSchemaPath($form->schema_path);
        $validateData = [];
        foreach($data->form as $key => $value){
            if(in_array($value->type, $this->inputType())){
                $validateData[$value->name] = $value->rules;
            }
        }
        $request->validate($validateData);
        $this->storeCsvData($form->respose_csv_path);
        $notify[] = ['success', 'Submitted Data'];
        return back()->withNotify($notify); 
    }



}
