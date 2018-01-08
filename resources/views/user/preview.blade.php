<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Print</title>
        <style>
            body {
                background-color : white;
                padding :0;
                margin :0;
            }
            body, table {
                font-family:Arial, Helvetica, sans-serif;
                font-size:12px;
            }
            
            h1,h2,h3,h4,h5,h6 {
                margin: 0;
            }            
            .container {
                padding: 10px;                
            }
            .kop {
                border-bottom: 2px solid black;
                padding-bottom: 10px;
                margin-bottom: 20px;
            }
            .logo {
                width: 30%;
                display: inline-block;
                position: relative;
                height: 60px;
            }
            .logo img {
                position: absolute;
                right: 0;
                top: 0;
                width: 80px;
            }
            
            .judul {
                width: 50%;
                text-align: center;
                display: inline-block;
                vertical-align: top;
                padding-top: 10px;
            }
            .table {
                border-collapse: collapse;                
            }
            .table-akun-info {
                font-size: 18px;
                width: 80%;
                margin: 10px auto;
                font-weight: bold;
            }
            .table-akun-info small {
                font-size: 10px;
            }            
            .table-akun-info td {
                border: 1px solid black;
                padding: 10px;
            }
            .table-instansi-info{

            }
            .table-instansi-info td {
                padding: 5px;
            }
            .footnote {
                margin-top: 70px;
            }
        </style>
    </head>
    <body >
        <div class="container">
            <div class="row kop">
                <div class="col-sm-2 logo">
                    <img src="http://www.ayomondok.net/assets/images/LogoAyoMondok.png" alt="">                    
                </div>
                <div class="col-sm-6 judul">
                    <div class="row text-center">
                        <div class="col-12">
                            <h2>Surat Cetak Akun User</<h2>
                        </div>
                        <div class="col-12">
                            <h2>SimPONDOK</<h2>
                        </div>

                    </div>
                </div>
            </div>                    
        
        
            <div class="row">
                <p class="col">
                Selamat, Anda telah ditambahkan, dengan keterangan akun sebagai berikut:
                </p>
            </div>
            <div class="row justify-content-center">
                <div class="col">
                    <table class="table table-borderless table-instansi-info">
                        <tbody>
                            <tr>
                                <td width="150px">Nama Pengguna</td>
                                <td width="10px">:</td>
                                <td width="auto">{{$name}}</td>
                            </tr>
                            
                            
                            <tr>
                                <td width="150px">Grup Pengguna</td>
                                <td width="10px">:</td>
                                <td width="auto">
                                    @php
                                        $i=0;
                                    @endphp
                                    @foreach($roles as $rl)
                                        {{ $i>0 ? ', '.$rl['display_name']:$rl['display_name']}}
                                        @php $i++; @endphp
                                    @endforeach
                                </td>
                            </tr>
                            
                            
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="row">
                <p class="col">
                Untuk dapat masuk ke dalam akun Instansi anda, silakan login ke situs https://simpondok.id menggunakan akun yang telah didaftarkan berikut:                
                </p>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <table class="table table-bordered table-akun-info">
                        <tbody>
                            <tr>
                                <td width="150px">Akun Email</td>
                                <td width="10px">:</td>
                                <td width="auto">{{ $email }}</td>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td>:</td>
                                <td>P455w0rd</td>
                               
                            </tr>                
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <small class="col">
                    <i>~ e-Learning menggunakan integrasi authentifikasi SSO (Single Sign On) dengan layanan SIAP Online. ~</i>
                </small>            
            </div>
            <br/>
            <br/>
            <div class="row">
                
                <p class="col-12">
                Silahkan login ke halaman https://simpondok.id menggunakan akun email dan password yang sudah terdaftar ke layanan SIAP Online.
                </p>
                <p class="col-12">
                Untuk informasi dan panduan selengkapnya dapat diakses di <a href="https://simpondok.id">https://simpondok.id<a/>
                </p>
                <p class="col-12">
                Jika terjadi kendala, Anda dapat menghubungi <a href="mailto:support@simpondok.com">support@simpondok.id</a>
                </p>
            </div>
            <div class="row footnote">
                <small class="col">
                    <i>
                    *Dokumen ini dihasilkan secara otomatis dari sistem dan dinyatakan sebagai dokumen
                    <strong>sah</strong>
                    </i>
                </small>    
            </div>
        </div>
    </body>

</html>
