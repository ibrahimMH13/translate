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
       return view('translate::index')->with([
           'translates'=>Translate::paginate(20)
       ]);
    }

    public function edit(Translate $translate)
    {
        list($locales, $keyNamespace, $keyGroup, $keyItem) = $translate->getTranslateParams();
        return view('translate::edit')->with([
            'translate'=>$translate,
            'locales' => $locales,
            'keyNamespace' => $keyNamespace,
            'keyGroup' => $keyGroup,
            'keyItem' => $keyItem,
        ]);
    }

    public function update(UpdateTranslateRequest $request, Translate $translate)
    {
        $values = $request->get('value');
        if ($translate && $translate->id && $values && is_array($values)) {
            foreach ($values as $langCode => $value) {
                if (empty($value)) continue;
                Localization::addKeyToTranslation($translate->key, $value, $langCode);
            }
        }
        $request->session()->flash('msg', ['success' => 'str_public.Updated was successful!']);
        return redirect()->route('translate.index');
    }

    public function destroy(Translate $translate)
    {
        $translate->delete();
        return redirect()->back();
    }

    public function generate(): RedirectResponse
    {
            Localization::exportTranslations();
            request()->session()->flash('msg',['success'=>__('str_public.Generate Translation File was successful!')]);
            return redirect()->back();
    }
}
