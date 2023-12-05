@extends('layouts.app')
@section('content')
    <section class="content" id="app">
        <div class="hold-transition">
            <div class="login-box">
                <!-- /.login-logo -->
                <div class="card card-outline">
                    <div class="card-header text-center">
                        <div class="col-md-12">
                            <img src="{{ asset('img/mac_logo.fw.png') }}" alt="mac_logo" class="img img-responsive">
                        </div>
                    </div>
                    <div class="card-body">
                        @{{ defaultSelected }}
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                <h6><i class="icon fas fa-check-circle"></i>{{ Session::get('success') }}</h6>
                            </div>
                        @endif
                        <div v-if="responseMessage">
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                <h6><i class="icon fas fa-ban"></i>@{{ responseMessage.message }}</h6>

                                <ul v-if="responseMessage?.errors">
                                    <li v-for="item in responseMessage.errors">@{{ item[0] }}</li>
                                </ul>

                            </div>
                        </div>
                        @csrf
                        <form @submit.prevent="login">
                            <div class="form-group">
                                <label for="username" style="font-weight: normal;">Username</label>
                                <input type="text" id="username" v-model="credentials.username" class="form-control"
                                    id="username" name="username" required autofocus>

                            </div>
                            <div class="form-group">
                                <label for="password" style="font-weight: normal;">Password</label>
                                <input type="password" id="password" v-model="credentials.password" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <select required class="form-control" :change="credentials.branch_id"
                                    v-model="credentials.branch_id">
                                    <option value="" disabled selected>@{{ defaultSelected }}
                                    </option>
                                    <option v-for="item in branches" v-bind:value="item.branch_id">
                                        @{{ item.branch_name }}
                                    </option>
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
                defaultSelect: "Select Branch",
                setDefaultSelect: true,
                credentials: {
                    username: "",
                    password: "",
                    branch_id: "",
                },
                responseMessage: null,
                baseUrl: window.location.protocol + "//" + window.location.host + "/MAC-ams"

            },
            computed: {
                defaultSelected: function() {
                    return this.defaultSelect
                }
            },
            methods: {
                async getBranchList() {
                    axios.get(this.baseUrl + '/branch').then((response) => {
                        this.branches = response.data.data
                    }).catch((err) => {
                        console.error(err);
                    });
                },
                clearForm() {
                    this.credentials = {
                        username: "",
                        password: "",
                        branch_id: ""
                    }
                },
                selectBranch(e) {
                    this.credentials.branch_id = e.target.value
                },

                async login() {
                    console.log(this.credentials.branch_id)
                    var Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    var result = null;
                    axios.post(this.baseUrl + '/authenticate', this.credentials, {
                        headers: {
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    }).then((response) => {
                        result = response
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message
                        });
                    }).catch((err) => {
                        this.credentials.branch_id = ""
                        result = err.response
                    }).finally(() => {
                        if (result.status === 200) {
                            location.assign(this.baseUrl + '/dashboard');
                        } else if (result.status >= 401) {
                            this.responseMessage = result.data
                            Toast.fire({
                                icon: 'error',
                                title: "Something went wrong."
                            });
                            this.credentials.branch_id = this.defaultSelect
                            this.clearForm()
                        }
                    })


                }
            },
            mounted() {
                this.getBranchList()
            },
        });
    </script>
@endsection
