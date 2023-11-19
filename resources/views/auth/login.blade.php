<x-guest-layout>

    <!-- [ auth-signin ] start -->
    <div class="auth-wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="row align-items-center text-center">
                    <div class="col-md-12">
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                {{-- <img src="{{ asset('images/logo-dark.png') }}" alt="" class="img-fluid mb-4"> --}}
                                <h5 class="mb-3 f-w-900 text-primary">WASPS RATS</h5>
                                
                                <h4 class="mb-3 f-w-400">Signin</h4>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="feather icon-mail"></i></span>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email address">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="input-group mb-4">
                                    <span class="input-group-text"><i class="feather icon-lock"></i></span>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-group text-left mt-2">
                                    <div class="checkbox checkbox-primary d-inline">
                                        <input type="checkbox" name="remember" id="remember">
                                        <label for="remember" class="cr"> Remember me</label>
                                    </div>
                                </div>
                                <button class="btn btn-block btn-primary mt-2 mb-4">Signin</button>
                            </form>

                            <div class="text-center">
                                <div class="saprator my-4"><span>OR</span></div>
                                <button class="btn text-white bg-facebook mb-2 me-2  wid-40 px-0 hei-40 rounded-circle"><i class="fab fa-facebook-f"></i></button>
                                <button class="btn text-white bg-googleplus mb-2 me-2 wid-40 px-0 hei-40 rounded-circle"><i class="fab fa-google-plus-g"></i></button>
                                <button class="btn text-white bg-twitter mb-2  wid-40 px-0 hei-40 rounded-circle"><i class="fab fa-twitter"></i></button>
                                <p class="mb-2 mt-4 text-muted">Forgot password? <a href="{{ route('password.request') }}" class="f-w-400">Reset</a></p>
                                <p class="mb-0 text-muted">Don’t have an account? <a href="{{ route('register') }}" class="f-w-400">Signup</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ auth-signin ] end -->
</x-guest-layout>
