<div class="p-4 sm:p-6 lg:p-8">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">Inventaire</h1>
            <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                #{{ $inventory->code }}
            </div>
        </div>
        <div class="flex items-center gap-2 5">
            @foreach ($this->getHeaderAction() as $action)
                {{ $action }}
            @endforeach

        </div>
    </div>
    <div class="kt-separator my-2.5"></div>
    <div class="kt-container-fluid">
        <div class="grid lg:grid-cols-4 gap-5 items-stretch">
            <div class="lg:col-span-1">
                {{ $this->inventoryInfoList }}
            </div>
            <div class="lg:col-span-2">
            </div>
        </div>
    </div>

</div>
