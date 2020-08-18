<div id="profilePhotosModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h4 class="modal-title">Photos</h4>
                <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 1;">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" id="manage_profile_photo" method="POST" action="javascript:void(0);">
                    @csrf
                    <div class='row'>
                        <div class="input-group">
                            <div class="col-6">
                                <label for="upload_photos" >Upload Photos</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="photo_upload" accept="image/*" name='photo_upload[]'>
                                    <label class="custom-file-label" for="photo_upload" id="photo_upload_label">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div><br>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="button" class="btn btn-primary" id="photos_gallery_save" style="display: none;">
                                {{trans('sentence.save')}}
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="location.href='{{url('/profile')}}'">
                                {{trans('sentence.cancel')}}
                            </button>
                        </div>
                    </div>
                    <table class='photo_gallery'>
                        <tr>
                            @php $i = 0; @endphp
                            @if(count($userPhoto)>0)
                                @foreach($userPhoto as $val)
                                    <td class="photo_box" id="photo_box_{{$i}}">
                                        <img src='{{url('/images/profile_gallery_photo/'.$val['photo_name'])}}' alt="photo" >
                                        <i class="fa fa-trash gallery_photo_remove" aria-hidden="true" data-count-id="{{$i}}" data-id="{{$val['id']}}"></i>
                                        <input type="checkbox" class="photo_gallery_privacy" name="upload_photos[{{$i}}]" value="1" data-count-id="{{$i}}" 
                                               {{$val['privacy_option'] == 1?'checked':''}} data-id="{{$val['id']}}">
                                    </td>
                                    @php $i++; @endphp
                                @endforeach
                            @endif
                        </tr>
                        <input type="hidden" class="photo_gallery_count"   value="{{$i}}">
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>