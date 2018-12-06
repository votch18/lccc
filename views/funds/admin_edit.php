
<h3>Modify News</h3>
<hr/>

<form method="POST">
    <input type="hidden" class="form-control" name="id" value="<?=$this->data['id'] ?>" required>
    <div class="row row-sm-offset">

        <div class="col-xs-12 col-md-12">
            <div class="form-group">
                <label class="form-control-label" for="form1-9-fname">Title<span class="form-asterisk">*</span></label>
                <input type="text" class="form-control" name="title" required="" data-form-field="name" id="form1-9-fname"  value="<?=$this->data['title'] ?>">
            </div>
        </div>
    </div>

        <div class="row row-sm-offset">
            <div class="col-xs-12 col-md-12">
                <div class="form-group">
                    <label class="form-control-label" for="form1-9-address">Content</label>
                    <textarea class="form-control" name="content" rows="20" data-form-field="Message" id="content"><?=$this->data['content'] ?></textarea>
                </div>
            </div>
        </div>

        <script>
            tinymce.init({
                  selector: '#content',
                  height: 500,
                  plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table contextmenu paste code'
                  ],
                  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                  content_css: '//www.tinymce.com/css/codepen.min.css'
                });
           </script>

    <hr/>
    <button class="btn btn-primary">SAVE</button>
</form>
