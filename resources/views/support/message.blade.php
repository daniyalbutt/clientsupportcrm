@extends('layouts.app-support')
@push('styles')
<style>
    .quote-imgs-thumbs {
        background: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: 0px;
        margin: 1.5rem 0;
        padding: 0.75rem;
        padding-bottom: 0;
        display: flex;
        flex-wrap: wrap;
    }
    .quote-imgs-thumbs--hidden {
        display: none;
    }
    .img-preview-thumb {
        background: #fff;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        box-shadow: 0.125rem 0.125rem 0.0625rem rgb(0 0 0 / 12%);
        margin-right: 1rem;
        max-width: 120px;
        padding: 0.25rem;
        height: 120px;
        object-fit: contain;
        margin-bottom: 8px;
    }
    .quote-imgs-thumbs > p {
        flex: 0 0 100%;
    }
    .file-wrapper {
        text-align: center;
    }
    .file-wrapper a {
        width: 120px;
        display: block;
        margin-bottom: 15px;
    }
    .gallery-image-btn {
        position: absolute !important;
        width: 1px;
        height: 1px;
        padding: 0;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        -webkit-clip-path: inset(50%);
        clip-path: inset(50%);
        border: 0;
    }
</style>
@endpush
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Messages</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="card chat-sidebar-container" data-sidebar-container="chat">
    <div class="chat-sidebar-wrap" data-sidebar="chat">
        <div class="border-right">
            <div class="pt-2 pb-2 pl-3 pr-3 d-flex align-items-center o-hidden box-shadow-1 chat-topbar"><a class="link-icon d-md-none" data-sidebar-toggle="chat"><i class="icon-regular ml-0 mr-3 i-Left"></i></a>
                <div class="form-group m-0 flex-grow-1">
                    <input class="form-control form-control-rounded" id="search" type="text" placeholder="Search contacts" />
                </div>
            </div>
            <div class="contacts-scrollable perfect-scrollbar">
                <div class="mt-4 pb-2 pl-3 pr-3 font-weight-bold text-muted border-bottom">Recent</div>
                <div class="p-3 d-flex align-items-center border-bottom online contact"><img class="avatar-sm rounded-circle mr-3" src="../../dist-assets/images/faces/13.jpg" alt="alt" />
                    <div>
                        <h6 class="m-0">Frank Powell</h6><span class="text-muted text-small">3 Oct, 2018</span>
                    </div>
                </div>
                <div class="mt-3 pb-2 pl-3 pr-3 font-weight-bold text-muted border-bottom">Projects</div>
                @foreach($data as $datas)
                <a href="{{ route('support.message.show', $datas->id) }}" class="p-3 d-flex border-bottom align-items-center contact online">
                    @if($datas->client->image != '')
                    <img src="{{ asset($datas->client->image) }}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @else
                    <img src="{{ asset('global/img/user.png') }}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @endif
                    <h6>{{ $datas->name }} <span>User: {{ $datas->client->name }}</span></h6>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="chat-content-wrap" data-sidebar-content="chat">
        <div class="d-flex pl-3 pr-3 pt-2 pb-2 o-hidden box-shadow-1 chat-topbar">
            <p class="m-0 text-title text-16">{{ $project != null ? $project->name : '' }}</p>
            <p class="m-0 text-title text-16">{{ $project != null ? $project->client->name : '' }}</p>
        </div>
        <div class="chat-content perfect-scrollbar" data-suppress-scroll-x="true">
            <div class="d-flex mb-4">
                <div class="message flex-grow-1">
                    <div class="d-flex">
                        <p class="mb-1 text-title text-16 flex-grow-1">Frank Powell</p><span class="text-small text-muted">25 min ago</span>
                    </div>
                    <p class="m-0">Do you ever find yourself falling into the “discount trap?</p>
                </div><img class="avatar-sm rounded-circle ml-3" src="../../dist-assets/images/faces/13.jpg" alt="alt" />
            </div>
            <div class="d-flex mb-4 user"><img class="avatar-sm rounded-circle mr-3" src="../../dist-assets/images/faces/1.jpg" alt="alt" />
                <div class="message flex-grow-1">
                    <div class="d-flex">
                        <p class="mb-1 text-title text-16 flex-grow-1">Jhon Doe</p><span class="text-small text-muted">24 min ago</span>
                    </div>
                    <p class="m-0">Lorem ipsum dolor sit amet.</p>
                </div>
            </div>
            <div class="d-flex mb-4">
                <div class="message flex-grow-1">
                    <div class="d-flex">
                        <p class="mb-1 text-title text-16 flex-grow-1">Frank Powell</p><span class="text-small text-muted">25 min ago</span>
                    </div>
                    <p class="m-0">Do you ever find yourself falling into the “discount trap?</p>
                </div><img class="avatar-sm rounded-circle ml-3" src="../../dist-assets/images/faces/13.jpg" alt="alt" />
            </div>
            <div class="d-flex mb-4 user"><img class="avatar-sm rounded-circle mr-3" src="../../dist-assets/images/faces/1.jpg" alt="alt" />
                <div class="message flex-grow-1">
                    <div class="d-flex">
                        <p class="mb-1 text-title text-16 flex-grow-1">Jhon Doe</p><span class="text-small text-muted">24 min ago</span>
                    </div>
                    <p class="m-0">Lorem ipsum dolor sit amet.</p>
                </div>
            </div>
        </div>
        <div class="pl-3 pr-3 pt-3 pb-3 box-shadow-1 chat-input-area">
            <form class="inputForm" id="inputForm">
                <input type="hidden" id="project_id" name="project_id" value="{{ $project->id }}">
                <div class="grid-x grid-padding-x">
                    <div class="small-10 small-offset-1 medium-8 medium-offset-2 cell">
                        <p>
                            <!-- <label for="upload_imgs" class="btn btn-orange hollow w-100 text-center">Select Your Images +</label> -->
                            <input class="gallery-image-btn how-for-sr" type="file" id="upload_imgs" name="upload_imgs[]" multiple/>
                        </p>
                        <div class="quote-imgs-thumbs quote-imgs-thumbs--hidden" id="img_preview" aria-live="polite"></div>
                    </div>
                </div>
                <div class="form-group">
                    <textarea class="form-control form-control-rounded" id="message" placeholder="Type your message" name="message" cols="30" rows="3" required></textarea>
                </div>
                <div class="d-flex message-btn-wrapper">
                    <div class="flex-grow-1"></div>
                    <button class="btn btn-icon btn-rounded btn-primary mr-2" type="submit"><i class="i-Paper-Plane"></i></button>
                    <label for="upload_imgs" class="btn btn-icon btn-rounded btn-outline-primary upload_btn_imgs" type="button"><i class="i-Add-File"></i></label>
                </div>
            </form>
        </div>
    </div>
