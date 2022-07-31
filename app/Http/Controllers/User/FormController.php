<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\FileStore;
use App\Models\Form;
use Illuminate\Support\Str;
use App\Http\Requests\FormBuildRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    use FileStore;

    public function create()
    {
        $title = "Build Form";
        return view('form.create', compact('title'));
    }

    public function store(FormBuildRequest $request)
    {
        $data = $request->only('title', 'status');
        $data['user_id'] = Auth::user()->id;
        $data['hash_code'] = Str::random(10);
        $data['schema_path'] = $this->upload($request->schema_path, 'file/json');
        $data['respose_csv_path'] = $this->fileCreate('file/csv');
        $form = Form::create($data);
        $this->setCsvColumn($form->schema_path, $form->respose_csv_path);
        $notify[] = ['success', 'Form has been created'];
        return back()->withNotify($notify);
    }


    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:forms,id',
            'status' => 'required|in:1,2',
        ]);
        $form = Form::where('user_id',auth()->user()->id)->where('id',$request->id)->firstOrFail();
        $form->update([
            'status' => $request->status
        ]);
        $notify[] = ['success', 'Form status has been updated'];
        return back()->withNotify($notify);
    }


    public function download($id)
    {
        $form = Form::where('user_id',auth()->user()->id)->where('id',$id)->firstOrFail();
        $path = public_path()."/file/csv/".$form->respose_csv_path;
        $title = Str::slug($form->title).'-'.$form->respose_csv_path;
        $mimetype = mime_content_type($path);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($path);
    }


    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:forms,id',
        ]);
        $form = Form::where('user_id',auth()->user()->id)->where('id',$request->id)->firstOrFail();
        $this->fileRemove(public_path()."/file/json/".$form->schema_path);
        $this->fileRemove(public_path()."/file/csv/".$form->respose_csv_path);
        $form->delete();
        $notify[] = ['success', 'Form has been deleted'];
        return back()->withNotify($notify);
    }
}
