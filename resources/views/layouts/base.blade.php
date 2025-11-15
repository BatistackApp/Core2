<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.head')
    </head>
    <body class="demo1 kt-sidebar-fixed kt-header-fixed flex h-full bg-background text-base text-foreground antialiased">
        <!-- Page -->
        <!-- Main -->
        <div class="flex grow">
            @include('layouts.sidebar')

            <!-- Wrapper -->
            <div class="kt-wrapper flex grow flex-col">
                @persist('mega-menu')
                @include('layouts.header')
                @endpersist

                <!-- Content -->
                <main class="grow pt-5" id="content" role="content">
                    {{ $slot }}
                    @livewire('notifications')
                </main>
                <!-- End of Content -->

                @include('layouts.footer')
            </div>
            <!-- End of Wrapper -->
        </div>
        <!-- End of Main -->
        <!-- End of Page -->

        @include('layouts.partials.scripts')
    </body>
</html>
