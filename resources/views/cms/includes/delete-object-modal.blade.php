<!-- Modal -->
<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route($route, $id) }}" method="POST" >
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <input type="hidden" name="field" value="{{ $field }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">İşlemi Onaylayın</h4>
                </div>
                <div class="modal-body">
                    Bu öğeyi silmek istediğinizden emin misiniz?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Vazgeç</button>
                    <button type="submit" class="btn btn-danger">Sil</button>
                </div>
            </form>
        </div>
    </div>
</div>