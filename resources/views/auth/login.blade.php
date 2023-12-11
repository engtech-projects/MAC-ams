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
                        <div v-if="responseMessage?.errors">
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                <h6><i class="icon fas fa-ban"></i>@{{ responseMessage.message }}</h6>

                                <ul v-if="responseMessage?.errors">
                                    <li v-for="item in responseMessage.errors">@{{ item[0] }}</li>
                                </ul>

                            </div>
                        </div>
                        <form @submit.prevent="login">
                            @csrf
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

            },
            computed: {
                defaultSelected: function() {
                    return this.defaultSelect
                }
            },
            methods: {
                async getBranchList() {
                    axios.get('/MAC-ams/branch').then((response) => {
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
                    var Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    var result = null;
                    axios.post('/MAC-ams/authenticate', this.credentials, {
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
                            location.assign('/MAC-ams/dashboard');
                        } else if (result.status >= 401) {
                            this.responseMessage = result.data
                            console.log(result.data.message)
                            Toast.fire({
                                icon: 'error',
                                title:  result.data.message
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
