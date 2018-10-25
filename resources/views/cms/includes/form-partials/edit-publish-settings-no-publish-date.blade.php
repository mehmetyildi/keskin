<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><i class="fa fa-eye"></i> Yayınlama</h5>
        @include('cms.includes.form-partials.ibox-resize')
    </div>
    <div class="ibox-content">
        <div class="form-group">
            <label class="col-sm-3 control-label" for="publish">Yayınla</label>
            <div class="col-sm-9">
                <input type="checkbox" name="publish" class="js-switch js-switch1" {{ $record->publish ? 'checked' : '' }} />
            </div>
        </div>
       
    </div>
</div>