</div><!-- end of main-content -->
@endsection
@push('scripts')
<script src="{{ asset('newglobal/js/sidebar.script.min.js') }}"></script>
<script>
    var imgUpload = document.getElementById('upload_imgs'),
    imgPreview = document.getElementById('img_preview'),
    totalFiles,
    previewTitle,
    previewTitleText,
    img;

    imgUpload.addEventListener('change', previewImgs, false);
    function previewImgs(event) {
        totalFiles = imgUpload.files.length;
        if(!!totalFiles) {
            imgPreview.classList.remove('quote-imgs-thumbs--hidden');
            previewTitle = document.createElement('p');
            previewTitle.style.fontWeight = 'bold';
            previewTitleText = document.createTextNode(totalFiles + ' Total Images Selected');
            previewTitle.appendChild(previewTitleText);
            imgPreview.appendChild(previewTitle);
        }
        for(var i = 0; i < totalFiles; i++) {
            var checkImage = isImage(event.target.files[i]);
            var div = document.createElement('div');
            div.className = 'file-wrapper';
            if(checkImage){
                paragraph = document.createElement('a');
                paragraph.innerHTML = event.target.files[i]['name'];
                paragraph.href = URL.createObjectURL(event.target.files[i]);
                paragraph.target = '_blank';
                img = document.createElement('img');
                img.src = URL.createObjectURL(event.target.files[i]);
                img.classList.add('img-preview-thumb');
                div.appendChild(img);
                div.appendChild(paragraph);
                imgPreview.appendChild(div);
            }else{
                paragraph = document.createElement('a');
                paragraph.innerHTML = event.target.files[i]['name'];
                paragraph.href = URL.createObjectURL(event.target.files[i]);
                paragraph.target = '_blank';
                input = document.createElement('input');
                input.src = URL.createObjectURL(event.target.files[i]);
                input.classList.add('img-preview-thumb');
                div.appendChild(input);
                div.appendChild(paragraph);
                imgPreview.appendChild(div);
            }
        }
    }
    function isImage(file){
        return (file['type'].split('/')[0]=='image');
    }

    // Send Message
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#inputForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('support.message.send') }}",
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
            enctype: 'multipart/form-data',
            data: formData,
            success: function(response) {
                console.log(response);
            }
        });
    });
</script>

@endpush