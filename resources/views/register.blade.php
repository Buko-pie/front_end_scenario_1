@extends('layouts.emailVerif')

@section('content')
<div id="register" class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div v-show="!confirmation_sent" class="card">
                <div class="card-header bg-deep_pruple text-light"><span class="font-weight-bold">{{ __('Register') }}</span></div>

                <div class="card-body">
                    <form id="register_form" @submit="send_register_form" method="post">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input v-model="name" ref="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="test_admin" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input v-model="email" ref="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="test_admin@email.com" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input v-model="password" ref="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="123" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input v-model="password_confirm" ref="password-confirm" type="password" class="form-control" name="password_confirmation" value="test_admin" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button class="btn btn-violet" class="btn_register">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- confirmation_sent --}}
            <div v-show="confirmation_sent" class="card"> 
                <div class="card-body justify-content-center text-center ">
                    <h2 class="font-weight-bold">Verify Email</h2>
                    <img src="{{ url('/images/email.png') }}" alt="" class="w-8 mx-auto rounded mx-auto d-block">
                    <p class="font-weight-bold">A verification email has been sent</p>
                    <p>Please click on the link in the email sent <span class="font-weight-bold">@{{ email }}</span></p>
                    <hr>
                    <p>For imporved security, your verification link will expire after 6 hours. If it has expired, you will be directed to this page where you can resend email.</p>
                    <input v-model="email_code" ref="email_code" class="form-control form-control-lg text-center text-purple w-50 mx-auto spaced" type="text" placeholder="# # # #" maxlength="4">
                    <div class="d-flex justify-content-center p-4">
                        <button @click="send_register_form" class="btn btn-violet-outline ml-auto mr-2 px-4 pill font-weight-bold">Resend Now</button>
                        <button @click="submit_verification_code" class="btn btn-violet mr-auto ml-2 px-4 pill font-weight-bold">Submit Code</button>
                    </div>
                    <br>
                    <p>Not your correct address? Update your email adress Here</p>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    var register = new Vue({
        el: "#register",
        data:{
            confirmation_sent: false,
            name: "",
            email: "",
            password: "",
            password_confirm: "",
            email_code: ""
        },
        methods: {
            toggle:function(){
                this.confirmation_sent = !this.confirmation_sent;
                console.log(this.confirmation_sent)
            },
            send_register_form:function(e){
                e.preventDefault();
                var _this = this;

                if(this.name && this.email && this.password && this.password_confirm){
                    if(this.password === this.password_confirm){
                        axios({
                            method: "POST",
                            url: "{{ route('register_from_send') }}",
                            headers: {
                                "Content-Type": "application/json",
                                "Authorization": "Bearer {{ csrf_token() }}"
                            },
                            data: {
                                name: this.name,
                                email: this.email,
                                password: this.password,
                                password_confirm: this.password_confirm
                            }
                        }).then(function (response) {
                            console.log(response.data);
                            _this.confirmation_sent = true;
                        }).catch(error => {
                            swal("Something_went_wrong", error.response.data.message, "warning");
                        }).then(function (response) {
                        });
                    }else{
                        swal("Passwords do not match!", "", "warning");
                    }
                }
            },
            submit_verification_code:function(e){
                var _this = this;
                console.log(this.email_code)
                if(this.email_code){
                    axios({
                        method: "POST",
                        url: "{{ route('submit_email_code') }}",
                        headers: {
                            "Content-Type": "application/json",
                            "Authorization": "Bearer {{ csrf_token() }}"
                        },
                        data: {
                            email_code: this.email_code,
                        }
                    }).then(function (response) {
                        swal("Email code matched and received", '', "success");
                    }).catch(error => {
                        swal("Something_went_wrong", error.response.data.message, "warning");
                    }).then(function (response) {
                    });
                }
            }
        }
    });

</script>
@endsection