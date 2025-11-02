
<div class="flex items-stretch" id="megaMenuContainer">
    <div class="flex items-stretch [--kt-reparent-mode:prepend] [--kt-reparent-target:body] lg:[--kt-reparent-mode:prepend] lg:[--kt-reparent-target:#megaMenuContainer]"
        data-kt-reparent="true">
        <div class="hidden [--kt-drawer-enable:true] lg:flex lg:items-stretch lg:[--kt-drawer-enable:false]"
            data-kt-drawer="true"
            data-kt-drawer-class="kt-drawer kt-drawer-start fixed z-10 top-0 bottom-0 w-full me-5 max-w-[250px] p-5 lg:p-0 overflow-auto"
            id="mega_menu_wrapper">
            <div class="kt-menu flex-col gap-5 lg:flex-row lg:gap-7.5" data-kt-menu="true" id="mega_menu">
                <div class="kt-menu-item active">
                    <a class="kt-menu-link kt-menu-item-hover:text-primary kt-menu-item-active:text-mono kt-menu-item-active:font-medium text-nowrap text-sm font-medium text-foreground"
                        href="{{ route('home') }}" wire:navigate>
                        <span class="kt-menu-title text-nowrap">
                            Home
                        </span>
                    </a>
                </div>
                @foreach (App\Models\Core\Module::where('is_active', true)->get() as $module)
                    <div class="kt-menu-item">
                        <a class="kt-menu-link kt-menu-item-hover:text-primary kt-menu-item-active:text-mono kt-menu-item-active:font-medium text-nowrap text-sm font-medium text-foreground"
                            href="{{ route('module.redirect', ['slug' => $module->slug]) }}" wire:navigate>
                            <span class="kt-menu-title text-nowrap">
                                {{ $module->name_formated }}
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

