@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            @if (Auth::user()->role_id == 11)
                <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('article/create', $id) }}">Add Knowledge</a></li>
                    <li class="breadcrumb-item active">+</li>
                </ol>
            @endif
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Knowledgebase List</small>
                </div>
            </div>
        </div>
    </div>
    <!--/.Content Header (Page header)-->
    <div class="body-content">

        <div class="card mb-4">
            @component('backEnd.components.alert')
            @endcomponent
            <div class="card-body">
                <div class="table-responsive">
                         <table id="examplee" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Related To</th>
                                <th>File</th>
                                <th>Date</th>
                                <th>Show</th>
                                {{-- <th>Created by</th>
                                <th>Edit</th>
                                <th>Delete</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articleDatas as $articleData)
                                <tr>
                                    <td>
                                        <a target="blank" href="{{ asset('backEnd/image/article/' . $articleData->file) }}">
                                            {{ $articleData->subject }}
                                        </a>
                                    </td>
                                    <td>{{ $articleData->name }}</td>
                                    <td>{{ $articleData->file }}</td>
                                    <td>{{ date('d-M-Y', strtotime($articleData->created_at)) }}</td>
                                    <td>
                                        <a href="{{ url('/article-view', $articleData->id) }}"
                                            class="btn btn-success-soft btn-sm">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    </td>
                                    {{-- 
                                    <td>{{ $articleData->team_member }}</td>
                                    <td> <a href="{{ route('article.edit', $articleData->id) }}"
                                            class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a></td>
                                    <a href="http://kgsomani.test/clientdocument/destroy/48"
                                        onclick="return confirm('Are you sure you want to delete this item?');"></a>
                                    <td>
                                        <form action="{{ route('article.destroy', $articleData->id) }}" method="POST">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button onclick="return confirm('Are you sure you want to delete this item?');"
                                                class="btn btn-danger-soft btn-sm"><i class="far fa-trash-alt"></i></button>
                                        </form>
                                    </td> --}}

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div><!--/.body content-->
@endsection


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "order": [
                // [2, "desc"]
            ],
            //   searching: false,
            columnDefs: [{
                targets: [0, 1, 2],
                orderable: false
            }],
            buttons: []
        });
    });
</script>
