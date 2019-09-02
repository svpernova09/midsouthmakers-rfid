@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Log Viewer</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
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
                            {{ $log_entries->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
