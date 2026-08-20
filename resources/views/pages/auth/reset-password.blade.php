<x-layouts::auth :title="__('Reset password')">
    <div class="flex flex-col gap-6">
        <div class="flex flex-col items-center gap-2 text-center">
            <div class="bg-gray-100 dark:bg-gray-800 relative size-14 rounded-full border border-gray-200 dark:border-gray-700 flex items-center justify-center mb-2">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M26 24.75C26.4142 24.75 26.75 24.4142 26.75 24C26.75 23.5858 26.4142 23.25 26 23.25V24.75ZM26 23.25H11V24.75H26V23.25ZM8.75 21V15H7.25V21H8.75ZM11 23.25C9.75736 23.25 8.75 22.2426 8.75 21H7.25C7.25 23.0711 8.92893 24.75 11 24.75V23.25Z" fill="currentColor"/>
                    <path d="M1.5 3.25C1.08579 3.25 0.75 3.58579 0.75 4C0.75 4.41421 1.08579 4.75 1.5 4.75V3.25ZM1.5 4.75H6V3.25H1.5V4.75ZM7.25 6V21H8.75V6H7.25ZM6 4.75C6.69036 4.75 7.25 5.30964 7.25 6H8.75C8.75 4.48122 7.51878 3.25 6 3.25V4.75Z" fill="currentColor"/>
                    <path d="M22 21.75C22.4142 21.75 22.75 21.4142 22.75 21C22.75 20.5858 22.4142 20.25 22 20.25V21.75ZM22 20.25H11V21.75H22V20.25ZM8.75 18V12H7.25V18H8.75ZM11 20.25C9.75736 20.25 8.75 19.2426 8.75 18H7.25C7.25 20.0711 8.92893 21.75 11 21.75V20.25Z" fill="currentColor"/>
                    <path d="M27.2057 19.754C27.0654 20.1438 26.6357 20.346 26.246 20.2057C25.8562 20.0654 25.654 19.6357 25.7943 19.246L27.2057 19.754ZM30.0361 9.67744L29.3305 9.4234L29.3305 9.4234L30.0361 9.67744ZM25.7943 19.246L29.3305 9.4234L30.7418 9.93148L27.2057 19.754L25.7943 19.246ZM28.1543 7.75L8 7.75V6.25L28.1543 6.25V7.75ZM29.3305 9.4234C29.6237 8.60882 29.0201 7.75 28.1543 7.75V6.25C30.059 6.25 31.3869 8.13941 30.7418 9.93148L29.3305 9.4234Z" fill="currentColor"/>
                    <path d="M13.5 21.75C13.0858 21.75 12.75 21.4142 12.75 21C12.75 20.5858 13.0858 20.25 13.5 20.25V21.75ZM26.7111 19.009L27.4174 19.2613L27.4174 19.2613L26.7111 19.009ZM13.5 20.25H23.8858V21.75H13.5V20.25ZM26.0048 18.7568L27.7937 13.7477L29.2063 14.2523L27.4174 19.2613L26.0048 18.7568ZM23.8858 20.25C24.8367 20.25 25.6849 19.6522 26.0048 18.7568L27.4174 19.2613C26.8843 20.7537 25.4706 21.75 23.8858 21.75V20.25Z" fill="currentColor"/>
                    <path d="M21.1694 10.5806L14.5651 17.1849" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M22.1694 14.5806L18.5632 18.1868" stroke="currentColor" stroke-width="1.5"/>
                    <circle cx="13.1" cy="26.1" r="1.7" stroke="currentColor" stroke-width="1.5"/>
                    <circle cx="22.1" cy="26.1" r="1.7" stroke="currentColor" stroke-width="1.5"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-balance text-gray-900 dark:text-white">Create New Password</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm text-balance">
                Choose a strong password for account security.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-6" x-data="{ showPassword: false, password: '' }">
            @csrf
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <div class="flex flex-col gap-6">
                <div class="relative">
                    <input
                        name="email"
                        value="{{ request('email') }}"
                        type="email"
                        autocomplete="email"
                        required
                        class="bg-white dark:bg-gray-950 ps-10 h-9 text-sm w-full rounded-md border border-gray-200 dark:border-gray-800 px-3 py-1 shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 disabled:cursor-not-allowed disabled:opacity-50"
                        placeholder="me@example.com"
                    />
                    <svg class="text-gray-400 absolute start-3 top-1/2 size-5 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>

                <div class="relative">
                    <input
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        required
                        x-model="password"
                        class="bg-white dark:bg-gray-950 ps-10 pe-10 h-9 text-sm w-full rounded-md border border-gray-200 dark:border-gray-800 px-3 py-1 shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 disabled:cursor-not-allowed disabled:opacity-50"
                        placeholder="Enter new password"
                    />
                    <svg class="text-gray-400 absolute start-3 top-1/2 size-5 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <button
                        type="button"
                        class="size-9 text-gray-400 absolute end-1 top-1/2 -translate-y-1/2 cursor-pointer hover:bg-transparent rounded-sm"
                        @click="showPassword = !showPassword"
                        aria-label="Toggle password visibility"
                    >
                        <svg x-show="!showPassword" class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg x-show="showPassword" class="size-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 013.999-5.365m3.427-3.427a3 3 0 11-4.243 4.243M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.058 10.058 0 01-3.59 5.37m0 0L3 3"/>
                        </svg>
                    </button>
                </div>

                <div class="flex flex-col gap-1">
                    <div class="h-2 w-full rounded-full bg-gray-200 dark:bg-gray-800 overflow-hidden">
                        <div
                            class="h-full rounded-full transition-all duration-300"
                            :class="{
                                'bg-red-500': password.length > 0 && password.length < 8,
                                'bg-yellow-500': password.length >= 8 && /[A-Z]/.test(password) && !/[0-9]/.test(password),
                                'bg-blue-500': password.length >= 8 && /[A-Z]/.test(password) && /[0-9]/.test(password) && !/[^A-Za-z0-9]/.test(password),
                                'bg-green-500': password.length >= 8 && /[A-Z]/.test(password) && /[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)
                            }"
                            :style="`width: ${Math.min(password.length * 5, 100)}%`"
                        ></div>
                    </div>
                    <small class="text-gray-400 block text-end text-xs">
                        <span x-text="password.length < 8 ? 'Too short' : (password.length >= 8 && /[A-Z]/.test(password) && /[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password) ? 'Strong' : password.length >= 8 ? 'Medium' : '')"></span>
                    </small>
                </div>

                <div class="relative">
                    <input
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="bg-white dark:bg-gray-950 ps-10 pe-10 h-9 text-sm w-full rounded-md border border-gray-200 dark:border-gray-800 px-3 py-1 shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 disabled:cursor-not-allowed disabled:opacity-50"
                        placeholder="Confirm new password"
                    />
                    <svg class="text-gray-400 absolute start-3 top-1/2 size-5 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>

                <button
                    type="submit"
                    class="h-9 px-4 py-2 w-full cursor-pointer inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 bg-indigo-600 text-white shadow-sm hover:bg-indigo-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500"
                >
                    Reset password
                </button>
            </div>
        </form>

        <div class="text-center text-sm">
            <a href="{{ route('login') }}" class="underline underline-offset-4 hover:no-underline text-gray-600 dark:text-gray-400">
                Back to login
            </a>
        </div>
    </div>
</x-layouts::auth>
