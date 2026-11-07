
<x-layouts::app :title="__('Dashboard')">

    <div class="min-h-screen bg-[#f3f7fa] px-4 py-6 sm:px-6 lg:px-8 dark:bg-[#101c2c]">

        <div class="mx-auto max-w-7xl space-y-7">

            <!-- Welcome Section -->
            <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#101c2c] via-[#172d40] to-[#075b5a] p-6 text-white shadow-lg sm:p-9">

                <div class="relative z-10 max-w-2xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-teal-300/30 bg-teal-300/10 px-3 py-1 text-xs font-semibold tracking-wide text-teal-200">
                        <span class="h-2 w-2 rounded-full bg-teal-400"></span>
                        TRACKMYBUS PLATFORM
                    </span>

                    <h1 class="mt-5 text-3xl font-bold tracking-tight sm:text-4xl">
                        Welcome back, {{ auth()->user()->name }}!
                    </h1>

                    <p class="mt-3 max-w-xl text-sm leading-6 text-slate-300 sm:text-base">
                        Manage your bus journeys, explore available routes and track buses in real time from one place.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ url('/routes') }}"
                           class="inline-flex items-center gap-2 rounded-lg bg-[#16b8a6] px-5 py-3 text-sm font-semibold text-[#102a35] transition hover:bg-[#42d6c4]">
                            Explore Bus Routes
                            <span>→</span>
                        </a>

                        <a href="{{ url('/tracking') }}"
                           class="inline-flex items-center gap-2 rounded-lg border border-white/25 bg-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/20">
                            Live Tracking
                        </a>
                    </div>
                </div>

                <div class="pointer-events-none absolute -right-10 -top-20 h-72 w-72 rounded-full border border-white/10"></div>
                <div class="pointer-events-none absolute -right-2 -top-12 h-56 w-56 rounded-full border border-white/10"></div>
                <div class="pointer-events-none absolute -bottom-24 right-28 h-48 w-48 rounded-full bg-teal-400/10 blur-3xl"></div>

            </section>

            <!-- Section Heading -->
            <section>
                <div class="mb-5">
                    <h2 class="text-xl font-bold text-slate-800 dark:text-white">
                        Quick Access
                    </h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Choose what you would like to do today.
                    </p>
                </div>

                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

                    <!-- Bus Routes -->
                    <a href="{{ url('/routes') }}"
                       class="group rounded-2xl border border-slate-200 bg-white p-6 transition duration-200 hover:-translate-y-1 hover:border-teal-300 hover:shadow-lg dark:border-slate-700 dark:bg-[#17283b]">

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-teal-50 text-2xl dark:bg-teal-500/10">
                            🚌
                        </div>

                        <h3 class="mt-5 text-lg font-bold text-slate-800 group-hover:text-teal-600 dark:text-white dark:group-hover:text-teal-300">
                            Available Bus Routes
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">
                            Browse available buses and check their starting points and destinations.
                        </p>

                        <div class="mt-5 text-sm font-semibold text-teal-600 dark:text-teal-300">
                            View Routes →
                        </div>
                    </a>

                    <!-- Live Tracking -->
                    <a href="{{ url('/tracking') }}"
                       class="group rounded-2xl border border-slate-200 bg-white p-6 transition duration-200 hover:-translate-y-1 hover:border-teal-300 hover:shadow-lg dark:border-slate-700 dark:bg-[#17283b]">

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-2xl dark:bg-blue-500/10">
                            📍
                        </div>

                        <h3 class="mt-5 text-lg font-bold text-slate-800 group-hover:text-teal-600 dark:text-white dark:group-hover:text-teal-300">
                            Live Bus Tracking
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">
                            Find your bus and check its latest available location on the map.
                        </p>

                        <div class="mt-5 text-sm font-semibold text-teal-600 dark:text-teal-300">
                            Track a Bus →
                        </div>
                    </a>

                    <!-- Profile -->
                    <a href="{{ route('profile.edit') }}"
                       class="group rounded-2xl border border-slate-200 bg-white p-6 transition duration-200 hover:-translate-y-1 hover:border-teal-300 hover:shadow-lg dark:border-slate-700 dark:bg-[#17283b]">

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-2xl dark:bg-purple-500/10">
                            👤
                        </div>

                        <h3 class="mt-5 text-lg font-bold text-slate-800 group-hover:text-teal-600 dark:text-white dark:group-hover:text-teal-300">
                            My Profile
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">
                            View and update your account information and personal settings.
                        </p>

                        <div class="mt-5 text-sm font-semibold text-teal-600 dark:text-teal-300">
                            Manage Profile →
                        </div>
                    </a>

                </div>
            </section>

            <!-- Information Section -->
            <section class="grid gap-5 lg:grid-cols-2">

                <div class="rounded-2xl border border-slate-200 bg-white p-6 dark:border-slate-700 dark:bg-[#17283b]">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-50 text-xl dark:bg-teal-500/10">
                            ✨
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 dark:text-white">
                                Your Travel Companion
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Simple and convenient bus tracking
                            </p>
                        </div>
                    </div>

                    <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300">
                        TrackMyBus helps passengers find available bus routes and view the latest reported bus locations. Explore routes and use live tracking to make your journey easier.
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 dark:border-slate-700 dark:bg-[#17283b]">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-xl dark:bg-blue-500/10">
                            🔐
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 dark:text-white">
                                Account Information
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Your signed-in account
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 space-y-3 text-sm">
                        <div class="flex flex-wrap justify-between gap-2 border-b border-slate-100 pb-3 dark:border-slate-700">
                            <span class="text-slate-500 dark:text-slate-400">Name</span>
                            <span class="font-semibold text-slate-800 dark:text-white">
                                {{ auth()->user()->name }}
                            </span>
                        </div>

                        <div class="flex flex-wrap justify-between gap-2">
                            <span class="text-slate-500 dark:text-slate-400">Email</span>
                            <span class="font-semibold text-slate-800 dark:text-white">
                                {{ auth()->user()->email }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('profile.edit') }}"
                       class="mt-5 inline-flex text-sm font-semibold text-teal-600 hover:text-teal-700 dark:text-teal-300">
                        Account Settings →
                    </a>
                </div>

            </section>

            <!-- Footer -->
            <footer class="border-t border-slate-200 py-5 text-center dark:border-slate-700">
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    © {{ date('Y') }} TrackMyBus. Making bus journeys easier.
                </p>
            </footer>

        </div>
    </div>

</x-layouts::app>
