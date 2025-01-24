@php
    $labelName = $label_name ?? 'Image';
    $inputName = $input_name ?? 'image';
    $editVariable = $edit_variable ?? null;
    $maxSize = $max_size ?? 2000000; // Default to 2 MB
    $minSize = $min_size ?? 5000; // Default to 5 KB
    $minWidth = $min_width ?? 150; // Default to 150px
    $minHeight = $min_height ?? 150; // Default to 150px
    $editImagePath = $edit_image_path ?? null;
@endphp

<div class="form-group col-12" id="change_img_input_wrapper_{{ $inputName }}"
    style="{{ isset($editVariable) && $editVariable->image ? 'display:none;' : '' }}">

    <label>{{ $labelName }} image
        <small class="text-primary">
            (Condition: max {{ $maxSize / 1000000 }} MB, min {{ $minSize / 1000 }} KB, dimensions at least
            {{ $minWidth }}x{{ $minHeight }} px)
        </small>
    </label>

    <div class="custom-file">
        <input name="{{ $inputName }}" type="file" class="form-control h-unset"
            accept="image/png, image/jpg, image/jpeg" id="custom_image_input_{{ $inputName }}">
    </div>
    <div id="img_wrapper_{{ $inputName }}" class="mt-2" style="display:none; position:relative; width: max-content;">
        <img src="#" alt="{{ $labelName }} image" id="custom_image_input_preview_{{ $inputName }}"
            style="max-height: 300px; max-width:500px" />
        <div id="input_img_reset_{{ $inputName }}"
            style="background: red;width: 25px;height:25px;top: 0;right: 0;position: absolute; cursor:pointer;padding-left: 3px;">
            <i class="fa-sharp fa-solid fa-xmark" style="font-size: 25px; color: #ffffff;"></i>
        </div>
    </div>
</div>

<input style="display: none" value="no" type="text" name="custom_img_edit_status_{{ $inputName }}"
id="custom_img_edit_status_{{ $inputName }}">

@if (isset($editVariable) && $editVariable->image)
    <div id="previous_img_info_{{ $inputName }}" style="display:block;" class="col-12">
        <label>{{ $labelName }} Image: </label>

        <div
        style="
        height:250px; width:300px; 
        background: url({{ $editImagePath }}/{{ $editVariable->image ?? '' }}) no-repeat center; 
        background-size:contain;
        background-color: #343a41;
        position:relative;
        ">

            <button id="change_prv_img_button_{{ $inputName }}" type="button" class="btn btn-success">Change image</button>
            <button id="delete_prv_img_button_{{ $inputName }}" type="button" class="btn btn-danger">Delete image</button>
          
        </div>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imgInputField = document.querySelector('#custom_image_input_{{ $inputName }}');
        const imgPreviewArea = document.querySelector('#custom_image_input_preview_{{ $inputName }}');
        const inputImgReset = document.querySelector('#input_img_reset_{{ $inputName }}');
        const customImgEditStatus = document.querySelector('#custom_img_edit_status_{{ $inputName }}');
        const imgWrapper = document.querySelector('#img_wrapper_{{ $inputName }}');
        const previousImgInfo = document.querySelector('#previous_img_info_{{ $inputName }}');
        const changeImgInputWrapper = document.querySelector('#change_img_input_wrapper_{{ $inputName }}');
        const deletePrvImgButton = document.querySelector("#delete_prv_img_button_{{ $inputName }}");
        const changePrvImgButton = document.querySelector("#change_prv_img_button_{{ $inputName }}");

        if (imgInputField) {
            imgInputField.addEventListener('change', evt => {
                const [file] = imgInputField.files;
                if (file) {
                    if (file.size > {{ $maxSize }} || file.size < {{ $minSize }}) {
                        alert(`File size must be between {{ $minSize / 1000 }} KB and {{ $maxSize / 1000000 }} MB`);
                        imgInputField.value = "";
                        if (customImgEditStatus) customImgEditStatus.value = 'no';
                        imgWrapper.style.display = 'none';
                        return;
                    }
                    const img = new Image();
                    img.src = URL.createObjectURL(file);
                    img.onload = () => {
                        if (img.width < {{ $minWidth }} || img.height < {{ $minHeight }}) {
                            alert(`Image dimensions must be at least {{ $minWidth }}x{{ $minHeight }} pixels.`);
                            imgInputField.value = "";
                            if (customImgEditStatus) customImgEditStatus.value = 'no';
                            imgWrapper.style.display = 'none';
                            return;
                        }
                        imgPreviewArea.src = img.src;
                        if (customImgEditStatus) customImgEditStatus.value = 'changed';
                        imgWrapper.style.display = 'block';
                    };
                }
            });

            inputImgReset.addEventListener('click', () => {
                imgInputField.value = "";
                if (customImgEditStatus) customImgEditStatus.value = 'no';
                imgWrapper.style.display = 'none';
            });
        }

        if (deletePrvImgButton) {
            deletePrvImgButton.addEventListener('click', () => {
                customImgEditStatus.value = 'deleted';
                previousImgInfo.style.display = 'none';
            });
        }

        if (changePrvImgButton) {
            changePrvImgButton.addEventListener('click', () => {
                customImgEditStatus.value = 'changed';
                previousImgInfo.style.display = 'none';
                changeImgInputWrapper.style.display = 'block';
            });
        }
    });
</script>
