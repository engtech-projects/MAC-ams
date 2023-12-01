@extends('layouts.app')
@section('content')
<section class="content" id="app">
    <div class="hold-transition login-page">
        <div class="login-box">

            <!-- /.login-logo -->
            <div class="card card-outline">
                <div class="card-header text-center">
                    <div class="col-md-12">
                        <img src="{{ asset('img/mac_logo.fw.png') }}" alt="mac_logo" class="img img-responsive">
                    </div>
                </div>
                <div class="card-body">
                    <p class="login-box-msg" style="font-size: 1.5rem;"><b>Login</b></p>

                    <form method="POST" id="handlelogin" action="{{ route('login.user') }}">
                        @csrf
                        @if (Session::has('success'))
                            <div class="callout callout-danger">
                                <h5>Something Went Wrong!</h5>

                                <p>{{ Session::get('success') }}</p>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="username" style="font-weight: normal;">Username</label>
                            <input type="text" id="username" class="form-control" id="username" name="username"
                                required autofocus>
                            @if ($errors->has('username'))
                                <span class="text-danger">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password" style="font-weight: normal;">Password</label>
                            <input type="password" id="password" class="form-control" id="password" name="password"
                                required>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="branch_id">
                                <option value="" selected disabled>Select Branch</option>
                                <option v-for="(item,i) in branches" value="item.branch_id">@{{ item.branch_name }}</option>
                            </select>

                        </div>
                        <div class="row">

                            <div class="col-4">
                                <button type="submit" class="btn bg-gradient-primary btn-flat btn-block">Sign
                                    In</button>
                            </div>
                        </div>
                    </form>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.login-box -->

    </div>

</section>
<script>
    new Vue({
        el: '#app',
        data: {
            branches: null,
            baseUrl: window.location.protocol + "//" + window.location.host+"/MAC-ams"

        },
        methods: {
            async getBranchList() {
                axios.get(this.baseUrl+'/branch').then((response) => {
                    this.branches = response.data.data
                    console.log(response.data.data);
                }).catch((err) => {
                    console.error(err);
                });
            }
        },
        mounted() {
            this.getBranchList()
        },
    });
</script>
@endsection

