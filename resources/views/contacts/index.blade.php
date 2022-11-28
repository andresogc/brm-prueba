@extends('layouts.app')
@section('content')


<div class="main">
    <div class="container-fluid" id="main">
        <div class="row row-offcanvas row-offcanvas-left vh-100 ">
            {{-- inicio sidebar --}}
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-2 col-lg-3 sidebar-offcanvas h-100 overflow-auto bg-dark pl-0" id="sidebar" role="navigation" >
                <list-component/>
            </div>
            {{-- fin sidebar --}}
            <!--/col-->
            <main class="col main p-0  m-0 h-100 overflow-auto ">
                {{-- inicio navbar --}}
                    @include('layouts.nav.navbar')
                {{-- fin navbar --}}
                <div class="col-md-12 d-flex justify-content-center">
                    <router-view></router-view>
                </div>
            </main>
            <!--/main col-->
        </div>

    </div>
</div>

@endsection
