@push('css-bootstrap')
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
@endpush
<x-app-layout>

    <x-slot name="header">
        <p class="font-semibold  text-gray-800 leading-tight">
            {{ __('str_admin.translate') }} / {{__('str_admin.edit')}} / {{$translate->key}}
        </p>
    </x-slot>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col">
                        <form method="post" action="{{route('translate.update',$translate)}}">
                            @csrf
                            @method('PUT')
                            @include('translate::filed')
                            <div class="w-3/5 mt-5 m-auto">
                                <div class="col-md-8 offset-md-2">
                                    <button type="submit" class="p-3 bg-green-700 text-white capitalize m-3">
                                        {{__('str_admin.Save')}}
                                    </button>
                                    <a href="{{route('translate.index')}}" class="p-3 bg-red-700 text-white capitalize m-3">
                                         {{__('str_admin.Cancel')}}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
