@extends('layouts.index')
@section('content')
    <div class="container-fluid">
        <div class="w-100 p-4 bg-white">
            <div class="row d-flex align-items-center">
                <div class="col-12 col-lg-7">
                    <h3 class="text-center font-weight-bold">Minum Obat Tepat Penyakit Lewat</h3>
                </div>
                <div class="col-12 col-lg-5">
                    <img src="{{ asset('img/banner.svg') }}" alt="banner" style="width: 100%; height: 22rem;">
                </div>
            </div>
        </div>
        <div class="mb-4">
            <h3 class="text-center my-5">Keunggulan Website Kami</h3>
            <div class="row">
                <div class="col-12 mt-3 mt-lg-0 col-md-6 col-lg-3">
                    <div class="card shadow-sm rounded-sm">
                        <div class="card-body">
                            <img src="{{ asset('img/jangkauan.svg') }}" style="width: 100%; height: 8rem" alt="jangkauan">
                            <h4 class="text-center mt-5">Jangkauan Luas</h4>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3 mt-lg-0 col-md-6 col-lg-3">
                    <div class="card shadow-sm rounded-sm">
                        <div class="card-body">
                            <img src="{{ asset('img/sistem.svg') }}" style="width: 100%; height: 8rem" alt="jangkauan">
                            <h4 class="text-center mt-5">Sistem Cerdas</h4>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3 mt-lg-0 col-md-6 col-lg-3">
                    <div class="card shadow-sm rounded-sm">
                        <div class="card-body">
                            <img src="{{ asset('img/pelayanan.svg') }}" style="width: 100%; height: 8rem" alt="jangkauan">
                            <h4 class="text-center mt-5">Pelayanan Terjamin</h4>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3 mt-lg-0 col-md-6 col-lg-3">
                    <div class="card shadow-sm rounded-sm">
                        <div class="card-body">
                            <img src="{{ asset('img/api.svg') }}" style="width: 100%; height: 8rem" alt="jangkauan">
                            <h4 class="text-center mt-5">Terintegrasi RS Lain</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-5 bg-white py-5 px-3">
            <div class="row d-flex align-items-center">
                <div class="col-12 col-md-5">
                    <img src="{{ asset('img/kesehatan.svg') }}" alt="kesehetan" style="width: 100%; height: 15rem;">
                </div>
                <div class="col-12 col-md-7 text-justify text-lg-center mt-5 mt-md-0">
                    <h3 class="mb-3 text-primary text-center">Kesehatan Anda Terjamin</h3>
                    <p class="mb-0" style="font-size: 1.1rem;">
                        Kami membantu keluhan anda ketika akan meminum obat dan melakukan pelayanan yang sangat terjamin untuk anda.
                    </p>
                </div>
            </div>
            <div class="row d-flex align-items-center my-4 my-md-5">
                <div class="col-12 col-md-7 text-justify text-lg-center">
                    <h3 class="mb-3 text-primary text-center">Jadwal Yang Akurat</h3>
                    <p class="mb-0" style="font-size: 1.1rem;">
                        Sistem monitoring waktu meminum obat yang sangat akurat dan terjamin.
                    </p>
                </div>
                <div class="col-12 col-md-5">
                    <img src="{{ asset('img/alarm.svg') }}" class="d-none d-md-block" alt="kesehetan" style="width: 100%; height: 15rem;">
                </div>
            </div>
            <div class="row d-flex align-items-center">
                <div class="col-12 col-md-5">
                    <img src="{{ asset('img/jadwal.svg') }}" class="d-none d-md-block" alt="kesehetan" style="width: 100%; height: 15rem;">
                </div>
                <div class="col-12 col-md-7 text-justify text-lg-center">
                    <h3 class="mb-3 text-primary text-center">Checkup Tepat Waktu</h3>
                    <p class="mb-0" style="font-size: 1.1rem;">
                        Mendapatkan jadwal checkup yang rutin
                    </p>
                </div>
            </div>
        </div>        
    </div>
@endsection