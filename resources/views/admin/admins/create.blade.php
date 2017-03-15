@extends('admin/layout')

@section('styles')
    <link href="{{url('css/style.css')}}" rel="stylesheet" />
@stop

@section('content')

    <div class="col-md-10  ">

                <div class="row">
                    @include('partials._form-errors')
                    <div class="col-xs-10">
                        <div class="form-wrap">
                            <h1>Create new Admin</h1>
                            <form role="form" action="{{ action('AdminsController@store') }}" method="post" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="username" class="sr-only">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="{{ $user->username  }}">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ $user->email  }}">
                                </div>

                                <div class="form-group">

                                    <label for="role" class="sr-only">Role</label>
                                        <select name="role" class="form-control input-large  " >";
                                            <option  >Choose role</option>
                                            <option value="1">super user</option>
                                            <option value="2">content authority</option>
                                            <option value="3">financial</option>
                                            <option value="4">meeting calendar</option>
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="form-inline ">Thumbnail</label>
                                <input type="file" id="thumbnail" name="thumbnail">
                                </div>

                                <div class="form-group">
                                <input type="text" name="last_login_date" id="last_login_date" class="form-control" placeholder="last_login_date" value="{{ \Carbon\Carbon::now() }}" >
                                </div>

                                <div class="form-group">
                                    <label for="first_name" class="sr-only">First name</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First name"  >
                                </div>

                                <div class="form-group">
                                    <label for="last_name" class="sr-only">Last name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last name"  >
                                </div>

                                <div class="form-group">
                                    <label for="mobile_number" class="sr-only">Mobile number</label>
                                    <input type="text" name="mobile_number" id="mobile_number" class="form-control" placeholder="Mobile number"  >
                                </div>

                                <div class="form-group">
                                    <label for="profile_path" class="sr-only">Profile path</label>
                                    <input type="text" name="profile_path" id="profile_path" class="form-control" placeholder="Profile path"  >
                                </div>

                                <div class="form-group">

                                    <label for="gender" class="sr-only">Gender</label>
                                    <select name="gender" class="form-control input-large  " >";
                                        <option value="" >Choose Gender</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                    </select>
                                </div>

                                <input type="submit"   class="btn btn-custom btn-lg btn-block" value="Create">
                            </form>

                            <hr>
                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->








    </div>

@stop

@section('javascripts')


@stop
