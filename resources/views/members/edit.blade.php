@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Member {{ $member->spokenName }}</div>
                    <div class="panel-body">
                    <div class="table-responsive">
                        <form method="POST" action="/members/{{ $member->key }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="key">Key</label>
                                <input type="text" class="form-control" name="key" placeholder="Key" value="{{ $member->key }}">
                            </div>
                            <div class="form-group">
                                <label for="ircName">IRC/Nick Name</label>
                                <input type="text" class="form-control" name="ircName" placeholder="IRC/Nick Name" value="{{ $member->ircName }}">
                            </div>
                            <div class="form-group">
                                <label for="spokenName">Name</label>
                                <input type="text" class="form-control" name="spokenName" placeholder="Name" value="{{ $member->spokenName }}">
                            </div>
                            <div class="checkbox">
                                Is Admin
                                @if($member->isAdmin)
                                    <label class="radio-inline"><input type="radio" name="isAdmin" value="1" checked="checked">Yes</label>
                                    <label class="radio-inline"><input type="radio" name="isAdmin" value="0">No</label>
                                @else
                                    <label class="radio-inline"><input type="radio" name="isAdmin" value="1">Yes</label>
                                    <label class="radio-inline"><input type="radio" name="isAdmin" value="0" checked="checked">No</label>
                                @endif
                            </div>
                            <div class="checkbox">
                            Is Active
                                @if($member->isActive)
                                    <label class="radio-inline"><input type="radio" name="isActive" value="1" checked="checked">Yes</label>
                                    <label class="radio-inline"><input type="radio" name="isActive" value="0">No</label>
                                @else
                                    <label class="radio-inline"><input type="radio" name="isActive" value="1">Yes</label>
                                    <label class="radio-inline"><input type="radio" name="isActive" value="0" checked="checked">No</label>
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
