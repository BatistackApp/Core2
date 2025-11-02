<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.partials.head')
    @livewireStyles
    <style>
        .page-bg {
			background-image: url('assets/media/images/2600x1200/bg-10.png');
		}
		.dark .page-bg {
			background-image: url('assets/media/images/2600x1200/bg-10-dark.png');
		}
    </style>
</head>
<body class="antialiased flex h-full text-base text-foreground bg-background">
    <div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg">
        {{ $slot }}        
    </div>
    @include('layouts.partials.scripts')
    @livewire('notifications')
    @livewireScripts
</body>
</html>