<!DOCTYPE html>
<html>
    <style>
        table {
        border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
    </style>
    <body style="font-size: 12px">
        <div class="row">
            <div>
                &nbsp; DIRECTION POLE ORANGE MONEY <br>
                &nbsp; DEPARTEMENT OPERATIONS <br>
                &nbsp; POLE OPERATIONSFINANCIERES
            </div>
            <div>
                <h5 align="center">ORANGE MONEY LE {{$date}}</h5><br>
            </div>
        </div>
        <table border="1" style="width: 100%; border: 1px solid black">
            <thead style="font-size: 11px; border: 1px solid black">
                <tr style="background-color:#fabf8f;border: 1px solid black">
                    <th colspan="8" style="text-align: center;font-size: 14px"><em>RECAP FACTURES</em></th>
                </tr>
                <tr style="background-color:black; border: 1px solid black">
                    <th style="color: #f5d9c2;">DATE FACTURATION</th>
                    <th style="color: #f5d9c2;">N° TIERS</th>
                    <th style="color: #f5d9c2;">PARTENAIRES</th>
                    <th style="color: #f5d9c2;">TYPE</th>
                    <th style="color: #f5d9c2;">MONTANTS FACTURES</th>
                    <th style="color: #f5d9c2;">MONTANTS COMMISSIONS</th>
                    <th style="color: #f5d9c2;">MONTANT A REVERSER</th>
                    <th style="color: #f5d9c2;">N° COMPTE BANCAIRE</th>
                </tr>
            </thead>
            @if ($factBool)
            <tbody>
                @foreach ($facture as $val)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($val->date_transaction)) }}</td>
                        <td>{{$val->num_ap}}</td>
                        <td>{{$val->nom_partenaire}}</td>
                        <td>{{ $onglet_facturation[$val->onglet_facturation_id]['libelle'] }}</td>
                        <td style="text-align: right">{{ number_format($val->transaction_amount, 2, ","," ") }}</td>
                        <td style="text-align: right">{{ number_format($val->commission, 2, ","," " )}}</td>
                        <td style="text-align: right">{{ number_format($val->a_reverser, 2, ","," " ) }}</td>
                        <td>{{$val->compte_bancaire}}</td>
                    </tr>
                @endforeach
            @else
                @forelse($facturePill as $val)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($val->date_transaction)) }}</td>
                        <td>{{$val->num_ap}}</td>
                        <td>{{$val->nom_partenaire}}</td>
                        <td>{{ $onglet_facturation[$val->onglet_facturation_id]['libelle'] }}</td>
                        <td style="text-align: right">{{ number_format($val->transaction_amount, 2, ","," ") }}</td>
                        <td style="text-align: right">{{ number_format($val->commission, 2, ","," " )}}</td>
                        <td style="text-align: right">{{ number_format($val->a_reverser, 2, ","," " ) }}</td>
                        <td>{{$val->compte_bancaire}}</td>
                    </tr>
                    @empty
                    <tr>PAS DE FACTURE DISPONIBLE</tr>
                    @endforelse    
                    <tr>
                        <td colspan="6" style="text-align: center;background-color:#948a54;border: 1px solid black"><b>SOUS-TOTAL PASS ILLIMIX</b></td>
                        <td style="text-align: right"><b>{{ number_format($facture_pill_sum, 2, ","," " ) }}</b></td>
                        <td></td>
                    </tr>
                    @forelse($facturePi as $val)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($val->date_transaction)) }}</td>
                        <td>{{$val->num_ap}}</td>
                        <td>{{$val->nom_partenaire}}</td>
                        <td>{{ $onglet_facturation[$val->onglet_facturation_id]['libelle'] }}</td>
                        <td style="text-align: right">{{ number_format($val->transaction_amount, 2, ","," ") }}</td>
                        <td style="text-align: right">{{ number_format($val->commission, 2, ","," " )}}</td>
                        <td style="text-align: right">{{ number_format($val->a_reverser, 2, ","," " ) }}</td>
                        <td>{{$val->compte_bancaire}}</td>
                    </tr>
                    @empty
                    <tr>PAS DE FACTURE DISPONIBLE</tr>
                    @endforelse    
                    <tr>
                        <td colspan="6" style="text-align: center;background-color:#948a54;border: 1px solid black"><b>SOUS-TOTAL ACHATS PASS INTERNET</b></td>
                        <td style="text-align: right"><b>{{ number_format($facture_pi_sum, 2, ","," " ) }}</b></td>
                        <td></td>
                    </tr>
                    @forelse($facturePtups as $val)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($val->date_transaction)) }}</td>
                        <td>{{$val->num_ap}}</td>
                        <td>{{$val->nom_partenaire}}</td>
                        <td>{{ $onglet_facturation[$val->onglet_facturation_id]['libelle'] }}</td>
                        <td style="text-align: right">{{ number_format($val->transaction_amount, 2, ","," ") }}</td>
                        <td style="text-align: right">{{ number_format($val->commission, 2, ","," " )}}</td>
                        <td style="text-align: right">{{ number_format($val->a_reverser, 2, ","," " ) }}</td>
                        <td>{{$val->compte_bancaire}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">PAS DE FACTURE DISPONIBLE POUR CET ONGLET DE FACTURATION</td>
                    </tr>
                    @endforelse 
                    <tr>
                        <td colspan="6" style="text-align: center;background-color:#948a54;border: 1px solid black"><b>SOUS-TOTAL PTUPS</b></td>
                        <td style="text-align: right"><b>{{ number_format($facture_ptups_sum, 2, ","," " ) }}</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td  style="height: 5px;"></td>
                        <td  style="height: 5px;"></td>
                        <td  style="height: 5px;"></td>
                        <td  style="height: 5px;"></td>
                        <td  style="height: 5px;"></td>
                        <td  style="height: 5px;"></td>
                        <td  style="height: 5px;"></td>
                        <td  style="height: 5px;"></td>
                    </tr>   
                   
                <tr>
                    <td colspan="6" style="text-align: center;background-color:#948a54;border: 1px solid black"><b>TOTAL GENERAL</b></td>
                    <td style="text-align: right;background-color:#948a54;border"><b>{{ number_format($facture_sum, 2, ","," " ) }}</b></td>
                    <td></td>
                </tr>
            </tbody>

            @endif
        </table>
        <br>
        {{-- <div style="width: 25%">
            <div style="border: 1px solid;"><br>
                &nbsp; VISA <br>
                &nbsp; RESPONSABLE OPERATIONS <br>
                &nbsp; FINANCIERES DOM-DO <br>
            </div>
        </div> --}}
        <br> <br>
        {{-- <div style="width: 25%">
            <div style="border: 1px solid;"><br>
                &nbsp; Facture validée par : <br>
                &nbsp; Soda FAYE <br>
                &nbsp; Date: {{$date}} <br>
            <div>
        </div> --}}
    </body>
</html>
