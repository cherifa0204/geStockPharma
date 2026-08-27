<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu Vente #{{ $vente->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #334155;
            font-size: 12px;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border-bottom: 2px solid #059669;
            padding-bottom: 15px;
        }
        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #059669;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .company-sub {
            font-size: 11px;
            color: #64748b;
            margin-top: 3px;
        }
        .doc-title {
            font-size: 18px;
            font-weight: bold;
            color: #0f172a;
            text-align: right;
            text-transform: uppercase;
            margin: 0;
        }
        .doc-meta {
            font-size: 11px;
            color: #475569;
            text-align: right;
            margin-top: 4px;
        }
        .badge {
            background-color: #d1fae5;
            color: #047857;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: bold;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .items-table th {
            background-color: #059669;
            color: #ffffff;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            padding: 8px 10px;
            border: 1px solid #059669;
        }
        .items-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            border-left: 1px solid #f1f5f9;
            border-right: 1px solid #f1f5f9;
            font-size: 11px;
        }
        .items-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .font-bold {
            font-weight: bold;
        }
        .totals-table {
            width: 45%;
            margin-left: auto;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 8px 10px;
            font-size: 12px;
        }
        .totals-table .total-row {
            background-color: #ecfdf5;
            border: 1.5px solid #a7f3d0;
            color: #065f46;
            font-weight: bold;
            font-size: 14px;
        }
        .receipt-footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }
    </style>
</head>
<body>

    @php 
        use Carbon\Carbon;
        $date = Carbon::parse($vente->created_at ?? $vente->updated_at)->format('d/m/Y H:i');
    @endphp

    {{-- Document Header --}}
    <table class="header-table">
        <tr>
            <td style="vertical-align: top;">
                <div class="company-name">PHARMACIE THE NEWMAN</div>
                <div class="company-sub">Reçu de Vente & Caisse</div>
            </td>
            <td style="vertical-align: top;">
                <div class="doc-title">Reçu de Vente</div>
                <div class="doc-meta">
                    N° Ticket : <span class="badge">#{{ $vente->id }}</span><br>
                    Date & Heure : <strong>{{ $date }}</strong>
                </div>
            </td>
        </tr>
    </table>

    {{-- Items Table --}}
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">#</th>
                <th style="width: 45%;">Désignation Produit</th>
                <th style="width: 15%;" class="text-right">Prix Unitaire</th>
                <th style="width: 15%;" class="text-right">Quantité</th>
                <th style="width: 20%;" class="text-right">Montant Total</th>
            </tr>
        </thead>
        <tbody>
            @php $totalVente = 0; @endphp
            @forelse ($vente->ligneventes ?? [] as $ligne)
                @php 
                    $montantLigne = $ligne->montant ?? (($ligne->produit->prix_unitaire_vente ?? 0) * $ligne->quantite_vente);
                    $totalVente += $montantLigne;
                @endphp
                <tr>
                    <td class="text-center" style="color: #94a3b8;">{{ $loop->index + 1 }}</td>
                    <td class="font-bold" style="color: #1e293b;">
                        {{ $ligne->produit->nom_produit ?? 'Produit supprimé' }}
                    </td>
                    <td class="text-right">
                        {{ $ligne->produit ? number_format($ligne->produit->prix_unitaire_vente, 0, ',', ' ') : '—' }} FCFA
                    </td>
                    <td class="text-right font-bold">{{ $ligne->quantite_vente }}</td>
                    <td class="text-right font-bold" style="color: #059669;">
                        {{ number_format($montantLigne, 0, ',', ' ') }} FCFA
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 20px; color: #94a3b8;">
                        Aucune ligne de vente enregistrée.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Summary Table --}}
    <table class="totals-table">
        <tr class="total-row">
            <td class="text-right">NET À PAYER :</td>
            <td class="text-right">{{ number_format($vente->montant_total ?? $totalVente, 0, ',', ' ') }} FCFA</td>
        </tr>
    </table>

    <div class="receipt-footer">
        Merci pour votre confiance ! Les médicaments vendus ne sont ni repris ni échangés.<br>
        <strong>PHARMACIE THE NEWMAN</strong> — Service Clientèle & Caisse
    </div>

</body>
</html>





