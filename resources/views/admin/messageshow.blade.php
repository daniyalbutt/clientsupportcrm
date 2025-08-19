@extends('layouts.app-admin')
@push('styles')
<style>
    .ul-widget2__username {
       font-size: 0.8rem;
    }
    .ul-widget4__actions {flex: 0 0 220px;}
    .highlight{
        background: orange;
        color: black;
    }
    .modal-xl{
        max-width: 1140px;
    }
</style>
@endpush
@section('content')

<div class="breadcrumb">
    <h1 class="mr-2">Messages</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <form action="{{ route('admin.message') }}" method="GET">
                    <div class="row">
                        <div class="col-md-3 form-group mb-3">
                            <label for="brand">Search By Brand</label>
                            <select name="brand" id="brand" class="form-control select2">
                                <option value="">Select Brand</option>
                                @foreach($brands as $key => $value)
                                <option value="{{ $value->id }}" {{ Request::get('brand') ==  $value->id ? 'selected' : ' '}}>{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="message">Search By Message</label>
                            <input type="text" class="form-control" id="message" name="message" value="{{ Request::get('message') }}">
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="client_name">Search By Client</label>
                            <input class="form-control" type="text" name="client_name" id="client_name" value="{{ Request::get('client_name') }}">
                        </div>
                        <div class="col-md-12">
                            <div class="text-right">
                                <button class="btn btn-primary">Search Result</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<section class="widgets-content">
    <!-- begin::users-->
    <div class="row mt-2">
        <div class="col-xl-12">
            @foreach($data as $key => $value)
            @php
            $objection_count = \App\Models\ProjectObjection::where('user_id','=',Auth::user()->id)
                                ->where('project_id','=',$value->project_id)
                                ->where('status', '=',0)
                                ->get()->count();
            @endphp
            <div class="card mb-4">
                <div class="card-body">
                    <div class="ul-widget__body">
                        <div class="tab-content pt-0 pb-0">
                            <div class="tab-pane active show">
                                <div class="ul-widget1">
                                    <div class="ul-widget4__item ul-widget4__users">
                                        <div class="ul-widget4__img">
                                            <img id="userDropdown" src="{{ asset('newglobal/images/no-user-img.jpg') }}" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" />
                                        </div>
                                        <div class="ul-widget2__info ul-widget4__users-info">
                                            <a class="ul-widget2__title" href="">{{ $value->name }} {{ $value->last_name }} - <span>{{ $value->email }}</span> <span class="badge badge-primary">{{ Request('message')}} {{ date('h:i A d, M Y', strtotime($value->created_at)) }}</span></a>
                                            <span class="ul-widget2__username" href="#">
                                                {!! \Illuminate\Support\Str::limit(preg_replace("/<\/?a( [^>]*)?>/i", "", strip_tags($value->message)), 300, $end='...') !!}
                                            </span>
                                        </div>
                                        <div class="ul-widget4__actions text-center">
                                            <div class="d-flex">
                                                <a href="javascript:;" data-support-id="{{ $value->support_id }}"
                                                        data-project-id="{{$value->project_id}}" data-toggle="modal"
                                                        data-target="#exampleModalCenter"
                                                        class="get-objection btn btn-outline-secondary mr-2">Q/A
                                                        Objections 
                                                        @if($objection_count == 0)
                                                        <span class="badge badge-pill badge-success ml-1" id="objection-count">{{$objection_count}}</span>
                                                        @else
                                                        <span class="badge badge-pill badge-primary ml-1" id="objection-count">{{$objection_count}}</span>
                                                        @endif
                                                        </a>
                                                <a href="{{ route('admin.message.show', [ 'id' => $value->user_id, 'name' => strtolower($value->name) . '-' . strtolower($value->last_name)]) }}" class="btn btn-outline-success mr-2">Message Details</a>
                                                <a href="{{ route('admin.client.show', $value->client_id) }}" class="btn btn-primary">Client Details</a>
                                            </div>
                                            <span class="badge badge-info">{{ $value->brand_name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- end::users-->
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Project Objections</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive ob-data-table">
                        <table class="table table-bordered obj-table">
                            <thead>
                                <tr>
                                    <th>Objection#</th>
                                    <th>Message</th>
                                    <th>Support Reply</th>
                                    <th>Support</th>
                                    <th>Status</th>
                                    <th>Resolved By</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="objection-data">

                            </tbody>
                        </table>
                    </div>
                    <div class="obj-details" style="display: none;">
                    <button class="btn btn-primary back-to-list float-right"><span aria-hidden="true">×</span></button>
                        <div class="modal-header d-flex justify-content-center" style="padding: 1rem 0 1rem 0;">
                            <h5 class="modal-title objection-detail-title" id="exampleModalLongTitle">Objection Details</h5>
                        </div>
                        <div class="container" id="detailsContent">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Message</th>
                                    <td><span id="detail-message"></span></td>
                                </tr>
                                <tr>
                                    <th>Support Reply</th>
                                    <td><span id="support-message"></span></td>
                                </tr>
                                <tr>
                                    <th>Support Name</th>
                                    <td><span id="detail-support-name"></span></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><span id="detail-status"></span></td>
                                </tr>
                                <tr>
                                    <th>Resolved By</th>
                                    <td><span id="detail-resolved-by"></span></td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td><span id="detail-created-at"></span></td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td><span id="detail-updated-at"></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-header" style="padding: 1rem 0 1rem 0;">
                        <h5 class="modal-title" id="exampleModalLongTitle">Create Project Objection</h5>
                    </div>
                    <div class="add-objection-section d-flex justify-content-center" style="padding-top: 15px;">
                        <form action="" method="post" id="objection-form" style="width: 100%;">
                            @csrf
                            <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user_id">
                            <input type="hidden" name="support_id" id="support_id">
                            <input type="hidden" name="project_id" id="project_id">
                            <label for="message">Note Message</label>
                            <textarea class="form-control" name="message" id="objection_message"
                                placeholder="Write your objection note here."></textarea>
                            <button type="submit" class="btn btn-primary mt-2">Add New Objection</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script>
        function limitWords(text, wordLimit) {
            var words = text.split(' '); 
            if (words.length > wordLimit) {
                return words.slice(0, wordLimit).join(' ') + '...';
            }
            return text;
        }
        $(document).ready(function () {
            $('.obj-table').DataTable({
                "order": [[6, "desc"]]
            });
            let dataTable = $('.obj-table').DataTable();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.get-objection').on('click', function () {
                dataTable.clear();
                $('.obj-details').fadeOut();
                var support_id = $(this).data('support-id');
                var project_id = $(this).data('project-id');
                $('#support_id').val(support_id);
                $('#project_id').val(project_id);


                $.ajax({
                    url: 'get-objection-data',
                    type: 'POST',
                    data: {
                        support_id: support_id,
                        project_id: project_id
                    },
                    success: function (response) {
                        if (response.data == '' || response.data == null) {
                            $('.ob-data-table').fadeOut();
                        } else {
                            $('.ob-data-table').fadeIn();
                            var responseData = response.data;
                            $.each(responseData, function (index, data) {
                                let statusBadge = data.status
                                    ? "<a class='obj-status btn btn-success' href='javascript:;'  data-obj-id='"+ data.id +"'><span style='color: #fff !important;' class='badge bg-success'>Resolved</span></a>"
                                    : "<a class='obj-status btn btn-danger' href='javascript:;'  data-obj-id='"+ data.id +"'><span style='color: #fff !important;' class='badge bg-danger'>Pending</span></a>";
                                let created_date = new Date(data.created_at);
                                let created_at = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true };
                                let updated_date = new Date(data.updated_at);
                                let updated_at = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true }; 
                                let resolved_by = data.resolved ? '<span data-id="'+data.id+'">'+data.resolved+'</span>' : '<span data-id="'+data.id+'">N/A</span>';
                                let detail_view = "<a class='obj-detail btn btn-primary' href='javascript:;' data-obj-id='"+ data.id +"'>View Details</a>"
                                dataTable.row.add([
                                    data.id,
                                    limitWords(data.message, 10),
                                    data.support_reply ? limitWords(data.support_reply, 10) : 'No-Reply',
                                    data.support_name,
                                    statusBadge,
                                    resolved_by,
                                    created_date.toLocaleString('en-US', created_at),
                                    updated_date.toLocaleString('en-US', updated_at),
                                    detail_view,
                                ]);
                                $('#detail-status').empty()
                                $('#detail-status').append(statusBadge);
                            });
                            dataTable.draw();
                        };
                    },
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    }
                });
            })

            $('#objection-form').on('submit', function (e) {
                e.preventDefault();
                var user_id = $('#user_id').val();
                var project_id = $('#project_id').val();
                var support_id = $('#support_id').val();
                var message = $('#objection_message').val();
                $.ajax({
                    url: 'post-objection-data',
                    type: 'POST',
                    data: {
                        user_id: user_id,
                        project_id: project_id,
                        support_id: support_id,
                        message: message,
                    },
                    success: function (response) {
                        if (response.data && response.data !== '') {
                            $('.ob-data-table').fadeIn();
                            $('#objection_message').val('');

                            var responseData = response.data;

                            let statusBadge = responseData.status
                                    ? "<a class='obj-status btn btn-success' href='javascript:;'  data-obj-id='"+ responseData.id +"'><span style='color: #fff !important;' class='badge bg-success'>Resolved</span></a>"
                                    : "<a class='obj-status btn btn-danger' href='javascript:;'  data-obj-id='"+ responseData.id +"'><span style='color: #fff !important;' class='badge bg-danger'>Pending</span></a>";

                            let created_date = new Date(responseData.created_at);
                            let created_at_options = {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: true
                            };
                            let updated_date = new Date(responseData.updated_at);
                            let updated_at_options = {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: true
                            };
                            let detail_view = "<a class='obj-detail btn btn-primary' href='javascript:;' data-obj-id='"+ responseData.id +"'>View Details</a>"
                            dataTable.row.add([
                                responseData.id,
                                limitWords(responseData.message, 10),
                                responseData.support_reply ? limitWords(responseData.support_reply, 10) : 'No-Reply',
                                responseData.support_name,
                                statusBadge,
                                responseData.resolved ? responseData.resolved : "N/A",
                                created_date.toLocaleString('en-US', created_at_options),
                                updated_date.toLocaleString('en-US', updated_at_options),
                                detail_view,
                            ]);

                            dataTable.draw();

                        } else {
                            $('.ob-data-table').fadeIn();
                            $('#objection_message').text('No data available.');
                        }
                    },

                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    }
                });
            });

        })
        $(document).on('click', '.obj-status', function() {
            var objection_id = $(this).data('obj-id');
            let dataTable = $('.obj-table').DataTable();

            var button = $(this);

            $.ajax({
                url: 'update-objection-status',
                method: 'POST',
                data: {
                    id: objection_id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    var badge = button.find('span');
                    var statusText = response.status == 1 ? 'Resolved' : 'Pending';
                    var resolvedBy = response.resolved_by ? response.resolved_by : "N/A";

                    if (response.status == 1) {
                        button.removeClass('btn-danger').addClass('btn-success');
                        badge.removeClass('bg-danger').addClass('bg-success').text('Resolved');
                    } else {
                        button.removeClass('btn-success').addClass('btn-danger');
                        badge.removeClass('bg-success').addClass('bg-danger').text('Pending');
                    }

                    var aTag = $('#objection-data').find('a[data-obj-id="' + objection_id + '"]');
                    if (aTag.length) {
                        var badge = aTag.find('span');

                        var statusText = response.status == 1 ? 'Resolved' : 'Pending';
                        var resolvedBy = response.resolved_by ? response.resolved_by : "N/A";

                        if (response.status == 1) {
                            aTag.removeClass('btn-danger').addClass('btn-success');
                            badge.removeClass('bg-danger').addClass('bg-success').text(statusText);
                        } else {
                            aTag.removeClass('btn-success').addClass('btn-danger');
                            badge.removeClass('bg-success').addClass('bg-danger').text(statusText);
                        }

                        $('span[data-id="' + objection_id + '"]').text(resolvedBy);
                    } else {
                        console.log('No <a> tag found with the specified data-id.');
                    }

                    $('span[data-id="' + objection_id + '"]').text(resolvedBy);
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                }
            });
        });
        $(document).on('click', '.back-to-list', function() {
            $('.obj-details').fadeOut();
            $('.ob-data-table').fadeIn();
        })
        $(document).on('click', '.obj-detail', function() {
            var objection_id = $(this).data('obj-id');
            $.ajax({
                url: 'get-objection-details',
                method: 'POST',
                data: {
                    id: objection_id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    let created_date = new Date(response.data.created_at);
                    let created_at = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true };
                    let updated_date = new Date(response.data.updated_at);
                    let updated_at = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true }; 
                    $('.objection-detail-title').text(`Objection Details (Obj# ${response.data.id})`)
                    $('#detail-message').text(response.data.message);
                    $('#support-message').text(response.data.support_reply ? response.data.support_reply : "No-Reply");
                    $('#detail-support-name').text(response.data.support_name);
                    let statusBadge = response.data.status
                                    ? "<a class='obj-status btn btn-success' href='javascript:;'  data-obj-id='"+ response.data.id +"'><span style='color: #fff !important;' class='badge bg-success'>Resolved</span></a>"
                                    : "<a class='obj-status btn btn-danger' href='javascript:;'  data-obj-id='"+ response.data.id +"'><span style='color: #fff !important;' class='badge bg-danger'>Pending</span></a>";
                    $('#detail-status').empty()
                    $('#detail-status').append(statusBadge);
                    $('#detail-resolved-by').text(response.data.resolved);
                    $('#detail-created-at').text(created_date.toLocaleString('en-US', created_at));
                    $('#detail-updated-at').text(updated_date.toLocaleString('en-US', updated_at));
                    $('.obj-details').fadeIn();
                    $('.ob-data-table').fadeOut();
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                }
            });
        });

    </script>

@endpush