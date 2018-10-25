<td class="center actionsColumn">
	<a 	href="{{ route('cms.'.$pageUrl.'.edit', ['role' => $record->id]) }}" 
		class="btn btn-sm btn-info">
		<i class="fa fa-edit"></i>
	</a>
	@can('delete_content')
	<button type="button" 
			class="btn btn-danger btn-sm" 
			data-toggle="modal" 
			data-target="#deleteModal{{ $record->id }}"><i class="fa fa-trash"></i>
	</button>
	@include('cms.includes.delete-modal', [ 
		'modal_id' => 'deleteModal'.$record->id, 
		'route' => 'cms.'.$pageUrl.'.delete', 
		'id' => ['role' => $record->id]
	]) 
	@endcan
</td>