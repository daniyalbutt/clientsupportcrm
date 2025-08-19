@extends('layouts.app-admin')
@section('title', 'Pending Projects')

@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Pending Projects</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row mb-4">
<div class="col-md-12 mb-4">
    <div class="card text-left">
        <div class="card-body">
            <h4 class="card-title mb-3">Pending Projects Info</h4>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="logo-brief-tab" data-toggle="tab" href="#logo-brief" role="tab" aria-controls="logo-brief" aria-selected="true">Logo Brief</a></li>
                <li class="nav-item"><a class="nav-link" id="website-brief-tab" data-toggle="tab" href="#website-brief" role="tab" aria-controls="website-brief" aria-selected="false">Website Brief</a></li>
                <li class="nav-item"><a class="nav-link" id="smm-brief-tab" data-toggle="tab" href="#smm-brief" role="tab" aria-controls="smm-brief" aria-selected="false">SMM Brief</a></li>
                <li class="nav-item"><a class="nav-link" id="content-brief-tab" data-toggle="tab" href="#content-brief" role="tab" aria-controls="content-brief" aria-selected="false">Content Writing Brief</a></li>
                <li class="nav-item"><a class="nav-link" id="seo-brief-tab" data-toggle="tab" href="#seo-brief" role="tab" aria-controls="seo-brief" aria-selected="false">SEO Brief</a></li>
                <li class="nav-item"><a class="nav-link" id="book-formatting-brief-tab" data-toggle="tab" href="#book-formatting-brief" role="tab" aria-controls="book-formatting-brief" aria-selected="false">Book Formatting & Publishing Brief</a></li>
                <li class="nav-item"><a class="nav-link" id="book-writing-brief-tab" data-toggle="tab" href="#book-writing-brief" role="tab" aria-controls="book-writing-brief" aria-selected="false">Book Writing</a></li>
                <li class="nav-item"><a class="nav-link" id="author_website-brief-tab" data-toggle="tab" href="#author_website-brief" role="tab" aria-controls="author_website-brief" aria-selected="false">Author Website</a></li>
                <li class="nav-item"><a class="nav-link" id="editing-proofreading-brief-tab" data-toggle="tab" href="#editing-proofreading-brief" role="tab" aria-controls="editing-proofreading-brief" aria-selected="false">Editing & Proofreading</a></li>
                <li class="nav-item"><a class="nav-link" id="cover-design-brief-tab" data-toggle="tab" href="#cover-design-brief" role="tab" aria-controls="cover-design-brief" aria-selected="false">Cover Design</a></li>
                <li class="nav-item"><a class="nav-link" id="no-brief-tab" data-toggle="tab" href="#no-brief" role="tab" aria-controls="no-brief" aria-selected="false">No Brief</a></li>
            </ul>
            <div class="tab-content pr-0 pl-0" id="myTabContent">
                <div class="tab-pane fade show active" id="logo-brief" role="tabpanel" aria-labelledby="logo-brief-tab">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered datatable-init" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Logo Name</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Account</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logo_form as $datas)
                                <tr>
                                    <td>{{ $datas->id }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-dark">#{{ $datas->invoice->invoice_number }}</button>
                                    </td>
                                    <td>{{ ( $datas->logo_name == null ? 'Not Given' : $datas->logo_name ) }}</td>
                                    <td>{{ $datas->user->name }} {{ $datas->user->last_name }} <br>{{ $datas->user->email }} </td>
                                    <td>{{ $datas->invoice->sale->name }} {{ $datas->invoice->sale->last_name }}<br>{{ $datas->invoice->sale->email }}</td>
                                    <td><button class="btn btn-sm btn-primary">{{ $datas->invoice->brands->name }}</button></td>
                                    <td>{{ $datas->invoice->currency_show->sign }} {{ $datas->invoice->amount }}</td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-primary btn-icon btn-sm" onclick="assignAgent({{$datas->id}}, 1, {{ $datas->invoice->brands->id }})">
                                            <span class="ul-btn__icon"><i class="i-Checked-User"></i></span>
                                            <span class="ul-btn__text">Assign</span>
                                        </a>
                                        <a href="{{ route('admin.pending.project.details', ['id' => $datas->id, 'form' => 1]) }}" class="btn btn-info btn-icon btn-sm">
                                            <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                            <span class="ul-btn__text">View</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Logo Name</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Account</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="website-brief" role="tabpanel" aria-labelledby="website-brief-tab">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table_1" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Business Name</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($web_form as $datas)
                                <tr>
                                    <td>{{ $datas->id }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-dark">#{{ $datas->invoice->invoice_number }}</button>
                                    </td>
                                    <td>{{ ( $datas->business_name == null ? 'Not Given' : $datas->business_name ) }}</td>
                                    <td>{{ $datas->user->name }} {{ $datas->user->last_name }} <br>{{ $datas->user->email }} </td>
                                    <td>{{ $datas->invoice->sale->name }} {{ $datas->invoice->sale->last_name }}<br>{{ $datas->invoice->sale->email }}</td>
                                    <td><button class="btn btn-sm btn-primary">{{ $datas->invoice->brands->name }}</button></td>
                                    <td>{{ $datas->invoice->currency_show->sign }} {{ $datas->invoice->amount }}</td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-primary btn-icon btn-sm" onclick="assignAgent({{$datas->id}}, 2, {{ $datas->invoice->brands->id }})">
                                            <span class="ul-btn__icon"><i class="i-Checked-User"></i></span>
                                            <span class="ul-btn__text">Assign</span>
                                        </a>
                                        <a href="{{ route('admin.pending.project.details', ['id' => $datas->id, 'form' => 2]) }}" class="btn btn-info btn-icon btn-sm">
                                            <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                            <span class="ul-btn__text">View</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Logo Name</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="smm-brief" role="tabpanel" aria-labelledby="smm-brief-tab">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered datatable-init" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Business Name</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($smm_form as $datas)
                                <tr>
                                    <td>{{ $datas->id }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-dark">#{{ $datas->invoice->invoice_number }}</button>
                                    </td>
                                    <td>{{ ( $datas->business_name == null ? 'Not Given' : $datas->business_name ) }}</td>
                                    <td>{{ $datas->user->name }} {{ $datas->user->last_name }} <br>{{ $datas->user->email }} </td>
                                    <td>{{ $datas->invoice->sale->name }} {{ $datas->invoice->sale->last_name }}<br>{{ $datas->invoice->sale->email }}</td>
                                    <td><button class="btn btn-sm btn-primary">{{ $datas->invoice->brands->name }}</button></td>
                                    <td>{{ $datas->invoice->currency_show->sign }} {{ $datas->invoice->amount }}</td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-primary btn-icon btn-sm" onclick="assignAgent({{$datas->id}}, 3, {{ $datas->invoice->brands->id }})">
                                            <span class="ul-btn__icon"><i class="i-Checked-User"></i></span>
                                            <span class="ul-btn__text">Assign</span>
                                        </a>
                                        <a href="{{ route('admin.pending.project.details', ['id' => $datas->id, 'form' => 3]) }}" class="btn btn-info btn-icon btn-sm">
                                            <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                            <span class="ul-btn__text">View</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Logo Name</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="content-brief" role="tabpanel" aria-labelledby="content-brief-tab">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered datatable-init" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Company Name</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($content_writing_form as $datas)
                                <tr>
                                    <td>{{ $datas->id }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-dark">#{{ $datas->invoice->invoice_number }}</button>
                                    </td>
                                    <td>{{ ( $datas->company_name == null ? 'Not Given' : $datas->company_name ) }}</td>
                                    <td>{{ $datas->user->name }} {{ $datas->user->last_name }} <br>{{ $datas->user->email }} </td>
                                    <td>{{ $datas->invoice->sale->name }} {{ $datas->invoice->sale->last_name }}<br>{{ $datas->invoice->sale->email }}</td>
                                    <td><button class="btn btn-sm btn-primary">{{ $datas->invoice->brands->name }}</button></td>
                                    <td>{{ $datas->invoice->currency_show->sign }} {{ $datas->invoice->amount }}</td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-primary btn-icon btn-sm" onclick="assignAgent({{$datas->id}}, 4, {{ $datas->invoice->brands->id }})">
                                            <span class="ul-btn__icon"><i class="i-Checked-User"></i></span>
                                            <span class="ul-btn__text">Assign</span>
                                        </a>
                                        <a href="{{ route('admin.pending.project.details', ['id' => $datas->id, 'form' => 4]) }}" class="btn btn-info btn-icon btn-sm">
                                            <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                            <span class="ul-btn__text">View</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Logo Name</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="seo-brief" role="tabpanel" aria-labelledby="seo-brief-tab">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered datatable-init" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Company Name</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($seo_form as $datas)
                                <tr>
                                    <td>{{ $datas->id }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-dark">#{{ $datas->invoice->invoice_number }}</button>
                                    </td>
                                    <td>{{ ( $datas->company_name == null ? 'Not Given' : $datas->company_name ) }}</td>
                                    <td>{{ $datas->user->name }} {{ $datas->user->last_name }} <br>{{ $datas->user->email }} </td>
                                    <td>{{ $datas->invoice->sale->name }} {{ $datas->invoice->sale->last_name }}<br>{{ $datas->invoice->sale->email }}</td>
                                    <td><button class="btn btn-sm btn-primary">{{ $datas->invoice->brands->name }}</button></td>
                                    <td>{{ $datas->invoice->currency_show->sign }} {{ $datas->invoice->amount }}</td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-primary btn-icon btn-sm" onclick="assignAgent({{$datas->id}}, 5, {{ $datas->invoice->brands->id }})">
                                            <span class="ul-btn__icon"><i class="i-Checked-User"></i></span>
                                            <span class="ul-btn__text">Assign</span>
                                        </a>
                                        <a href="{{ route('admin.pending.project.details', ['id' => $datas->id, 'form' => 5]) }}" class="btn btn-info btn-icon btn-sm">
                                            <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                            <span class="ul-btn__text">View</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Company Name</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="book-formatting-brief" role="tabpanel" aria-labelledby="book-formatting-brief-tab">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered datatable-init" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Book Title</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($book_formatting_form as $datas)
                                <tr>
                                    <td>{{ $datas->id }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-dark">#{{ $datas->invoice->invoice_number }}</button>
                                    </td>
                                    <td>{{ ( $datas->book_title == null ? 'Not Given' : $datas->book_title ) }}</td>
                                    @if($datas->user != null)
                                    <td>{{ $datas->user->name }} {{ $datas->user->last_name }} <br>{{ $datas->user->email }} </td>
                                    @else
                                    <td>{{ $datas->client->name }} {{ $datas->client->last_name }} <br>{{ $datas->client->email }} </td>
                                    @endif
                                    <td>{{ $datas->invoice->sale->name }} {{ $datas->invoice->sale->last_name }}<br>{{ $datas->invoice->sale->email }}</td>
                                    <td><button class="btn btn-sm btn-primary">{{ $datas->invoice->brands->name }}</button></td>
                                    <td>{{ $datas->invoice->currency_show->sign }} {{ $datas->invoice->amount }}</td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-primary btn-icon btn-sm" onclick="assignAgent({{$datas->id}}, 6, {{ $datas->invoice->brands->id }})">
                                            <span class="ul-btn__icon"><i class="i-Checked-User"></i></span>
                                            <span class="ul-btn__text">Assign</span>
                                        </a>
                                        <a href="{{ route('admin.pending.project.details', ['id' => $datas->id, 'form' => 6]) }}" class="btn btn-info btn-icon btn-sm">
                                            <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                            <span class="ul-btn__text">View</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Company Name</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="book-writing-brief" role="tabpanel" aria-labelledby="book-writing-brief-tab">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered datatable-init" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Book Title</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($book_writing_form as $datas)
                                <tr>
                                    <td>{{ $datas->id }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-dark">#{{ $datas->invoice->invoice_number }}</button>
                                    </td>
                                    <td>{{ ( $datas->book_title == null ? 'Not Given' : $datas->book_title ) }}</td>
                                    @if($datas->user != null)
                                    <td>{{ $datas->user->name }} {{ $datas->user->last_name }} <br>{{ $datas->user->email }} </td>
                                    @else
                                    <td>{{ $datas->client->name }} {{ $datas->client->last_name }} <br>{{ $datas->client->email }} </td>
                                    @endif
                                    <td>{{ $datas->invoice->sale->name }} {{ $datas->invoice->sale->last_name }}<br>{{ $datas->invoice->sale->email }}</td>
                                    <td><button class="btn btn-sm btn-primary">{{ $datas->invoice->brands->name }}</button></td>
                                    <td>{{ $datas->invoice->currency_show->sign }} {{ $datas->invoice->amount }}</td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-primary btn-icon btn-sm" onclick="assignAgent({{$datas->id}}, 7, {{ $datas->invoice->brands->id }})">
                                            <span class="ul-btn__icon"><i class="i-Checked-User"></i></span>
                                            <span class="ul-btn__text">Assign</span>
                                        </a>
                                        <a href="{{ route('admin.pending.project.details', ['id' => $datas->id, 'form' => 7]) }}" class="btn btn-info btn-icon btn-sm">
                                            <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                            <span class="ul-btn__text">View</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Company Name</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="author_website-brief" role="tabpanel" aria-labelledby="author_website-brief-tab">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered datatable-init" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Author Name</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($author_website_form as $datas)
                                <tr>
                                    <td>{{ $datas->id }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-dark">#{{ $datas->invoice->invoice_number }}</button>
                                    </td>
                                    <td>{{ ( $datas->author_name == null ? 'Not Given' : $datas->author_name ) }}</td>
                                    @if($datas->user != null)
                                    <td>{{ $datas->user->name }} {{ $datas->user->last_name }} <br>{{ $datas->user->email }} </td>
                                    @else
                                    <td>{{ $datas->client->name }} {{ $datas->client->last_name }} <br>{{ $datas->client->email }} </td>
                                    @endif
                                    <td>{{ $datas->invoice->sale->name }} {{ $datas->invoice->sale->last_name }}<br>{{ $datas->invoice->sale->email }}</td>
                                    <td><button class="btn btn-sm btn-primary">{{ $datas->invoice->brands->name }}</button></td>
                                    <td>{{ $datas->invoice->currency_show->sign }} {{ $datas->invoice->amount }}</td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-primary btn-icon btn-sm" onclick="assignAgent({{$datas->id}}, 8, {{ $datas->invoice->brands->id }})">
                                            <span class="ul-btn__icon"><i class="i-Checked-User"></i></span>
                                            <span class="ul-btn__text">Assign</span>
                                        </a>
                                        <a href="{{ route('admin.pending.project.details', ['id' => $datas->id, 'form' => 8]) }}" class="btn btn-info btn-icon btn-sm">
                                            <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                            <span class="ul-btn__text">View</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Author Name</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="editing-proofreading-brief" role="tabpanel" aria-labelledby="editing-proofreading-brief-tab">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered datatable-init" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Description</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proofreading_form as $datas)
                                <tr>
                                    <td>{{ $datas->id }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-dark">#{{ $datas->invoice->invoice_number }}</button>
                                    </td>
                                    <td>{{ ( $datas->description == null ? 'Not Given' : $datas->description ) }}</td>
                                    @if($datas->user != null)
                                    <td>{{ $datas->user->name }} {{ $datas->user->last_name }} <br>{{ $datas->user->email }} </td>
                                    @else
                                    <td>{{ $datas->client->name }} {{ $datas->client->last_name }} <br>{{ $datas->client->email }} </td>
                                    @endif
                                    <td>{{ $datas->invoice->sale->name }} {{ $datas->invoice->sale->last_name }}<br>{{ $datas->invoice->sale->email }}</td>
                                    <td><button class="btn btn-sm btn-primary">{{ $datas->invoice->brands->name }}</button></td>
                                    <td>{{ $datas->invoice->currency_show->sign }} {{ $datas->invoice->amount }}</td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-primary btn-icon btn-sm" onclick="assignAgent({{$datas->id}}, 9, {{ $datas->invoice->brands->id }})">
                                            <span class="ul-btn__icon"><i class="i-Checked-User"></i></span>
                                            <span class="ul-btn__text">Assign</span>
                                        </a>
                                        <a href="{{ route('admin.pending.project.details', ['id' => $datas->id, 'form' => 9]) }}" class="btn btn-info btn-icon btn-sm">
                                            <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                            <span class="ul-btn__text">View</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Description</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="cover-design-brief" role="tabpanel" aria-labelledby="cover-design-brief-tab">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered datatable-init" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Title</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookcover_form as $datas)
                                <tr>
                                    <td>{{ $datas->id }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-dark">#{{ $datas->invoice->invoice_number }}</button>
                                    </td>
                                    <td>{{ ( $datas->title == null ? 'Not Given' : $datas->title ) }}</td>
                                    @if($datas->user != null)
                                    <td>{{ $datas->user->name }} {{ $datas->user->last_name }} <br>{{ $datas->user->email }} </td>
                                    @else
                                    <td>{{ $datas->client->name }} {{ $datas->client->last_name }} <br>{{ $datas->client->email }} </td>
                                    @endif
                                    <td>{{ $datas->invoice->sale->name }} {{ $datas->invoice->sale->last_name }}<br>{{ $datas->invoice->sale->email }}</td>
                                    <td><button class="btn btn-sm btn-primary">{{ $datas->invoice->brands->name }}</button></td>
                                    <td>{{ $datas->invoice->currency_show->sign }} {{ $datas->invoice->amount }}</td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-primary btn-icon btn-sm" onclick="assignAgent({{$datas->id}}, 10, {{ $datas->invoice->brands->id }})">
                                            <span class="ul-btn__icon"><i class="i-Checked-User"></i></span>
                                            <span class="ul-btn__text">Assign</span>
                                        </a>
                                        <a href="{{ route('admin.pending.project.details', ['id' => $datas->id, 'form' => 10]) }}" class="btn btn-info btn-icon btn-sm">
                                            <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                            <span class="ul-btn__text">View</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Description</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>


                <div class="tab-pane fade" id="no-brief" role="tabpanel" aria-labelledby="no-brief-tab">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered datatable-init" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Name</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Account</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($no_form as $datas)
                                <tr>
                                    <td>{{ $datas->id }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-dark">#{{ $datas->invoice->invoice_number }}</button>
                                    </td>
                                    <td>{{ ( $datas->name == null ? 'Not Given' : $datas->name ) }}</td>
                                    @if($datas->user != null)
                                    <td>{{ $datas->user->name }} {{ $datas->user->last_name }} <br>{{ $datas->user->email }} </td>
                                    @else
                                    <td>{{ $datas->client->name }} {{ $datas->client->last_name }} <br>{{ $datas->client->email }} </td>
                                    @endif
                                    <td>{{ $datas->invoice->sale->name }} {{ $datas->invoice->sale->last_name }}<br>{{ $datas->invoice->sale->email }}</td>
                                    <td><button class="btn btn-sm btn-primary">{{ $datas->invoice->brands->name }}</button></td>
                                    <td>{{ $datas->invoice->currency_show->sign }} {{ $datas->invoice->amount }}</td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-primary btn-icon btn-sm" onclick="assignAgent({{$datas->id}}, 0, {{ $datas->invoice->brands->id }})">
                                            <span class="ul-btn__icon"><i class="i-Checked-User"></i></span>
                                            <span class="ul-btn__text">Assign</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice#</th>
                                    <th>Logo Name</th>
                                    <th>User Name</th>
                                    <th>Agent Name</th>
                                    <th>Brand</th>
                                    <th>Amount</th>
                                    <th>Account</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });

    var brand_id = 0;

    let htmlTag = new Promise((resolve) => {
        var url = "{{ route('admin.client.agent', ":id") }}";
        url = url.replace(':id', brand_id);
        setTimeout(() => {
            $.ajax({
                type:'GET',
                url: url,
                success:function(data) {
                    var getData = data.data;
                    htmlTag = '<select id="MySelect" class="form-control select2">';
                    for (var i = 0; i < getData.length; i++) {
                        htmlTag += '<option value="'+getData[i].id+'">'+getData[i].name+ ' ' +getData[i].last_name+'</option>'
                    }
                    htmlTag += '</select>';
                    resolve(htmlTag);
                }
            });
        }, 1000)
    })

    function assignAgent(id, form, brand_id){
        brand_id = brand_id;
        swal({
            title: 'Select Agent',
            html: htmlTag,
            showCancelButton: true,
            onOpen: function () {
                $('.select2').select2();
            },
            inputValidator: function (value) {
                return new Promise(function (resolve, reject) {
                    if (value !== '') {
                        resolve();
                    } else {
                        resolve('You need to select a Tier');
                    }
                });
            }
            }).then(function (result) {
                let agent_id = $('#MySelect option:selected').val();
                $.ajax({
                    type:'POST',
                    url: "{{ route('admin.assign.support') }}",
                    data: {id: id, agent_id:agent_id, form:form},
                    success:function(data) {
                        if(data.success == true){
                            swal("Agent Assigned", "Page will be loaded in order to reflect data", "success");
                            setTimeout(function () {
                                location.reload(true);
                            }, 3000);
                        }else{
                            return swal({
                                title:"Error",
                                text: "There is an Error, Plase Contact Administrator",
                                type:"danger"
                            })
                        }
                    }
                });
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        html: 'You selected: ' + result.value
                    });
                }
            });
    }

    $(document).ready(function(){
        if($('.datatable-init').length != 0){
            $('.datatable-init').DataTable({
                order: [[0, "desc"]],
                responsive: true,
            });
        }
    });
</script>
@endpush