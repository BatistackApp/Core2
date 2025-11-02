<!-- Sidebar -->
<div class="kt-sidebar fixed bottom-0 top-0 z-20 hidden shrink-0 flex-col items-stretch border-e border-e-border bg-background [--kt-drawer-enable:true] lg:flex lg:[--kt-drawer-enable:false]"
    data-kt-drawer="true" data-kt-drawer-class="kt-drawer kt-drawer-start top-0 bottom-0" id="sidebar">
    <div class="kt-sidebar-header relative hidden shrink-0 items-center justify-between px-3 lg:flex lg:px-6"
        id="sidebar_header">
        <a class="dark:hidden" href="{{ route('home') }}">
            <img class="default-logo min-h-[15px] w-[100px]" src="{{ asset('storage/logos/batistack_long_color.png') }}" />
            <img class="small-logo min-h-[15px] max-w-[50px]" src="{{ asset('storage/logos/batistack_seul_color.png') }}" />
        </a>
        <a class="hidden dark:block" href="{{ route('home') }}">
            <img class="default-logo min-h-[15px] w-[100px]" src="{{ asset('storage/logos/batistack_long_white.png') }}" />
            <img class="small-logo min-h-[15px] max-w-[50px]" src="{{ asset('storage/logos/batistack_seul_color.png') }}" />
        </a>
        <button
            class="kt-btn kt-btn-outline kt-btn-icon absolute start-full top-2/4 size-[30px] -translate-x-2/4 -translate-y-2/4 rtl:translate-x-2/4"
            data-kt-toggle="body" data-kt-toggle-class="kt-sidebar-collapse" id="sidebar_toggle">
            <i
                class="ki-filled ki-black-left-line kt-toggle-active:rotate-180 rtl:translate rtl:kt-toggle-active:rotate-0 transition-all duration-300 rtl:rotate-180">
            </i>
        </button>
    </div>
    <div class="kt-sidebar-content flex shrink-0 grow py-5 pe-2" id="sidebar_content">
        @if (request()->routeIs('home', 'config.*'))
        <div class="kt-scrollable-y-hover flex shrink-0 grow pe-1 ps-2 lg:pe-3 lg:ps-5" data-kt-scrollable="true"
            data-kt-scrollable-dependencies="#sidebar_header" data-kt-scrollable-height="auto"
            data-kt-scrollable-offset="0px" data-kt-scrollable-wrappers="#sidebar_content" id="sidebar_scrollable">
            <!-- Sidebar Menu -->
            <div class="kt-menu flex grow flex-col gap-1" data-kt-menu="true" data-kt-menu-accordion-expand-all="false"
                id="sidebar_menu">
                <div class="kt-menu-item {{ request()->routeIs('home') ? 'active' : ''}}">
                    <a class="kt-menu-label gap-[10px] border border-transparent py-[6px] pe-[10px] ps-[10px]"
                        href="{{ route('home') }}" tabindex="0">
                        <span class="kt-menu-title text-sm font-medium text-foreground">
                            Tableau de Bord
                        </span>
                    </a>
                </div>
                <div class="kt-menu-item {{ request()->routeIs('config.*') ? 'active' : ''}}">
                    <a class="kt-menu-label gap-[10px] border border-transparent py-[6px] pe-[10px] ps-[10px]"
                        href="{{ route('config.index') }}" tabindex="0">
                        <span class="kt-menu-title text-sm font-medium text-foreground">
                            Configuration
                        </span>
                    </a>
                </div>
            </div>
            <!-- End of Sidebar Menu -->
        </div>
        @elseif(request()->routeIs('chantier.*'))

        @elseif (request()->routeIs('3d-vision.*'))

        @elseif (request()->routeIs('articles.*'))

        @elseif (request()->routeIs('banque.*'))

        @elseif (request()->routeIs('commerces.*'))

        @elseif (request()->routeIs('comptabilite.*'))

        @elseif (request()->routeIs('facturation.*'))

        @elseif (request()->routeIs('flotte.*'))

        @elseif (request()->routeIs('ged.*'))

        @elseif (request()->routeIs('location.*'))

        @elseif (request()->routeIs('notes-frais.*'))

        @elseif (request()->routeIs('paie.*'))

        @elseif (request()->routeIs('planning.*'))

        @elseif (request()->routeIs('rh.*'))

        @elseif (request()->routeIs('tiers.*'))

        @endif        
    </div>
</div>
<!-- End of Sidebar -->
