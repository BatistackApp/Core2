<div class="kt-card max-w-[370px] w-full">
    <form wire:submit="login" class="kt-card-content flex flex-col gap-5 p-10">
        <img src="{{ \Illuminate\Support\Facades\Storage::url('logos/batistack_long_color.png') }}" alt="logo" class="h-16 self-center" />
        <div class="text-center mb-2.5">
            <h3 class="text-lg font-medium text-mono leading-none mb-2.5">{{ __('auth.login') }}</h3>
            <p class="text-sm text-mono text-text-300">{{ __('auth.company') }}: SARL C2ME</p>
        </div>
        {{ $this->form }}

        <button type="submit" class="kt-btn kt-btn-primary flex justify-center grow">{{ __('auth.login') }}</button>
    </form>
</div>
