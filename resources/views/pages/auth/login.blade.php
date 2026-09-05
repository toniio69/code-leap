<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="bg-background text-foreground antialiased">
        <section class="from-background to-muted/50 relative isolate flex min-h-dvh w-full items-center justify-center overflow-hidden bg-linear-to-br">
            <div class="relative z-10 container mx-auto flex min-h-dvh items-center justify-center px-4 py-12">
                <div class="relative w-full max-w-md p-8 shadow-2xl rounded-lg border bg-card text-card-foreground">
                    <div class="mb-8 flex flex-col items-center">
                        <div class="my-4 flex justify-center">
                            <div class="bg-secondary relative size-14 rounded-full border">
                                <div class="flex h-full items-center justify-center">
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M26 24.75C26.4142 24.75 26.75 24.4142 26.75 24C26.75 23.5858 26.4142 23.25 26 23.25V24.75ZM26 23.25H11V24.75H26V23.25ZM8.75 21V15H7.25V21H8.75ZM11 23.25C9.75736 23.25 8.75 22.2426 8.75 21H7.25C7.25 23.0711 8.92893 24.75 11 24.75V23.25Z" fill="currentColor"/>
                                        <path d="M1.5 3.25C1.08579 3.25 0.75 3.58579 0.75 4C0.75 4.41421 1.08579 4.75 1.5 4.75V3.25ZM1.5 4.75H6V3.25H1.5V4.75ZM7.25 6V21H8.75V6H7.25ZM6 4.75C6.69036 4.75 7.25 5.30964 7.25 6H8.75C8.75 4.48122 7.51878 3.25 6 3.25V4.75Z" fill="currentColor"/>
                                        <path d="M22 21.75C22.4142 21.75 22.75 21.4142 22.75 21C22.75 20.5858 22.4142 20.25 22 20.25V21.75ZM22 20.25H11V21.75H22V20.25ZM8.75 18V12H7.25V18H8.75ZM11 20.25C9.75736 20.25 8.75 19.2426 8.75 18H7.25C7.25 20.0711 8.92893 21.75 11 21.75V20.25Z" fill="currentColor"/>
                                        <path d="M27.2057 19.754C27.0654 20.1438 26.6357 20.346 26.246 20.2057C25.8562 20.0654 25.654 19.6357 25.7943 19.246L27.2057 19.754ZM30.0361 9.67744L29.3305 9.4234L29.3305 9.4234L30.0361 9.67744ZM25.7943 19.246L29.3305 9.4234L30.7418 9.93148L27.2057 19.754L25.7943 19.246ZM28.1543 7.75L8 7.75V6.25L28.1543 6.25V7.75ZM29.3305 9.4234C29.6237 8.60882 29.0201 7.75 28.1543 7.75V6.25C30.059 6.25 31.3869 8.13941 30.7418 9.93148L29.3305 9.4234Z" fill="currentColor"/>
                                        <path d="M13.5 21.75C13.0858 21.75 12.75 21.4142 12.75 21C12.75 20.5858 13.0858 20.25 13.5 20.25V21.75ZM26.7111 19.009L27.4174 19.2613L27.4174 19.2613L26.7111 19.009ZM13.5 20.25H23.8858V21.75H13.5V20.25ZM26.0048 18.7568L27.7937 13.7477L29.2063 14.2523L27.4174 19.2613L26.0048 18.7568ZM23.8858 20.25C24.8367 20.25 25.6849 19.6522 26.0048 18.7568L27.4174 19.2613C26.8843 20.7537 25.4706 21.75 23.8858 21.75V20.25Z" fill="currentColor"/>
                                        <path d="M21.1694 10.5806L14.5651 17.1849" stroke="currentColor"/>
                                        <path d="M22.1694 14.5806L18.5632 18.1868" stroke="currentColor"/>
                                        <circle cx="13.1" cy="26.1" r="1.7" stroke="currentColor"/>
                                        <circle cx="22.1" cy="26.1" r="1.7" stroke="currentColor"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <h1 class="mb-2 text-center text-2xl font-bold tracking-tight">Welcome Back!</h1>
                        <p class="text-muted-foreground text-center text-sm">Sign in to continue your journey</p>
                    </div>

                    <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
                        @csrf

                        <div class="flex flex-col gap-4">
                            <div class="relative">
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="email"
                                    placeholder="me@example.com"
                                    class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 ps-10 text-sm shadow-sm transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                                >
                                <svg class="text-muted-foreground absolute start-3 top-1/2 size-5 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </div>

                            <div class="relative">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="Password"
                                    class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 ps-10 text-sm shadow-sm transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring"
                                >
                                <svg class="text-muted-foreground absolute start-3 top-1/2 size-5 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                                <button
                                    type="button"
                                    class="absolute end-0 top-0 h-full cursor-pointer px-3 py-2 hover:bg-transparent"
                                    onclick="this.parentElement.querySelector('input').type = this.parentElement.querySelector('input').type === 'password' ? 'text' : 'password'"
                                >
                                    <svg class="text-muted-foreground eye-open hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <svg class="text-muted-foreground eye-closed" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                        <line x1="1" y1="1" x2="23" y2="23"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <label class="group relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-[4px] border border-input transition-colors duration-150 ease-[cubic-bezier(0.22,1,0.36,1)] has-disabled:opacity-50 peer-disabled:cursor-not-allowed">
                                    <input
                                        id="remember"
                                        name="remember"
                                        type="checkbox"
                                        {{ old('remember') ? 'checked' : '' }}
                                        class="peer sr-only"
                                    >
                                    <svg viewBox="0 0 10.1668 10.1668" class="size-2.5 text-current opacity-0 transition-opacity duration-150 peer-checked:opacity-100" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 5.52L3.92 9.17L9.17 1" class="transition-[stroke-dashoffset] duration-150 ease-[cubic-bezier(0.22,1,0.36,1)]" style="stroke-dasharray: 15; stroke-dashoffset: 15;" />
                                    </svg>
                                    <style>
                                        input:checked + svg { stroke-dashoffset: 0; }
                                        input:checked ~ * { background-color: var(--color-primary); border-color: var(--color-primary); color: var(--color-primary-foreground); }
                                        label:hover:not(:has(input:disabled)) { background-color: var(--color-accent); }
                                    </style>
                                </label>
                                <label for="remember" class="text-sm leading-none font-normal text-muted-foreground peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                    Remember me
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="ms-auto inline-block text-sm underline-offset-4 hover:underline">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="inline-flex h-9 w-full cursor-pointer items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                            Sign In
                        </button>

                        @if (Route::has('socialite.redirect'))
                            <div class="relative my-6 text-center">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t"></div>
                                </div>
                                <div class="relative flex justify-center text-xs uppercase">
                                    <span class="bg-card text-muted-foreground px-2">Or continue with</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-3">
                                <a href="{{ route('socialite.redirect', 'google') }}" class="inline-flex h-9 w-full cursor-pointer items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                    </svg>
                                    <span class="ml-2">Continue with Google</span>
                                </a>
                            </div>
                        @endif
                    </form>

                    <p class="mt-6 flex justify-center gap-1 text-center text-sm">
                        <span>Don't have an account?</span>
                        <a href="{{ route('register') }}" class="underline underline-offset-4">
                            Create an account
                        </a>
                    </p>
                </div>
            </div>
        </section>

        <script>
            document.querySelectorAll('[id="password"]').forEach(function(input) {
                var btn = input.parentElement.querySelector('button');
                if (!btn) return;
                btn.addEventListener('click', function() {
                    var isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';
                    btn.querySelector('.eye-open').classList.toggle('hidden', !isPassword);
                    btn.querySelector('.eye-closed').classList.toggle('hidden', isPassword);
                });
            });
        </script>
    </body>
</html>
