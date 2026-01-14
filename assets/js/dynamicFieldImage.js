$(document).ready(function() {

    // Add Image Card
    $("#addImage").click(function() {
        let card = `
            <div class="image-card">
                <div class="preview-container">
                    <i class="bi bi-image preview-placeholder"></i>
                    <img src="" class="preview-box">
                </div>
                <div class="mb-2">
                    <select name="img_types[]" class="form-select form-select-sm" required>
                        <option value="" selected disabled>Category...</option>
                        <option value="site_progress">Site Progress</option>
                        <option value="before_photo">Before Photo</option>
                        <option value="after_photo">After Photo</option>
                    </select>
                </div>
                <input type="file" name="img_files[]" class="form-control form-control-sm img-input" accept="image/*" required>
                <button class="btn btn-danger btn-sm remove-img-btn remove-btn" type="button"><i class="bi bi-x-lg"></i></button>
            </div>`;
        $('#imageWrapper').append(card);
    });

    // Remove logic
    $(document).on('click', '.remove-btn', function() {
        $(this).closest('.dynamic-row, .image-card').fadeOut(200, function() { $(this).remove(); });
    });

    // Image Preview logic
    $(document).on('change', '.img-input', function() {
        const input = this;
        const card = $(this).closest('.image-card');
        const preview = card.find('.preview-box');
        const placeholder = card.find('.preview-placeholder');

        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                preview.attr('src', e.target.result).show();
                placeholder.hide();
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
});