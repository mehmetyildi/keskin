@component('cms.components.content-listing-without-sort-or-create')

	@slot('pageUrl') 
		{{ $pageUrl }} 
	@endslot

	@slot('pageName') 
		{{ $pageName }} 
	@endslot

	@slot('pageItem') 
		{{ $pageItem }} 
	@endslot

	@slot('tHead')
		<th>Adı</th>
		<th>Oluşturan</th>
        <th>İşlem</th>
	@endslot

	@slot('tBody') 
		@foreach($records as $record)
            <tr>
                <td>Genel Ayarlar</td>
                <td>{{ $record->createdby->name .' @ '. $record->created_at->format('d/m/Y') }}</td>
				<td class="center actionsColumn">
					<a 	href="{{ route('cms.'.$pageUrl.'.edit', ['role' => $record->id]) }}"
						  class="btn btn-sm btn-info">
						<i class="fa fa-edit"></i>
					</a>
				</td>
            </tr>
        @endforeach
	@endslot

	@slot('contentScripts')

	@endslot

@endcomponent