<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Ujian {{$user->id_user}} ({{$user->kd_mtk}})</title>

    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }

    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    .rtl table {
        text-align: right;
    }

    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
    
    <center><img src="http://elearning.bsi.ac.id/storage/icon/header_bsi.jpg"></center>
<center><span style="text-align:center;">Terima Kasih Anda Telah Mengikuti Ujian Online</span></center><br>

<table>
<tr>
    <td width="10%"></td>
    <td width="20%" style="background-color:#c7c7c7; text-align:left;">  NIM</td>
    <td width="1%" style="background-color:#c7c7c7;">:  </td>
    <td width="59%" style="background-color:#c7c7c7;">{{$user->id_user}}</td>
    <td width="10%"></td>
</tr>
<tr>
    <td width="10%"></td>
    <td width="20%" style="text-align:left;">Nama</td>
    <td width="1%">:  </td>
    <td width="59%">{{$user->name}}</td>
    <td width="10%"></td>
</tr>
<tr>
    <td width="10%"></td>
    <td width="20%" style="background-color:#c7c7c7; text-align:left;">Tanggal Ujian</td>
    <td style="background-color:#c7c7c7;">:  </td>
    <td width="59%" style="background-color:#c7c7c7;">{{$user->tgl_ujian}} - {{$user->tgl_selsai_ujian}}</td>
    <td width="10%"></td>
</tr>
<tr>
    <td width="10%"></td>
    <td width="20%" style="text-align:left;">Tanggal Mulai</td>
    <td >:  </td>
    <td width="59%" >{{$user->awal_ujian}} - {{$user->akhir_ujian}}</td>
    <td width="10%"></td>
</tr>

<tr>
<td width="10%"></td>
<td width="20%" style="background-color:#c7c7c7; text-align:left;">  Matakuliah</td>
<td style="background-color:#c7c7c7;">:  </td>
<td width="59%" style="background-color:#c7c7c7;">{{$user->nm_mtk}}</td>
<td width="10%"></td>
</tr>
<tr>
<td width="10%"></td>
<td width="20%" style="text-align:left;">  Jumlah Soal</td>
<td >:  </td>
<td width="59%" >{{$user->jml_soal}}</td>
<td width="10%"></td>
</tr>
<tr>
<td width="10%"></td>
<td width="20%" style="background-color:#c7c7c7; text-align:left;">  Jumlah Benar</td>
<td style="background-color:#c7c7c7;">:  </td>
<td width="59%" style="background-color:#c7c7c7;">
@if ($user->soal_benar==null)
    0
@else
    {{$user->soal_benar}}
@endif
</td>
<td width="10%"></td>
</tr>
<tr>
<td width="10%">
</td><td width="20%" style="text-align:left;">Jumlah Salah</td>
<td >:  </td>
<td width="59%" >{{$user->jml_soal - $user->soal_benar}}</td>
<td width="10%"></td>
</tr>
</table>
<br>
<center><span style="text-align:center;">
Simpan sebagai bukti bahwa anda telah mengikuti ujian online
</span></center>

<span style="text-align:center;font-size:12px;">
</span><br><br>
        <table cellpadding="0" cellspacing="0">
            
            <tr class="heading">
                <td>
                    Jawaban Anda
                </td>

                <td>
                    Hasil
                </td>
            </tr>
<?php foreach($soals as $nomer=>$soal){ ?>
            <tr class="item">
                <td>
                   {{$nomer+1}}. 
                   @if ($soal->pilihan=='A')
                    {{$soal->pila}}
                   @elseif ($soal->pilihan=='B')
                    {{$soal->pilb}}
                   @elseif ($soal->pilihan=='C')
                    {{$soal->pilc}}
                   @elseif ($soal->pilihan=='D')
                    {{$soal->pild}}
                   @else
                    {{$soal->pile}}
                   @endif
                   
                </td>

                <td>
                    
                    @if ($soal->kunci==$soal->pilihan)
                        B
                    @else
                        S
                    @endif
                    
                </td>
            </tr>
<?php } ?>
        </table>
    </div>
</body>
</html>