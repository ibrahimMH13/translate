<?php

namespace Ibrhaim13\Translate\Http\Controllers;

use Ibrhaim13\Translate\Http\Requests\UpdateTranslateRequest;
use Ibrhaim13\Translate\Localization;
use Ibrhaim13\Translate\Models\Translate;
use Illuminate\Http\RedirectResponse;

class TranslateController extends Controller
{

    public function index()
    {
       return view('translate::translation.index')->with([
           'translates'=>Translate::paginate(20)
       ]);
    }

    public function edit(Translate $translate)
    {
        return view('translate13::translation.edit')->with(['translate'=>$translate]);
    }

    public function update(UpdateTranslateRequest $request, Translate $translate)
    {
        $values = $request->get('value');
        if ($translate && $translate->id && $values && is_array($values)) {
            foreach ($values as $langCode => $value) {
                Localization::addKeyToTranslation($translate->key, $value, $langCode);
            }
        }
        $request->session()->flash('msg', ['success' => 'Updated was successful!']);
        return redirect()->route('translation.index');

    }

    public function destroy(Translate $translate)
    {
        $translate->delete();
        return redirect()->back();
    }

    public function generate(): RedirectResponse
    {
            Localization::exportTranslations();
            request()->session()->flash('msg',['success'=>'Generate  Translation File was successful!']);
            return redirect()->back();
    }

}
