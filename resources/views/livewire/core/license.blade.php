<div class="kt-container-fixed">
    <div class="flex flex-row justify-between gap-5">
        <div class="kt-card w-full">
            <div class="kt-card-header">
                <div class="kt-card-heading">
                    <h2 class="kt-card-title">Produit</h2>
                </div>
                <div class="kt-card-toolbar"></div>
            </div>
            <div class="kt-card-content py-5">
                <div class="flex justify-between align-middle border-b border-b-border py-2">
                    <span class="font-bold">Code</span>
                    <span class="kt-badge">{{ $license['service_code'] }}</span>
                </div>
                <div class="flex justify-between align-middle border-b border-b-border py-2">
                    <span class="font-bold">Produit</span>
                    <div class="flex align-middle gap-2">
                        <img src="{{ $license['product']['media'] }}" alt="" class="rounded w-[50px]" />
                        <div class="flex flex-col gap-1">
                            <span>{{ $license['product']['name'] }}</span>
                            <div class="flex flex-row justify-around gap-3">
                                <span class="kt-badge">{{ $license['product']['info_stripe']['metadata']['max_users'] }}</span>
                                <span class="kt-badge">{{ $license['product']['info_stripe']['metadata']['storage_limit'] }} GB</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col justify-between align-middle border-b border-b-border py-2">
                    <span class="font-bold pb-2">Modules Accessibles</span>
                    <div class="flex flex-wrap gap-2">
                        @foreach($license['modules'] as $module)
                            <span class="kt-badge">{{ $module['feature']['name'] }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-card w-full">
            <div class="kt-card-header">
                <div class="kt-card-heading">
                    <h2 class="kt-card-title">Mes Options</h2>
                </div>
                <div class="kt-card-toolbar"></div>
            </div>
            <div class="kt-card-content py-5">
                @foreach($license['options'] as $option)
                <div class="flex flex-row align-middle border-b border-b-border gap-1 py-2">
                    <img src="{{ $option['product']['media'] }}" class="w-[30px]" alt="" />
                    <div class="flex flex-col">
                        <span class="font-semibold">{{ $option['product']['name'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="kt-card w-full">
            <div class="kt-card-header">
                <div class="kt-card-heading">
                    <h2 class="kt-card-title">Ma Souscription</h2>
                </div>
                <div class="kt-card-toolbar"></div>
            </div>
            <div class="kt-card-content py-5">
                @php
                $date_end_anchor = \Carbon\Carbon::createFromTimestamp($license['info_stripe']['items']['data'][0]['current_period_end']);
                $humans = $date_end_anchor->shortAbsoluteDiffForHumans();
                @endphp
                <div class="flex justify-between align-middle border-b border-b-border py-2">
                    <span class="font-bold">Date de souscription</span>
                    <span class="kt-badge">{{ \Carbon\Carbon::createFromTimestamp($license['info_stripe']['created'])->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between align-middle border-b border-b-border py-2">
                    <span class="font-bold">Prochaine facturation</span>
                    <span class="kt-badge">{{ $date_end_anchor->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between align-middle border-b border-b-border py-2">
                    <span class="font-bold">Cycle de facturation</span>
                    <span class="kt-badge">{{ $license['info_stripe']['items']['data'][0]['plan']['interval'] === 'month' ? 'Mensuel' : 'Annuel' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
