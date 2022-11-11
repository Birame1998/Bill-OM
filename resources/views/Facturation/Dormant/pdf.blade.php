<!DOCTYPE html>
<html>
    <style>
        table {
        border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        table thead {
            display: table-row-group;
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
                    <th colspan="8" style="text-align: center;font-size: 14px"><em>LISTE DES COMPTES DORMANTS DE CE MOIS-CI</em></th>
                </tr>
                <tr style="background-color:black; border: 1px solid black">
                    <th style="color: #f5d9c2;">NUM AP</th>
                    <th style="color: #f5d9c2;">NOM PARTENAIRE</th>
                    <th style="color: #f5d9c2;">SIM HEAD</th>
                    <th style="color: #f5d9c2;">COMPTE BANCAIRE</th>
                    <th style="color: #f5d9c2;">ONGLET FACTURATION</th>
                </tr>
            </thead>
            <tbody style="width: 100%;">
                @foreach ($partenaires as $val)
                    <tr>
                        <td>{{$val->num_ap}}</td>
                        <td>{{$val->nom_partenaire}}</td>
                        <td>
                            @foreach($val->sim_designation as $value)
                            <li style="list-style-type: none;">{{ $value->sim_head }}</li>
                            @endforeach
                        </td>
                        <td>{{$val->compte_bancaire}}</td>
                        <td>
                            @foreach($val->sim_designation as $value)
                                <li style="list-style-type: none;">{{ $onglet_facturation[$value->onglet_facturation_id]['libelle'] }}</li>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
