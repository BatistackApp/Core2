<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $document_name ?? 'Document' }}</title>

    <!--
        NOTE DEVOPS :
        Pour la production, il est recommandé d'injecter le CSS compilé via file_get_contents(public_path('css/app.css'))
        ou d'utiliser un CDN fiable si votre moteur PDF a accès au web.
    -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @page {
            margin: 0;
            size: A4;
        }
        body {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
        }
        .footer-bottom {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }
    </style>
</head>
<body class="bg-white text-slate-800 text-sm antialiased">

<!-- Bandeau Latéral Décoratif (Optionnel) -->
<div class="fixed left-0 top-0 bottom-0 w-2 bg-slate-900 print:bg-slate-900"></div>

<div class="max-w-[210mm] mx-auto min-h-screen relative flex flex-col pl-8 pr-12 py-12">

    <!-- HEADER -->
    <header class="flex justify-between items-start mb-12">
        <!-- Logo & Entreprise -->
        <div class="w-1/2">
            @if(isset($logo))
                <img src="{{ $logo }}" alt="Logo" class="h-12 mb-4 object-contain max-w-[200px]">
            @else
                <div class="h-12 flex items-center mb-4">
                    <span class="text-2xl font-bold tracking-tight text-slate-900">{{ $company_name }}</span>
                </div>
            @endif

            <div class="text-xs text-slate-500 leading-relaxed">
                <p class="font-bold text-slate-900">{{ $company['name'] ?? 'NO SOCIETE' }}</p>
                <p>{{ $company['address'] }}</p>
                <p>{{ $company['code_postal'] }} {{ $company['ville'] }}, {{ $company['pays'] }}</p>
                <p>SIRET: {{ $company['siret'] }}</p>
                <p>APE: {{ $company['ape'] }}</p>
                <p>{{ $company['email'] }}</p>
            </div>
        </div>

        <!-- Titre & Meta -->
        <div class="w-1/2 text-right">
            <h1 class="text-4xl font-light text-slate-900 uppercase tracking-widest mb-1">
                {{ $type ?? 'FACTURE' }}
            </h1>
            <p class="text-slate-400 font-medium mb-6">#{{ $reference ?? 'FAC-2025-001' }}</p>

            <table class="ml-auto text-right text-xs">
                <tr>
                    <td class="pb-1 pr-4 text-slate-500">Date d'émission</td>
                    <td class="pb-1 font-semibold">{{ $date ?? now()->format('d/m/Y') }}</td>
                </tr>
                @if(isset($due_date))
                    <tr>
                        <td class="pb-1 pr-4 text-slate-500">Date d'échéance</td>
                        <td class="pb-1 font-semibold">{{ $due_date }}</td>
                    </tr>
                @endif
                <!-- Statut du document -->
                <tr>
                    <td class="pt-2" colspan="2">
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold text-[10px] uppercase">
                                {{ $status ?? 'Payée' }}
                            </span>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <!-- DESTINATAIRE -->
    <section class="flex justify-between items-start mb-16 border-t border-slate-100 pt-8">
        <div class="w-1/2">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Facturé à</h3>
            <div class="text-sm leading-relaxed">
                <p class="font-bold text-slate-900 text-lg">{{ $customer_name ?? 'Client Inconnu' }}</p>
                @if(isset($customer_contact)) <p>{{ $customer_contact }}</p> @endif
                <p class="text-slate-600">{{ $customer_address ?? 'Adresse non renseignée' }}</p>
                <p class="text-slate-600">{{ $customer_zip ?? '' }} {{ $customer_city ?? '' }}</p>
                <p class="text-slate-600">{{ $customer_country ?? 'France' }}</p>
                @if(isset($customer_vat)) <p class="mt-2 text-xs text-slate-400">TVA: {{ $customer_vat }}</p> @endif
            </div>
        </div>

        <!-- Optionnel : Adresse de livraison si différente -->
        @if(isset($shipping_address))
            <div class="w-1/3">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Livré à</h3>
                <div class="text-xs text-slate-500 leading-relaxed">
                    <p>{{ $shipping_address }}</p>
                </div>
            </div>
        @endif
    </section>

    <!-- TABLEAU DES ARTICLES -->
    <section class="mb-12">
        <table class="w-full text-left border-collapse">
            <thead>
            <tr class="border-b-2 border-slate-900">
                <th class="py-3 text-xs font-bold text-slate-900 uppercase tracking-wider w-1/12">#</th>
                <th class="py-3 text-xs font-bold text-slate-900 uppercase tracking-wider w-5/12">Description</th>
                <th class="py-3 text-xs font-bold text-slate-900 uppercase tracking-wider text-right w-2/12">P.U. HT</th>
                <th class="py-3 text-xs font-bold text-slate-900 uppercase tracking-wider text-center w-1/12">Qté</th>
                <th class="py-3 text-xs font-bold text-slate-900 uppercase tracking-wider text-right w-1/12">TVA</th>
                <th class="py-3 text-xs font-bold text-slate-900 uppercase tracking-wider text-right w-2/12">Total HT</th>
            </tr>
            </thead>
            <tbody class="text-sm">
            @forelse($items as $index => $item)
                <tr class="border-b border-slate-100 group">
                    <td class="py-4 text-slate-400 align-top">{{ $index + 1 }}</td>
                    <td class="py-4 font-medium text-slate-700 align-top">
                        <p class="text-slate-900">{{ $item['name'] }}</p>
                        @if(isset($item['description']))
                            <p class="text-xs text-slate-500 mt-1">{{ $item['description'] }}</p>
                        @endif
                    </td>
                    <td class="py-4 text-right text-slate-600 align-top">{{ number_format($item['price'], 2, ',', ' ') }} €</td>
                    <td class="py-4 text-center text-slate-600 align-top">{{ $item['quantity'] }}</td>
                    <td class="py-4 text-right text-slate-600 align-top">{{ $item['vat_rate'] }}%</td>
                    <td class="py-4 text-right font-medium text-slate-900 align-top">{{ number_format($item['total_ht'], 2, ',', ' ') }} €</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-slate-400 italic">Aucun élément</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </section>

    <!-- TOTAUX & PAIEMENT -->
    <div class="flex justify-end mb-16 break-inside-avoid">
        <div class="w-5/12">
            <table class="w-full text-sm">
                <tr>
                    <td class="py-2 text-slate-500 text-right pr-6">Total HT</td>
                    <td class="py-2 text-right font-medium text-slate-900">{{ number_format($subtotal ?? 0, 2, ',', ' ') }} €</td>
                </tr>
                @if(isset($discount) && $discount > 0)
                    <tr>
                        <td class="py-2 text-green-600 text-right pr-6">Remise</td>
                        <td class="py-2 text-right font-medium text-green-600">- {{ number_format($discount, 2, ',', ' ') }} €</td>
                    </tr>
                @endif
                <tr>
                    <td class="py-2 text-slate-500 text-right pr-6">TVA ({{ $vat_rate ?? '20' }}%)</td>
                    <td class="py-2 text-right font-medium text-slate-900">{{ number_format($tax ?? 0, 2, ',', ' ') }} €</td>
                </tr>
                <tr class="border-t-2 border-slate-900">
                    <td class="py-4 text-slate-900 font-bold text-right pr-6 text-base">NET À PAYER</td>
                    <td class="py-4 text-right font-bold text-slate-900 text-xl">{{ number_format($total ?? 0, 2, ',', ' ') }} €</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- NOTES & CONDITIONS (Bas de page relatif ou absolu) -->
    <div class="mt-auto pt-8 border-t border-slate-200">
        <div class="flex justify-between items-end">
            <div class="w-2/3 text-xs text-slate-500 text-justify">
                @if(isset($terms))
                    <p class="font-bold mb-1 text-slate-700">Conditions de paiement</p>
                    <p class="mb-4">{{ $terms }}</p>
                @endif

                @if(isset($bank_info))
                    <div class="bg-slate-50 p-3 rounded border border-slate-100 inline-block">
                        <p class="font-bold text-slate-700 mb-1">Coordonnées Bancaires (IBAN)</p>
                        <p class="font-mono">{{ $bank_info }}</p>
                        <p class="font-mono mt-1 text-[10px]">BIC: {{ $bank_bic ?? '' }}</p>
                    </div>
                @endif
            </div>

            <div class="w-1/3 text-right">
                @if(isset($signature_box) && $signature_box)
                    <div class="border border-slate-300 h-24 w-full bg-slate-50 rounded flex items-end justify-center pb-2">
                        <span class="text-xs text-slate-400 uppercase">Signature & Cachet</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- FOOTER LÉGAL FIXE -->
    <footer class="footer-bottom w-full text-center pb-8 px-12">
        <p class="text-[10px] text-slate-400">
            {{ $company_name ?? 'Vortech Studio' }} - SAS au capital de 10 000€ - RCS Paris B 123 456 789 - TVA Intracommunautaire: FR 12 123456789
            <br>
            Document généré automatiquement par Batistack.io
        </p>
    </footer>

</div>
</body>
</html>
