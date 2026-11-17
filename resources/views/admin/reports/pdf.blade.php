<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Laporan Keuangan Pemuda Berkelana
    </title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {

            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #111827;
            margin: 0;
            padding: 0;

        }

        .header {

            text-align: center;
            margin-bottom: 18px;

        }

        .company {

            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;

        }

        .title {

            margin-top: 6px;
            font-size: 17px;
            font-weight: bold;

        }

        .subtitle {

            font-size: 12px;
            color: #555;
            margin-top: 2px;

        }

        hr {

            border: none;
            border-top: 2px solid #444;
            margin: 18px 0;

        }

        .info {

            width: 100%;
            margin-bottom: 20px;

        }

        .info td {

            border: none;
            padding: 2px 0;

        }

        .section {

            margin-top: 20px;
            margin-bottom: 8px;

            font-size: 13px;
            font-weight: bold;

        }

        table {

            width: 100%;
            border-collapse: collapse;

        }

        th {

            background: #374151;
            color: white;
            border: 1px solid #666;
            padding: 8px;

            text-align: center;

        }

        td {

            border: 1px solid #d1d5db;
            padding: 7px;

        }

        .summary td:first-child {

            width: 70%;

        }

        .summary td {

            padding: 8px;

        }

        .summary tr:last-child {

            font-weight: bold;
            background: #f3f4f6;

        }

        .text-center {

            text-align: center;

        }

        .text-right {

            text-align: right;

        }

        .bg-total {

            background: #f3f4f6;
            font-weight: bold;

        }

        .footer {

            margin-top: 40px;

        }

        .signature {

            width: 240px;
            float: right;
            text-align: center;

        }
    </style>

</head>

