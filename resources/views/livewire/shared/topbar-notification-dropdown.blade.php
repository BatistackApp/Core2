<div>

    <!-- Notifications -->
    <button class="kt-btn kt-btn-ghost kt-btn-icon hover:bg-primary/10 hover:[&_i]:text-primary size-9 rounded-full"
        data-kt-drawer-toggle="#notifications_drawer">
        <i class="ki-filled ki-notification-status text-lg">
        </i>
    </button>
    <!--Notifications Drawer-->
    <div class="kt-drawer kt-drawer-end card bottom-5 end-5 top-5 hidden w-[450px] max-w-[90%] flex-col rounded-xl border border-border"
        data-kt-drawer="true" data-kt-drawer-container="body" id="notifications_drawer">
        <div class="flex items-center justify-between gap-2.5 border-b border-b-border px-5 py-2.5 text-sm font-semibold text-mono"
            id="notifications_header">
            Notifications
            <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-dim shrink-0" data-kt-drawer-dismiss="true">
                <i class="ki-filled ki-cross">
                </i>
            </button>
        </div>
        <div class="kt-tabs kt-tabs-line mb-2 justify-between px-5" data-kt-tabs="true" id="notifications_tabs">
            <div class="flex items-center gap-5">
                <button class="kt-tab-toggle active py-3" data-kt-tab-toggle="#notifications_tab_all">
                    Tous
                </button>
            </div>
            <div class="kt-menu" data-kt-menu="true">
                <div class="kt-menu-item" data-kt-menu-item-offset="0,10px" data-kt-menu-item-placement="bottom-end"
                    data-kt-menu-item-placement-rtl="bottom-start" data-kt-menu-item-toggle="dropdown"
                    data-kt-menu-item-trigger="click|lg:hover">
                    <button class="kt-menu-toggle kt-btn kt-btn-icon kt-btn-ghost">
                        <i class="ki-filled ki-setting-2">
                        </i>
                    </button>
                    <div class="kt-menu-dropdown kt-menu-default w-full max-w-[175px]" data-kt-menu-dismiss="true">
                        <div class="kt-menu-item">
                            <a class="kt-menu-link" href="#">
                                <span class="kt-menu-icon">
                                    <i class="ki-filled ki-document">
                                    </i>
                                </span>
                                <span class="kt-menu-title">
                                    View
                                </span>
                            </a>
                        </div>
                        <div class="kt-menu-item" data-kt-menu-item-offset="-15px, 0"
                            data-kt-menu-item-placement="right-start" data-kt-menu-item-toggle="dropdown"
                            data-kt-menu-item-trigger="click|lg:hover">
                            <div class="kt-menu-link">
                                <span class="kt-menu-icon">
                                    <i class="ki-filled ki-notification-status">
                                    </i>
                                </span>
                                <span class="kt-menu-title">
                                    Export
                                </span>
                                <span class="kt-menu-arrow">
                                    <i class="ki-filled ki-right text-xs rtl:rotate-180 rtl:transform">
                                    </i>
                                </span>
                            </div>
                            <div class="kt-menu-dropdown kt-menu-default w-full max-w-[175px]">
                                <div class="kt-menu-item">
                                    <a class="kt-menu-link" href="html/demo1/account/home/settings-sidebar.html">
                                        <span class="kt-menu-icon">
                                            <i class="ki-filled ki-sms">
                                            </i>
                                        </span>
                                        <span class="kt-menu-title">
                                            Email
                                        </span>
                                    </a>
                                </div>
                                <div class="kt-menu-item">
                                    <a class="kt-menu-link" href="html/demo1/account/home/settings-sidebar.html">
                                        <span class="kt-menu-icon">
                                            <i class="ki-filled ki-message-notify">
                                            </i>
                                        </span>
                                        <span class="kt-menu-title">
                                            SMS
                                        </span>
                                    </a>
                                </div>
                                <div class="kt-menu-item">
                                    <a class="kt-menu-link" href="html/demo1/account/home/settings-sidebar.html">
                                        <span class="kt-menu-icon">
                                            <i class="ki-filled ki-notification-status">
                                            </i>
                                        </span>
                                        <span class="kt-menu-title">
                                            Push
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="kt-menu-item">
                            <a class="kt-menu-link" href="#">
                                <span class="kt-menu-icon">
                                    <i class="ki-filled ki-pencil">
                                    </i>
                                </span>
                                <span class="kt-menu-title">
                                    Edit
                                </span>
                            </a>
                        </div>
                        <div class="kt-menu-item">
                            <a class="kt-menu-link" href="#">
                                <span class="kt-menu-icon">
                                    <i class="ki-filled ki-trash">
                                    </i>
                                </span>
                                <span class="kt-menu-title">
                                    Delete
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex grow flex-col" id="notifications_tab_all">
            <div class="kt-scrollable-y-auto grow" data-kt-scrollable="true" data-kt-scrollable-dependencies="#header"
                data-kt-scrollable-max-height="auto" data-kt-scrollable-offset="150px">
                <div class="divider-y divider-border flex grow flex-col gap-5 pb-4 pt-3">
                    @foreach(auth()->user()->unreadNotifications as $notification)
                        <div role="alert" class="alert alert-vertical sm:alert-horizontal alert-{{ $notification->data['iconColor'] }} mb-2">
                            @php
                                $icon = $notification->data['icon'];
                            @endphp
                            @svg($icon, 'w-6 h-6')
                            <div>
                                <h3 class="font-bold">{{ $notification->data['title'] }}</h3>
                                <div class="text-xs">{{ $notification->data['body'] }}</div>
                            </div>
                            @isset($notification->data['actions'])
                                @if(count($notification->data['actions']) > 0)
                                    <button class="btn btn-sm">See</button>
                                @endif
                            @endisset
                        </div>
                        <div class="border-b border-b-border">
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="border-b border-b-border">
            </div>
        </div>
    </div>
    <!--End of Notifications Drawer-->
    <!-- End of Notifications -->
</div>
