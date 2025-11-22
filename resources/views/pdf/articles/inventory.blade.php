<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inventaire {{ $inventory->code }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { width: 100%; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .header table { width: 100%; }
        .title { font-size: 18px; font-weight: bold; }
        .meta { text-align: right; }

        table.lines { width: 100%; border-collapse: collapse; }
        table.lines th, table.lines td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        table.lines th { background-color: #f3f3f3; font-weight: bold; }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .box { border: 1px solid #000; height: 20px; width: 20px; display: inline-block; }

        .footer { position: fixed; bottom: 0; left: 0; right: 0; font-size: 10px; text-align: center; border-top: 1px solid #ccc; padding-top: 5px; }

        /* Pour laisser de la place pour écrire à la main */
        .write-zone { height: 25px; }
    </style>
</head>
<body>

<div class="header">
    <table>
        <tr>
            <td>
                <div class="title">{{ $title }}</div>
                <div>Code: <strong>{{ $inventory->code }}</strong></div>
                <div>Entrepôt: {{ $inventory->warehouse->name }}</div>
            </td>
            <td class="meta">
                <div>Date: {{ $inventory->inventory_date->format('d/m/Y') }}</div>
                <div>Responsable: {{ $inventory->user->name ?? 'N/A' }}</div>
                <div>Statut: {{ $inventory->status === 'validated' ? 'Validé' : 'Brouillon' }}</div>
            </td>
        </tr>
    </table>
</div>

<table class="lines">
    <thead>
    <tr>
        <th style="width: 15%">Emplacement</th>
        <th style="width: 10%">Réf.</th>
        <th style="width: 35%">Désignation</th>
        <th style="width: 10%">Unité</th>

        <th style="width: 10%" class="text-right">Théorique</th>
        <th style="width: 10%" class="text-right">Réel</th>
        <th style="width: 10%" class="text-right">Écart</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lines as $line)
        <tr>
            <td>{{ $line->location ?? '-' }}</td>
            <td>{{ $line->article->reference }}</td>
            <td>{{ $line->article->name }}</td>
            <td>{{ $line->article->unit->symbol ?? 'U' }}</td>

            <td class="text-right">{{ $line->expected_quantity + 0 }}</td>
            <td class="text-right font-bold">{{ $line->real_quantity + 0 }}</td>
            <td class="text-right {{ $line->difference < 0 ? 'text-red' : ($line->difference > 0 ? 'text-green' : '') }}">
                {{ $line->difference != 0 ? ($line->difference > 0 ? '+' : '') . ($line->difference + 0) : '-' }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="footer">
    Document généré le {{ now()->format('d/m/Y H:i') }} par Batistack. Page <span class="page-number"></span>
</div>

<script type="text/php">
    if (isset($pdf)) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $pdf->text(520, 820, "Page " . $PAGE_NUM . " / " . $PAGE_COUNT, $font, 10);
        ');
    }
</script>
</body>
</html>
