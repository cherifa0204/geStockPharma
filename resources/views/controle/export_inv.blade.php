
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inventaire {{ $date_debut }} au {{ $date_fin }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #334155;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 15px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-bottom: 2px solid #0f766e;
            padding-bottom: 12px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #0f766e;
            margin: 0;
            text-transform: uppercase;
        }
        .company-sub {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }
        .doc-title {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
            text-align: right;
            text-transform: uppercase;
            margin: 0;
        }
        .doc-meta {
            font-size: 10px;
            color: #475569;
            text-align: right;
            margin-top: 4px;
        }
        .badge {
            background-color: #ccfbf1;
            color: #0f766e;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .items-table th {
            background-color: #0f766e;
            color: #ffffff;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            padding: 7px 8px;
            border: 1px solid #0f766e;
        }
        .items-table td {
            padding: 7px 8px;
            border-bottom: 1px solid #e2e8f0;
            border-left: 1px solid #f1f5f9;
            border-right: 1px solid #f1f5f9;
            font-size: 10.5px;
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
            font-size: 11px;
        }
        .totals-table .total-row {
            background-color: #f0fdf4;
            border: 1.5px solid #bbf7d0;
            color: #166534;
            font-weight: bold;
            font-size: 13px;
        }
        .report-footer {
            margin-top: 30px;
            width: 100%;
            border-collapse: collapse;
        }
        .report-footer td {
            width: 50%;
            vertical-align: top;
            font-size: 10px;
            color: #64748b;
        }
        .sig-box {
            border-top: 1px dashed #cbd5e1;
            margin-top: 40px;
            padding-top: 4px;
            font-style: italic;
        }
    </style>
</head>
<body>

    @php
        use Carbon\Carbon;
        $debut = Carbon::parse($date_debut)->format('d/m/Y'); 
        $fin = Carbon::parse($date_fin)->format('d/m/Y'); 
        $totalVenteGlobal = 0;
    @endphp

    {{-- Header --}}
    <table class="header-table">
        <tr>
            <td style="vertical-align: top;">
                <div class="company-name">PHARMACIE THE NEWMAN</div>
                <div class="company-sub">Rapport & Contrôle d'Inventaire</div>
            </td>
            <td style="vertical-align: top;">
                <div class="doc-title">Inventaire Hebdomadaire</div>
                <div class="doc-meta">
                    Période du : <span class="badge">{{ $debut }}</span> au <span class="badge">{{ $fin }}</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- Inventory Table --}}
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 35%;">Désignation Produit</th>
                <th style="width: 12%;" class="text-right">Qté Initiale</th>
                <th style="width: 12%;" class="text-right">Qté Entrée</th>
                <th style="width: 12%;" class="text-right">Qté Vendue</th>
                <th style="width: 13%;" class="text-right">Qté Actuelle</th>
                <th style="width: 16%;" class="text-right">Montant Vente</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produits ?? [] as $prd)
                @php
                    $inv = $prd->inventaire_prd($date_debut, $date_fin);
                    $totalVenteGlobal += $inv["total_vente"] ?? 0;
                @endphp
                <tr>
                    <td class="font-bold" style="color: #1e293b;">
                        {{ $inv["nom_produit"] }}
                    </td>
                    <td class="text-right">{{ $inv["quantite_initiale"] }}</td>
                    <td class="text-right font-bold" style="color: #0284c7;">
                        {{ $inv["quantite_entre"] > 0 ? '+'.$inv["quantite_entre"] : 0 }}
                    </td>
                    <td class="text-right font-bold" style="color: #d97706;">
                        {{ $inv["quantite_sortie"] }}
                    </td>
                    <td class="text-right font-bold" style="color: #0f766e;">
                        {{ $prd->quantite_stock }}
                    </td>
                    <td class="text-right font-bold" style="color: #15803d;">
                        {{ number_format($inv["total_vente"] ?? 0, 0, ',', ' ') }} FCFA
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px; color: #94a3b8;">
                        Aucun produit répertorié pour cet inventaire.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Summary --}}
    <table class="totals-table">
        <tr class="total-row">
            <td class="text-right">TOTAL VENTES PÉRIODE :</td>
            <td class="text-right">{{ number_format($totalVenteGlobal, 0, ',', ' ') }} FCFA</td>
        </tr>
    </table>

    {{-- Signatures --}}
    <table class="report-footer">
        <tr>
            <td>
                <div>Responsable de Stock</div>
                <div class="sig-box">Signature</div>
            </td>
            <td class="text-right">
                <div>Direction / Pharmacien Titulaire</div>
                <div class="sig-box">Signature & Cachet</div>
            </td>
        </tr>
    </table>

</body>
</html>
