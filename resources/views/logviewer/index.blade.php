@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Log Viewer</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="logviewer" class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Key</th>
                                    <th>IRC Name</th>
                                    <th>Spoken Name</th>
                                    <th>Result</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($log_entries as $log)
                                    @if($log->result == 'success')
                                        <tr class="table-success">
                                    @else
                                        <tr class="table-danger">
                                            @endif
                                            <td>{{ $log->timestamp }}</td>
                                            <td>{{ $log->member->key }}</td>
                                            <td>{{ $log->member->irc_name }}</td>
                                            <td>{{ $log->member->spoken_name }}</td>
                                            <td>
                                                @if($log->result == 'success')
                                                    <i class="fas fa-plus"></i>
                                                @else
                                                    <i class="fas fa-minus"></i>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/mobius1/vanilla-Datatables@latest/vanilla-dataTables.min.css">

    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/mobius1/vanilla-Datatables@latest/vanilla-dataTables.min.js"></script>
    <script type="application/javascript">
        window.onload = function () {
            var dataTable = new DataTable("#logviewer", {
                searchable: true
            });
        }
    </script>
@endsection
