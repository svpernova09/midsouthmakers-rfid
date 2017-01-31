@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    @if(count(Auth::user()->members()) > 0)
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
                                @foreach(Auth::user()->members as $member)
                                    <tr>
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
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                    @endif
                </div>
                <div class="panel-body">
                    @if(Auth::user()->admin)
                    <passport-personal-access-tokens></passport-personal-access-tokens>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