<body>

    <div class="header">

        <div class="company">

            PEMUDA BERKELANA

        </div>

        <div class="title">

            LAPORAN KEUANGAN

        </div>

        <div class="subtitle">

            Persewaan Alat Camping & Outdoor

        </div>

    </div>

    <hr>

    <table class="info">

        <tr>

            <td width="18%">
                <strong>Periode</strong>
            </td>

            <td width="82%">

                :

                {{ \Carbon\Carbon::parse($request->start_date)->format('d M Y') }}

                s/d

                {{ \Carbon\Carbon::parse($request->end_date)->format('d M Y') }}

            </td>

        </tr>

        <tr>

            <td>

                <strong>Tanggal Cetak</strong>

            </td>

            <td>

                :

                {{ now()->format('d M Y H:i') }}

            </td>

        </tr>

    </table>

    <div class="section">

        Ringkasan Keuangan

    </div>

    <table class="summary">

        <tr>

            <td>

                Pendapatan Sewa

            </td>

            <td class="text-right">

                Rp {{ number_format($totalRevenue, 0, ',', '.') }}

            </td>

        </tr>

        <tr>

            <td>

                Deposit Diterima

            </td>

            <td class="text-right">

                Rp {{ number_format($totalDepositReceived, 0, ',', '.') }}

            </td>

        </tr>

        <tr>

            <td>

                Pendapatan Denda

            </td>

            <td class="text-right">

                Rp {{ number_format($totalPenaltyRevenue, 0, ',', '.') }}

            </td>

        </tr>

        <tr class="bg-total">

            <td>

                Total Uang Masuk

            </td>

            <td class="text-right">

                Rp {{ number_format($totalCashIn, 0, ',', '.') }}

            </td>

        </tr>

        <tr>

            <td>

                Deposit Dikembalikan

            </td>

            <td class="text-right">

                (Rp {{ number_format($totalDepositReturned, 0, ',', '.') }})

            </td>

        </tr>

        <tr class="bg-total">

            <td>

                Total Kas Bersih

            </td>

            <td class="text-right">

                Rp {{ number_format($totalNetCash, 0, ',', '.') }}

            </td>

        </tr>

    </table>

    <div class="section">

        Laporan Transaksi Keuangan

    </div>

    <table>

        <thead>

            <tr>

                <th width="4%">
                    No
                </th>

                <th width="10%">
                    Tanggal
                </th>

                <th width="14%">
                    Invoice
                </th>

                <th width="18%">
                    Customer
                </th>

                <th width="12%">
                    Pendapatan
                </th>

                <th width="10%">
                    Deposit
                </th>

                <th width="10%">
                    Denda
                </th>

                <th width="12%">
                    Deposit Kembali
                </th>

                <th width="10%">
                    Total Masuk
                </th>

                <th width="10%">
                    Status
                </th>

            </tr>

        </thead>

        <tbody>

            @foreach($orders as $order)

                        <tr>

                            <td class="text-center">

                                {{ $loop->iteration }}

                            </td>

                            <td class="text-center">

                                {{ $order->created_at->format('d/m/Y') }}

                            </td>

                            <td>

                                {{ $order->invoice_number }}

                            </td>

                            <td>

                                {{ $order->customer_name }}

                            </td>

                            <td class="text-right">

                                Rp
                                {{ number_format($order->payment_status == \App\Models\Order::PAYMENT_PAID ? $order->total_price : 0, 0, ',', '.') }}

                            </td>

                            <td class="text-right">

                                Rp
                                {{ number_format($order->payment_status == \App\Models\Order::PAYMENT_PAID ? $order->deposit : 0, 0, ',', '.') }}

                            </td>

                            <td class="text-right">

                                Rp
                                {{ number_format($order->payment_status == \App\Models\Order::PAYMENT_PAID ? $order->total_penalty : 0, 0, ',', '.') }}

                            </td>

                            <td class="text-right">

                                Rp {{ number_format($order->deposit_returned ? $order->deposit_return : 0, 0, ',', '.') }}

                            </td>

                            <td class="text-right">

                                Rp {{ number_format(
                    $order->payment_status == \App\Models\Order::PAYMENT_PAID
                    ? $order->total_price + $order->deposit + $order->total_penalty
                    : 0
                    ,
                    0,
                    ',',
                    '.'
                ) }}

                            </td>

                            <td class="text-center">

                                {{ strtoupper($order->payment_status) }}

                            </td>

                        </tr>

            @endforeach
        </tbody>

        <tfoot>

            <tr class="bg-total">

                <td colspan="4" class="text-right">

                    <strong>TOTAL</strong>

                </td>

                <td class="text-right">

                    <strong>

                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}

                    </strong>

                </td>

                <td class="text-right">

                    <strong>

                        Rp {{ number_format($totalDepositReceived, 0, ',', '.') }}

                    </strong>

                </td>

                <td class="text-right">

                    <strong>

                        Rp {{ number_format($totalPenaltyRevenue, 0, ',', '.') }}

                    </strong>

                </td>

                <td class="text-right">

                    <strong>

                        Rp {{ number_format($totalDepositReturned, 0, ',', '.') }}

                    </strong>

                </td>

                <td class="text-right">

                    <strong>

                        Rp {{ number_format($totalCashIn, 0, ',', '.') }}

                    </strong>

                </td>

                <td>

                </td>

            </tr>

        </tfoot>

    </table>

    <div class="section">

        Detail Denda

    </div>

    <table class="summary">

        <tr>

            <td>

                Denda Keterlambatan

            </td>

            <td class="text-right">

                Rp {{ number_format($totalLateFee, 0, ',', '.') }}

            </td>

        </tr>

        <tr>

            <td>

                Denda Barang Hilang

            </td>

            <td class="text-right">

                Rp {{ number_format($totalMissingFee, 0, ',', '.') }}

            </td>

        </tr>

        <tr>

            <td>

                Denda Kerusakan Barang

            </td>

            <td class="text-right">

                Rp {{ number_format($totalDamagePenalty, 0, ',', '.') }}

            </td>

        </tr>

        <tr class="bg-total">

            <td>

                Total Pendapatan Denda

            </td>

            <td class="text-right">

                Rp {{ number_format($totalPenaltyRevenue, 0, ',', '.') }}

            </td>

        </tr>

    </table>

    <div class="section">

        Ringkasan Inventaris

    </div>

    <table class="summary">

        <tr>

            <td>

                Barang Perlu Servis

            </td>

            <td class="text-right">

                {{ $serviceItems }}

            </td>

        </tr>

        <tr>

            <td>

                Barang Rusak

            </td>

            <td class="text-right">

                {{ $damagedItems }}

            </td>

        </tr>

        <tr>

            <td>

                Barang Hilang

            </td>

            <td class="text-right">

                {{ $lostItems }}

            </td>

        </tr>

    </table>

    <div class="section">

        Statistik Operasional

    </div>

    <table class="summary">

        <tr>

            <td>

                Total Transaksi

            </td>

            <td class="text-right">

                {{ number_format($totalTransactions, 0, ',', '.') }}

            </td>

        </tr>

        <tr>

            <td>

                Order Lunas

            </td>

            <td class="text-right">

                {{ number_format($totalPaid, 0, ',', '.') }}

            </td>

        </tr>

        <tr>

            <td>

                Order Pending

            </td>

            <td class="text-right">

                {{ number_format($totalPending, 0, ',', '.') }}

            </td>

        </tr>

        <tr>

            <td>

                Order Dibatalkan

            </td>

            <td class="text-right">

                {{ number_format($totalCancelled, 0, ',', '.') }}

            </td>

        </tr>

    </table>

    <br><br>

    <table style="border:none;">

        <tr>

            <td style="border:none; width:60%;">

            </td>

            <td style="border:none; text-align:center;">

                Surabaya,

                {{ now()->format('d M Y') }}

                <br><br>

                Administrator

                <br><br><br><br><br>

                <strong>

                    Kadek Diva Adiyasah

                </strong>

            </td>

        </tr>

    </table>

</body>

</html>