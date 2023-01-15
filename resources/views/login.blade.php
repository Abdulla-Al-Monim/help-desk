

@extends('layouts.custommaster')


@section('content')
    <!--Login Page-->
    <div class="pb-3 px-5 pt-3">
        <h1 class="mb-2">Login</h1>
        <p class="text-muted  mb-0">Sign In to your account</p>
    </div>

    <form class="card-body border-top-0 pt-3" id="login" method="POST" action="{{ route('login') }}">
        @csrf
       
        <div class="form-group">
            <label class="form-label">Email <span class="text-red">*</span></label>
            <input class="form-control  @error('email') is-invalid @enderror" placeholder="Email" type="email"
                value="{{old('email')}}" name="email" autocomplete="username">
            @error('email')

            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

        </div>
        <div class="form-group">
            <label class="form-label">Password<span class="text-red">*</span></label>
            <input class="form-control  @error('password') is-invalid @enderror" placeholder="password" type="password" name="password" autocomplete="current-password">
            @error('password')

            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

        </div>
        <div class="form-group">
            <label class="custom-control form-checkbox">
                <input type="checkbox" class="custom-control-input" name="remember" id="remember">
                <span class="custom-control-label">Remember me</span>
            </label>
        </div>
       

            
            
        <div class="submit">
            <input class="btn btn-secondary btn-block" type="submit" value="Login" style="background: #184780!important;">
        </div>
       
       
    </form>
    <!--Login Page-->
                            
@endsection

@section('scripts')

        <!--INTERNAL Owl-carousel js -->
        <script src="{{asset('assets/plugins/owl-carousel/owl-carousel.js')}}?v=<?php echo time(); ?>"></script>

        <!-- INTERNAL Index js-->
        <script src="{{asset('assets/js/support/support-landing.js')}}?v=<?php echo time(); ?>"></script>

        <!-- INTERNAL Index js-->
        <script src="{{asset('assets/plugins/jquery/jquery-ui.js')}}?v=<?php echo time(); ?>"></script>


@endsection

