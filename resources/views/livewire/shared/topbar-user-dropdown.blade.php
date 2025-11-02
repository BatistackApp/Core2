<!-- User -->
<div class="shrink-0" data-kt-dropdown="true" data-kt-dropdown-offset="10px, 10px" data-kt-dropdown-offset-rtl="-20px, 10px"
    data-kt-dropdown-placement="bottom-end" data-kt-dropdown-placement-rtl="bottom-start" data-kt-dropdown-trigger="click">
    <div class="shrink-0 cursor-pointer" data-kt-dropdown-toggle="true">
        <img alt="" class="size-9 shrink-0 rounded-full border-2 border-green-500"
            src="{{ auth()->user()->avatar }}" />
    </div>
    <div class="kt-dropdown-menu w-[300px]" data-kt-dropdown-menu="true">
        <div class="flex flex-col  justify-between gap-1.5 px-2.5 py-1.5">
            <div class="flex items-center gap-2">
                <img alt="" class="size-9 shrink-0 rounded-full border-2 border-green-500"
                    src="{{ auth()->user()->avatar }}" />
                <div class="flex flex-col gap-1.5">
                    <span class="text-sm font-semibold leading-none text-foreground">
                        {{ auth()->user()->name }}
                    </span>
                    <a class="hover:text-primary text-xs font-medium leading-none text-secondary-foreground"
                        href="html/demo1/account/home/get-started.html">
                        {{ auth()->user()->email }}
                    </a>
                </div>
            </div>
            <div class="flex justify-between">
                <span class="kt-badge kt-badge-sm kt-badge-{{ auth()->user()->role->color() }} kt-badge-outline">
                    {{ auth()->user()->role->label() }}
                </span>
                <span class="kt-badge kt-badge-sm kt-badge-primary kt-badge-outline">
                    Version: DEV
                </span>
            </div>
            
        </div>
        <ul class="kt-dropdown-menu-sub">
            <li>
                <div class="kt-dropdown-menu-separator">
                </div>
            </li>
            <li>
                <a class="kt-dropdown-menu-link" href="{{ route('profil') }}">
                    <i class="ki-filled ki-profile-circle">
                    </i>
                    Mon compte
                </a>
            </li>
            <li>
                <div class="kt-dropdown-menu-separator">
                </div>
            </li>
        </ul>
        <div class="mb-2.5 flex flex-col gap-3.5 px-2.5 pt-1.5">
            <div class="flex items-center justify-between gap-2">
                <span class="flex items-center gap-2">
                    <i class="ki-filled ki-moon text-base text-muted-foreground">
                    </i>
                    <span class="text-2sm font-medium">
                        Mode Nuit
                    </span>
                </span>
                <input class="kt-switch" data-kt-theme-switch-state="dark" data-kt-theme-switch-toggle="true"
                    name="check" type="checkbox" value="1" />
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="kt-btn kt-btn-outline w-full justify-center">Déconnexion</button>
            </form>
        </div>
    </div>
</div>
<!-- End of User -->
