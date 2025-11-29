<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $reference }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        /* Empêche de couper un élément en deux (ex: tableau des totaux) */
        .page-break-inside-avoid { page-break-inside: avoid; }
        /* Force un saut de page APRÈS cet élément */
        .break-page { page-break-after: always; }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased">

<!-- Wrapper A4 (pour visualisation HTML, Browsershot ignorera la width mais gardera le ratio) -->
<div class="max-w-[210mm] mx-auto min-h-screen relative flex flex-col">

    <!-- HEADER BANNER -->
    <div class="bg-slate-50 px-12 py-10 border-b border-slate-200">
        <div class="flex justify-between items-start">
            <!-- Logo & Company -->
            <div>
                <img src="{{ asset('storage/upload/logo-company.png') }}" class="h-10 mb-4 object-contain" alt="Logo">
                <div class="text-xs text-slate-500 space-y-0.5">
                    <p class="font-bold text-slate-700 text-sm">{{ $company['name'] }}</p>
                    <p>{{ $company['address'] }}</p>
                    <p>{{ $company['code_postal'] }} {{ $company['ville'] }}, {{ $company['pays'] }}</p>
                    <p>SIRET: {{ $company['siret'] }}</p>
                </div>
            </div>

            <!-- Document Info -->
            <div class="text-right">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900 mb-1">{{ \Illuminate\Support\Str::upper($type) }}</h1>
                <p class="text-slate-500 text-sm mb-4">#{{ $reference }}</p>

                <div class="inline-block text-left bg-white p-3 rounded border border-slate-200 text-xs shadow-sm">
                    <div class="flex justify-between gap-8 mb-1">
                        <span class="text-slate-500">Date d'émission:</span>
                        <span class="font-semibold">{{ $date }}</span>
                    </div>
                    <div class="flex justify-between gap-8">
                        <span class="text-slate-500">Échéance:</span>
                        <span class="font-semibold text-red-600">{{ $due_date }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ADDRESSES -->
    <div class="px-12 py-10 flex justify-between items-start">
        <div class="w-1/2 pr-8">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Émetteur</h3>
            <div class="text-sm text-slate-600">
                <p class="font-semibold text-slate-900">{{ $company['name'] }}</p>
                <p>{{ $company['email'] }}</p>
            </div>
        </div>

        <div class="w-1/2 pl-8 border-l border-slate-100">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Destinataire</h3>
            <div class="text-sm text-slate-600">
                <p class="font-bold text-slate-900 text-lg">{{ $customer_name }}</p>
                @if($customer_contact) <p>{{ $customer_contact }}</p> @endif
                    <p>{{ $customer_address }}</p>
                    <p>{{ $customer_zip }} {{ $customer_city }}</p>
                    <p class="uppercase">{{ $customer_country }}</p>
            </div>
        </div>
    </div>

    <!-- ITEMS TABLE -->
    <div class="px-12 mb-8">
        <table class="w-full text-left text-sm">
            <thead>
            <tr class="text-slate-500 border-b border-slate-200">
                <th class="py-3 font-medium w-1/2">Description</th>
                <th class="py-3 font-medium text-center w-24">Qté</th>
                <th class="py-3 font-medium text-right w-32">Prix U.</th>
                <th class="py-3 font-medium text-right w-32">Total HT</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @foreach($items as $item)
                <tr>
                    <td class="py-4 align-top">
                        <p class="font-medium text-slate-900">{{ $item['name'] }}</p>
                        @if($item['description'])
                            <p class="text-xs text-slate-500 mt-0.5">{{ $item['description'] }}</p>
                        @endif
                    </td>
                    <td class="py-4 text-center text-slate-600 align-top">{{ $item['quantity'] }}</td>
                    <td class="py-4 text-right text-slate-600 align-top">{{ number_format($item['price'], 2, ',', ' ') }} €</td>
                    <td class="py-4 text-right font-medium text-slate-900 align-top">{{ number_format($item['total_ht'], 2, ',', ' ') }} €</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- TOTALS & PAYMENT -->
    <div class="px-12 flex justify-end page-break">
        <div class="w-1/2 lg:w-1/3">
            <div class="space-y-2 text-sm text-slate-600 border-b border-slate-200 pb-4 mb-4">
                <div class="flex justify-between">
                    <span>Total HT</span>
                    <span class="font-medium">{{ number_format($subtotal, 2, ',', ' ') }} €</span>
                </div>
                <div class="flex justify-between">
                    <span>TVA ({{ $vat_rate }}%)</span>
                    <span>{{ number_format($tax, 2, ',', ' ') }} €</span>
                </div>
            </div>
            <div class="flex justify-between items-center text-slate-900 font-bold text-lg">
                <span>Total TTC</span>
                <span>{{ number_format($total, 2, ',', ' ') }} €</span>
            </div>
        </div>
    </div>

    <!-- FOOTER / NOTES -->
    <div class="mt-auto px-12 pb-12 pt-8">
        <div class="bg-slate-50 rounded-lg p-6 flex justify-between items-end border border-slate-100">
            <div class="text-xs text-slate-500 max-w-lg">
                <p class="font-bold text-slate-700 mb-1">Informations de paiement</p>
                <p>IBAN: <span class="font-mono text-slate-700">{{ $bank_info }}</span></p>
                <p>BIC: <span class="font-mono text-slate-700">{{ $bank_bic }}</span></p>
                <div class="mt-3 pt-3 border-t border-slate-200">
                    <p>{{ $terms }}</p>
                </div>
            </div>

            <!-- Signature Area -->
            @if ($type === 'devis')
            <div class="text-center">
                <div class="h-16 w-32 mb-2 border-b border-slate-300"></div>
                <p class="text-[10px] text-slate-400 uppercase tracking-widest">Signature</p>
            </div>
            @endif
        </div>

        <div class="mt-8 text-center text-[10px] text-slate-400">
            Siret: {{ $company['siret'] }} • APE: {{ $company['ape'] }} • RCS: {{ $company['rcs'] }} • N° TVA intracom: {{ $company['tva'] ?? 'Non Rensignée' }} • Document généré par Batistack
        </div>
    </div>
</div>
<div class="break-page"></div>
<div class="max-w-[210mm] mx-auto min-h-screen relative flex flex-col px-12 py-12">
    <h2 class="text-xl font-bold text-slate-900 mb-6 uppercase tracking-wider">Conditions Générales de Vente</h2>

    <div class="text-[10px] text-slate-500 text-justify columns-2 gap-8 leading-relaxed">
        {!! $company['cvg'] !!}
    </div>
</div>
</body>
</html>
