@extends('modules.common')

@section('content')
    <main class="main bg-gray">
        <div class="page-lost-wrapper relative">
            <div class="earth-fly"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-lost relative">
                            <div class="spaceship mx-auto">
                                <img src="{{ url('/images/spaceship404.png') }}" alt="太空船404">
                            </div>
                            <h2>哎呀！你要找的頁面從這個世界上消失了</h2>
                            <a class="btn btn-main w-25 mx-auto" href="{{ url('') }}">回首頁</a>
                            <img class="mt-4" src="{{ url('/images/maji.png?1620636991') }}" alt="麻吉妹妹">
                            <div class="armstrong">
                                <img src="{{ url('/images/armstrong.png') }}" alt="太空人">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection