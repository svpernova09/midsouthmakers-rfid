@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Members</div>
                    <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Key</th>
                                <th>IRC Name</th>
                                <th>Spoken Name</th>
                                <th>Admin</th>
                                <th>Active</th>
                                <th>Date Created</th>
                                <th>Last Login</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($members as $member)
                            <tr>
                                <td>{{ $member->key }}</td>
                                <td>{{ $member->ircName }}</td>
                                <td>{{ $member->spokenName }}</td>
                                <td>
                                    @if($member->isAdmin)
                                        <span class="glyphicon glyphicon-ok"></span>
                                    @endif
                                </td>
                                <td>
                                    @if($member->isActive)
                                        <span class="glyphicon glyphicon-plus-sign"></span>
                                    @else
                                        <span class="glyphicon glyphicon-minus-sign"></span>
                                    @endif
                                </td>
                                <td>{{ $member->dateCreated }}</td>
                                <td>{{ $member->lastLogin }}</td>
                                <td>
                                    <a href="/members/{{ $member->key }}/edit">
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
