@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Upload PayPal Report CSV</div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <form method="POST" action="{{ route('finance.post-upload') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="report">PayPal Report CSV</label>
                                    <input type="file" class="form-control-file" name="report" id="report">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
