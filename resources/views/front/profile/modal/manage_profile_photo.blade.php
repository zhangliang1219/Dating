<div id="profilePhotosModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h4 class="modal-title">Photos</h4>
                <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 1;">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" id="editProfile" method="post">
                    @csrf
                    <div class='row'>
                        <div class="input-group">
                            <div class="col-6">
                                <label for="upload_photos" >Upload Photos</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="photo_upload" accept="image/*" name='photo_upload'>
                                    <label class="custom-file-label" for="photo_upload">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div><br>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{trans('sentence.save')}}
                            </button>
                            <button type="cancel" class="btn btn-secondary">
                                {{trans('sentence.cancel')}}
                            </button>
                        </div>
                    </div>
                </form>
                <table class='photo_gallary'>
                    <tr>
                        
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>