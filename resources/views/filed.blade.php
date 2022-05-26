@if(isset($translate))
    <div class="bg-green-500 pr-4 pl-4 pt-4 text-white"><strong class="text-gray-700">Group </strong> : {{ $keyGroup }}</div>
    <div class="bg-green-500 pr-4 pl-4 pb-4 text-white"><strong class="text-gray-700">Key </strong> : {{ $keyItem }}</div>
    <hr>
    @foreach($locales as $code => $data)
        <div class="w-3/5 m-auto mt-5">
            <div class="flex flex justify-between">
                <div class="w-5/6">
                    <label for="value-{{$code}}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400"><strong>Translation ({{$data['title']}})</strong></label>
                    <textarea id="value-{{$code}}"
                              name="value[{{$code}}]"
                              {{ $code == 'ar' ? 'dir=rtl' : '' }}
                              rows="4"
                              class="block p-2.5 w-full text-gray-900 {{ $errors->has("value.{$code}") ? 'text-red-500' : '' }} text-sm  bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old("value.{$code}", ($data['translation']->value ?? '')) }}</textarea>
                    @if ($errors->has("value.{$code}"))
                        <span class="invalid-feedback"><strong>{{ $errors->first("value.{$code}") }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group row">
            @if(false)
                <div class="col-md-8">
                    <button type="button" class="btn btn-link text-green-700" id="enable-translation-{{$code}}"
                            onclick="enableTranslation('{{$code}}');">Enable
                    </button>
                    <button type="button" class="btn btn-link text-red-700" id="disable-translation-{{$code}}"
                            onclick="disableTranslation('{{$code}}');">Disable
                    </button>
                </div>
            @endif
        </div>
    @endforeach
@endif



