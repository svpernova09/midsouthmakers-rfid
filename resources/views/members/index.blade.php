@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Members</div>
                    <div class="panel-body">
                        <div class="panel-body">
                            <a href="{{ url('/members/create') }}">
                                <button class="btn btn-primary">Create Member</button>
                            </a>
                            Changes made here are not immediately affected and may take an hour
                            to be reflected at the space.
                        </div>
                    <div class="table-responsive">
                        <table id="members" class="table table-striped">
                            <thead>
                            <tr>
                                <th>Key</th>
                                <th>IRC Name</th>
                                <th>Spoken Name</th>
                                <th>Admin</th>
                                <th>Active</th>
                                <th>Date Created</th>
                                <th>Last Login</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($members as $member)
                                @if($member->active)
                                    @if($member->admin)
                                        <tr class="success">
                                    @else
                                        <tr>
                                    @endif
                                @else
                                    <tr class="danger">
                                @endif


                                <td>{{ $member->key }}</td>
                                <td>{{ $member->irc_name }}</td>
                                <td>{{ $member->spoken_name }}</td>
                                <td>
                                    @if($member->admin)
                                        <span class="glyphicon glyphicon-ok"></span>
                                    @endif
                                </td>
                                <td>
                                    @if($member->active)
                                        <span class="glyphicon glyphicon-plus-sign"></span>
                                    @else
                                        <span class="glyphicon glyphicon-minus-sign"></span>
                                    @endif
                                </td>
                                <td>{{ $member->date_created }}</td>
                                <td>{{ $member->last_login }}</td>
                                <td>
                                    <a href="/members/{{ $member->id }}/edit">
                                        <button class="btn btn-default">
                                            <span class="glyphicon glyphicon-pencil"></span> Edit
                                        </button>
                                    </a>
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
<script type="application/javascript">
    $(document).ready(function() {
        $('#members').DataTable({
            paging: false
        });
    });
</script>
@endsection