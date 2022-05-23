<table class="table-auto">
    <thead>
    <tr>
        <th>{{__('str_admin.key')}}</th>
        <th>{{__('str_admin.language_code')}}</th>
        <th>#</th>
    </tr>
    </thead>
    @forelse($translates as $record)
    <tbody>
    <tr>
        <td>{{$record->key}}</td>
        <td>{{$record->language_code}}</td>
        <td>1961</td>
    </tr>
    </tbody>
    @empty
        <h2>
          {{__('str_admin.no there data available')}}
        </h2>
    @endforelse
</table>
