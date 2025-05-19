<x-guest-layout>
    <div class="page page-center">
        <div class="container container-tight">




            <div class="card card-md login-card">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Masuk ke Akun</h2>

                    <!-- Status Session -->
                    <x-auth-session-status class="alert alert-success mb-3" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <div class="input-group input-group-flat">
                                <input type="email" name="email" class="form-control" placeholder="contoh@email.com"
                                    value="{{ old('email') }}" required autofocus>
                                <span class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-mail-forward">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 18h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5" />
                                        <path d="M3 6l9 6l9 -6" />
                                        <path d="M15 18h6" />
                                        <path d="M18 15l3 3l-3 3" />
                                    </svg>
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="text-danger mt-1" />
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="form-label">Kata Sandi</label>
                            <div class="input-group input-group-flat">
                                <input type="password" name="password" class="form-control"
                                    placeholder="Kata sandi Anda" required>
                                <span class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-key">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" />
                                        <path d="M15 9h.01" />
                                    </svg>
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="text-danger mt-1" />
                        </div>

                        {{-- Remember Me --}}
                        <div class="mb-3">
                            <label class="form-check">
                                <input type="checkbox" class="form-check-input" name="remember">
                                <span class="form-check-label">Ingat saya</span>
                            </label>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100" id="loginButton">
                                <span class="button-text">Masuk</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>




                </div>
            </div>
        </div>
    </div>


</x-guest-layout>
