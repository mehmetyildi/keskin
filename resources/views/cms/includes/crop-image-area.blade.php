<div class="form-group">
    <label for="{{ $field }}_input" class="col-sm-3 control-label">{{ $title }}</label>
    <div class="col-sm-9">
        <div class="row">
            <div class="col-md-12 responsive-1024 {{ $field }}_container">
                <img src="" id="{{ $field }}_preview" alt="Henüz bir görsel seçmediniz" /><br>
                <input type="file" class="selectImageToCrop" data-field="{{ $field }}" data-ratio="{{ $ratio }}" data-container=".{{ $field }}_container" name="cropMe" {{ $required ? 'required' : '' }}>
            </div>
            <input type="hidden" id="{{ $field }}_crop_x" name="{{ $field }}_x" />
            <input type="hidden" id="{{ $field }}_crop_y" name="{{ $field }}_y" />
            <input type="hidden" id="{{ $field }}_crop_w" name="{{ $field }}_w" />
            <input type="hidden" id="{{ $field }}_crop_h" name="{{ $field }}_h" />
            <input type="hidden" id="{{ $field }}" name="{{ $field }}" />
        </div>
    </div>
</div>
<hr>