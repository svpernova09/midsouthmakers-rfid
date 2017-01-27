@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Member {{ $member->spoken_name }}</div>
                    <div class="panel-body">
                    <div class="table-responsive">
                        <form method="POST" action="/members/{{ $member->id }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="irc_name">IRC/Nick Name</label>
                                <input type="text" class="form-control" name="irc_name" placeholder="IRC/Nick Name" value="{{ $member->irc_name }}">
                            </div>
                            <div class="form-group">
                                <label for="spoken_name">Name</label>
                                <input type="text" class="form-control" name="spoken_name" placeholder="Name" value="{{ $member->spoken_name }}">
                            </div>
                            <div class="checkbox">
                                Is Admin
                                @if($member->admin)
                                    <label class="radio-inline"><input type="radio" name="admin" value="1" checked="checked">Yes</label>
                                    <label class="radio-inline"><input type="radio" name="admin" value="0">No</label>
                                @else
                                    <label class="radio-inline"><input type="radio" name="admin" value="1">Yes</label>
                                    <label class="radio-inline"><input type="radio" name="admin" value="0" checked="checked">No</label>
                                @endif
                            </div>
                            <div class="checkbox">
                            Is Active
                                @if($member->active)
                                    <label class="radio-inline"><input type="radio" name="active" value="1" checked="checked">Yes</label>
                                    <label class="radio-inline"><input type="radio" name="active" value="0">No</label>
                                @else
                                    <label class="radio-inline"><input type="radio" name="active" value="1">Yes</label>
                                    <label class="radio-inline"><input type="radio" name="active" value="0" checked="checked">No</label>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
