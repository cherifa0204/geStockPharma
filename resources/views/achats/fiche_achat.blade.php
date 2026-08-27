<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche Achat #{{ $achat->id }}</title>
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
            border-bottom: 2px solid #0d9488;
            padding-bottom: 15px;
        }
        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #0d9488;
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
            background-color: #ccfbf1;
            color: #0f766e;
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
            background-color: #0d9488;
            color: #ffffff;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            padding: 8px 10px;
            border: 1px solid #0d9488;
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
            width: 40%;
            margin-left: auto;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 6px 10px;
            font-size: 12px;
        }
        .totals-table .total-row {
            background-color: #f0fdf4;
            border: 1.5px solid #bbf7d0;
            color: #166534;
            font-weight: bold;
            font-size: 14px;
        }
        .signatures {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
        }
        .signatures td {
            width: 50%;
            vertical-align: top;
            font-size: 11px;
            color: #475569;
        }
        .sig-box {
            border-top: 1px dashed #cbd5e1;
            margin-top: 45px;
            padding-top: 5px;
            font-style: italic;
        }
    </style>
</head>
<body>

    @php 
        use Carbon\Carbon;
        $date = Carbon::parse($achat->created_at ?? $achat->updated_at)->format('d/m/Y');
    @endphp

    {{-- Document Header --}}
    <table class="header-table">
        <tr>
            <td style="vertical-align: top;">
                <div class="company-name">PHARMACIE THE NEWMAN</div>
                <div class="company-sub">Gestion des Stocks & Approvisionnements</div>
            </td>
            <td style="vertical-align: top;">
                <div class="doc-title">Fiche d'Achat</div>
                <div class="doc-meta">
                    N° Commande : <span class="badge">#{{ $achat->id }}</span><br>
                    Date d'enregistrement : <strong>{{ $date }}</strong>
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
            @php $totalAchat = 0; @endphp
            @forelse ($achat->ligneachats ?? [] as $ligne)
                @php $totalAchat += $ligne->montant_achat; @endphp
                <tr>
                    <td class="text-center" style="color: #94a3b8;">{{ $loop->index + 1 }}</td>
                    <td class="font-bold" style="color: #1e293b;">
                        {{ $ligne->produit->nom_produit ?? 'Produit supprimé' }}
                    </td>
                    <td class="text-right">
                        {{ $ligne->produit ? number_format($ligne->produit->prix_unitaire_achat, 0, ',', ' ') : '—' }} FCFA
                    </td>
                    <td class="text-right font-bold">{{ $ligne->quantite_achat }}</td>
                    <td class="text-right font-bold" style="color: #0d9488;">
                        {{ number_format($ligne->montant_achat, 0, ',', ' ') }} FCFA
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 20px; color: #94a3b8;">
                        Aucune ligne d'achat enregistrée.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Summary Table --}}
    <table class="totals-table">
        <tr class="total-row">
            <td class="text-right">TOTAL ACHAT :</td>
            <td class="text-right">{{ number_format($achat->montant_total_achat ?? $totalAchat, 0, ',', ' ') }} FCFA</td>
        </tr>
    </table>

    {{-- Signatures --}}
    <table class="signatures">
        <tr>
            <td>
                <div>Visa du Responsable Achats</div>
                <div class="sig-box">Signature & Cachet</div>
            </td>
            <td class="text-right">
                <div>Visa du Fournisseur / Réceptionnaire</div>
                <div class="sig-box">Signature & Date</div>
            </td>
        </tr>
    </table>

</body>
</html>


