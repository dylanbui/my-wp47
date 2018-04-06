
<form action="" method="post" id="frmHoiDap" name="frmHoiDap" enctype="multipart/form-data">
    <div class="form-group">
        <label for="email">Tiêu đề:</label>
        <input type="text" class="form-control" id="title" name="title">
    </div>
    <div class="form-group">
        <label for="cau-hoi">Câu hỏi:</label>
        <textarea class="form-control" id="cau-hoi" name="cau-hoi" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="hinh-dai-dien">File input</label>
        <input type="file" class="form-control-file" id="hinh-dai-dien" name="hinh-dai-dien" aria-describedby="fileHelp">
        <small id="fileHelp" class="form-text text-muted">This is some placeholder block-level help text for the above input. It's a bit lighter and easily wraps to a new line.</small>
    </div>

    <input type="hidden" name="submit_action" value="answer" />
    <?php wp_nonce_field('answer', 'submit_action_key'); ?>
    <button type="submit" class="btn btn-default">Submit</button>
</form>