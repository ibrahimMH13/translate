<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('str_admin.translate') }}
        </h2>
    </x-slot>
    <div class="max-w-6xl mx-auto flex justify-end ">
        <div class="m-5 p-5">
            <a href="{{route('translate.generate')}}" class="p-3 text-green-600 font-weight-bolder">{{__('str_admin.Generate Translate')}}</a>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="m-auto">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto shadow-md sm:rounded-lg">
                            <div class="inline-block min-w-full align-middle dark:bg-gray-800">
                                <div class="overflow-hidden w-full">
                                    <table class="display w-full align-middle	" >
                                        <thead class="py-10">
                                        <tr >
                                            <th>{{__('str_admin.key')}}</th>
                                            <th>{{__('str_admin.language_code')}}</th>
                                            <th>#</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($translates as $record)
                                            <tr class="m-2 p-10">
                                                <td class="px-6 m-1">{{$record->key}}</td>
                                                <td class="text-center">{{$record->language_code}}</td>
                                                <td class="flex justify-end">
                                                    <a href="{{route('translate.edit',$record)}}" class="m-2 p-2 text-blue-800">{{__('str_admin.edit')}}</a>
                                                    <form method="post" action="{{route('translate.destroy',$record)}}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="m-2 p-2 text-red-600">{{__('str_admin.delete')}}</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <h2>
                                                {{__('str_admin.no there data available')}}
                                            </h2>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if( method_exists($translates,'links') )
                                    <div class="p-5">
                                        {{$translates->links()}}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
