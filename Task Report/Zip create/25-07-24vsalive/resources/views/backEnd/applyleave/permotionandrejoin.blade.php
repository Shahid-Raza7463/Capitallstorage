<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Permotion and Rejoining</h1>
                    <small>Permotion and Rejoining</small>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">

    </div>
    <!--/.Content Header (Page header)-->
    <div class="body-content">
        <div class="card mb-4">
            <div class="card-body">
                @if (session()->has('statuss'))
                    <div class="alert alert-danger" style="display: ruby-text;">
                        <i class="fas fa-exclamation-triangle"></i>
                        @if (is_array(session()->get('statuss')))
                            @foreach (session()->get('statuss') as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                        @else
                            <p>{{ session()->get('statuss') }}</p>
                        @endif
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class="alert alert-success" style="display: ruby-text;">
                        <i class="fas fa-check-circle"></i>
                        @if (is_array(session()->get('success')))
                            @foreach (session()->get('success') as $message)
                                <p>{!! $message !!}</p>
                            @endforeach
                        @else
                            <p>{{ session()->get('success') }}</p>
                        @endif
                    </div>
                @endif

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                            aria-controls="pills-home" aria-selected="true">Promotion Details</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                            aria-controls="pills-user" aria-selected="false">Rejoining Details</a>
                    </li>
                </ul>

                <br>
                <hr>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <form method="post" action="{{ url('permotionandrejoinstore') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row row-sm mt-3" style="margin: 14px;">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Employee Name</label>
                                        <select required class="language form-control" name="employeeid">
                                            <option value="">Please Select One</option>
                                            @php
                                                $displayedValues = [];
                                            @endphp
                                            @foreach ($teammembers as $teammember)
                                                @if (!in_array($teammember->staffcode, $displayedValues))
                                                    {{-- <option value="{{ $teammember->id }}"> --}}
                                                    <option value="{{ $teammember->id }}"
                                                        {{ old('teammemberId') == $teammember->id ? 'selected' : '' }}>
                                                        {{ $teammember->team_member }} (
                                                        {{ $teammember->newstaff_code ?? ($teammember->staffcode ?? '') }})
                                                    </option>
                                                    @php
                                                        $displayedValues[] = $teammember->staffcode;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Promotion Date</label>
                                        <input required type="date" name="promotion_date" value=""
                                            class="form-control" placeholder="Enter Promotion Date">
                                        {{-- {{ $teammember->joining_date ?? '' }} --}}
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="font-weight-600">Designation</label>
                                        <select required class="language form-control" name="designationtype">
                                            <option value="">Please Select One</option>
                                            @foreach ($teamroles as $teamrole)
                                                <option value="{{ $teamrole->id }}">
                                                    {{ $teamrole->rolename }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="row row-sm mt-3" style="margin: 14px;">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                                        <a class="btn btn-secondary" href="{{ url('home') }}">
                                            Back</a>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                        <div class="table-responsive">
                            <form method="post" action="{{ url('rejoinstore') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row row-sm" style="margin: 14px;">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Employee Name</label>
                                            <select required class="language form-control" name="employeeid">
                                                <option value="">Please Select One</option>
                                                @php
                                                    $displayedValues = [];
                                                @endphp
                                                @foreach ($inactiveteammembers as $teammember)
                                                    @if (!in_array($teammember->staffcode, $displayedValues))
                                                        <option value="{{ $teammember->id }}"
                                                            {{ old('teammemberId') == $teammember->id ? 'selected' : '' }}>
                                                            {{ $teammember->team_member }} (
                                                            {{ $teammember->newstaff_code ?? ($teammember->staffcode ?? '') }})
                                                        </option>
                                                        @php
                                                            $displayedValues[] = $teammember->staffcode;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Rejoining Date</label>
                                            <input required type="date" name="rejoining_date" value=""
                                                class="form-control" placeholder="Enter Rejoining Date">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="font-weight-600">Designation</label>
                                            <input type="checkbox" id="enableDesignation" style="margin-left: 10px;"
                                                title="You want to change designation then please click on check box">
                                            <select required class="language form-control" name="designationtype"
                                                id="designationSelect" disabled>
                                                <option value="">Please Select One</option>
                                                @foreach ($teamroles as $teamrole)
                                                    <option value="{{ $teamrole->id }}">
                                                        {{ $teamrole->rolename }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-sm mt-3" style="margin: 14px;">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success"
                                                style="float:right">Submit</button>
                                            <a class="btn btn-secondary" href="{{ url('home') }}">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#enableDesignation').on('change', function() {
            $('#designationSelect').prop('disabled', !this.checked);
        });
    });
</script>
