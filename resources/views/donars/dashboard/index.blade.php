@extends('donars.layouts.header')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css">
<style>
    .btn-orange101 {
    background: -webkit-gradient(linear,left top,right top,color-stop(28.12%,#ff7400),to(#f91717));
    background: -webkit-linear-gradient(left,#ff7400 28.12%,#f91717);
    background: -moz-linear-gradient(left,#ff7400 28.12%,#f91717 100%);
    background: linear-gradient(90deg,#ff7400 28.12%,#f91717);
    -webkit-border-radius: 10px;
    border-radius: 100px;
    border: none;
    color: #fff;
    cursor: pointer;
    font-family: Arial;
    font-size: 16px !important;
    text-align: center;
    text-decoration: none;
    -webkit-animation: glowing 1500ms infinite;
    -moz-animation: glowing 1500ms infinite;
    -o-animation: glowing 1500ms infinite;
    animation: glowing 1500ms infinite;
    text-transform: uppercase;
    font-weight: 600 !important;
    width: 100%;
    margin: 5px 0px;
    padding: 7px 10px;
    margin-left:30px;
}

.dd {
    -webkit-filter: drop-shadow(2px 2px 4px #222 );
    filter: drop-shadow(2px 2px 4px #222);
}

.btn-orange {
    border: none;
    background: -webkit-gradient(linear,left top,right top,color-stop(28.12%,#ff7400),to(#f91717));
    background: -webkit-linear-gradient(left,#ff7400 28.12%,#f91717);
    background: -moz-linear-gradient(left,#ff7400 28.12%,#f91717 100%);
    background: linear-gradient(90deg,#ff7400 28.12%,#f91717);
    color: #fff;
    padding: 7px 30px;
    font-weight: 600;
    -webkit-transition: all 0.2s;
    -moz-transition: all 0.2s;
    transition: all 0.2s;
    font-size: 16px;
    text-transform: uppercase;
    margin-top: 40px;
    margin-left:30px;
}

.btn-view {
  background-color: #ff7f50; /* default button color */
  color: white;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-view:hover {
  background-color: #ff5722; /* darker shade on hover */
  transform: scale(1.05); /* optional: slightly enlarge the button */
  cursor: pointer;
}

.profile-completion-wrapper {
    margin-bottom: 20px;
}

.progress-bar-container {
    width: 100%;
    background-color: #e0e0e0;
    border-radius: 20px;
    overflow: hidden;
    height: 20px;
}

.progress-bar-fill {
    height: 100%;
    background-color: #28a745;
    transition: width 0.5s;
}
</style>
@php
    $user = auth()->user();

    $fields = [
        $user->name,
        $user->email,
        $user->phone_number,
        $user->pan_number,
        $user->address,
        $user->state,
        $user->city,
        $user->pincode,
        $user->country,
        $user->reference_id,
        $user->date_of_birth,
        $user->source,
        $user->salutation,
        $user->dob,
        $user->user_img,
        $user->username
    ];

    $filled = collect($fields)->filter(function ($value) {
        return !empty($value);
    })->count();

    $total = count($fields);
    $percentage = ($total > 0) ? round(($filled / $total) * 100) : 0;
@endphp
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="https://gausevasociety.com/donations-for-gaushala/" target="_blank">
                                <input
                                    type="button"
                                    id="btnDonationInKind"
                                    class="btn-view subbtn sbmrgn sbmrgn11 btn-orange101 dd"
                                    value="Donation In Kind"
                                    style="margin: 25px;"
                                >
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{url('donor/online-donation')}}" target="_blank">
                                <input
                                    type="button"
                                    id="btnDonate"
                                    class="btn-view subbtn sbmrgn sbmrgn11  btn-orange101 dd"
                                    value="Donate Now"
                                    style="margin: 25px;"
                                >
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="d-flex flex-column h-100">
                        <div class="row">
                            <div class="col-xl-4 col-md-4">
                                <div class="card card-animate overflow-hidden" style="height: 220px;">
                                    <div class="card-body" style="z-index:1 ;">
                                        <div class="d-flex flex-column align-items-start w-100">
                                            <div class="d-flex align-items-center justify-content-between mb-3 w-100">
                                                 <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Profile</p>
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <img
                                                        src="/donation-portal/public/uploads/users/{{auth()->user()->user_img}}"
                                                        width="78"
                                                        alt=""
                                                        id="img_dashboard_profile"
                                                        style="border-radius:100%"
                                                    >
                                                    <div class="ms-2">
                                                        <h3 class="mb-0 fs-5">
                                                            <span id="spnusername1">{{$user->salutation}} {{$user->name}}</span>
                                                        </h3>
                                                        <p class="mb-0 text-black-50">
                                                            <span id="krishnayanid1">GAU0000074886</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="profile-completion-wrapper" style="margin-bottom: 20px; margin-top: 20px; width:100%">
                                                    <div class="progress-bar-container" style="width: 100%; background-color: #e0e0e0; border-radius: 20px; overflow: hidden; height: 25px; position: relative;">
                                                        <div class="progress-bar-fill" style="width: {{ $percentage }}%; background-color: #28a745; height: 100%; transition: width 0.5s; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                                            {{ $percentage }}%
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="card card-animate overflow-hidden" style="height: 220px;">
                                    <div class="position-absolute start-0" style="z-index: 0;margin-left: 50%; margin-top: 5%;">
                                        <img src="{{asset('public/assets/images/pngtree-donate.png')}}" height="150px">
                                    </div>
                                    <div class="card-body" style="z-index:1 ;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3"> Total Donations</p>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                                    Rs.
                                                    <span class="counter-value" data-target="{{$donatedAmount + $eightyGAmount}}">0</span>
                                                    /-
                                                </h4>
                                                <button
                                                    class="btn-view rounded-pill py-2 px-4 lang btn-orange"
                                                    key="View All My Receipts"
                                                    type="button"
                                                    onclick="location.href='/donation-portal/donor/donations'"
                                                >My Receipts</button>
                                               
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div
                                                    id="total_jobs"
                                                    data-colors='["--vz-success"]'
                                                    class="apex-charts"
                                                    dir="ltr"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!--end col-->
                            <div class="col-xl-4 col-md-4">
                                <div class="card card-animate overflow-hidden" style="height: 220px;">
                                    <div class="position-absolute start-0" style="z-index: 0;margin-left: 50%; margin-top: 5%;">
                                        <img src="{{asset('public/assets/images/pngtree-donate1.png')}}" height="150px">
                                    </div>
                                    <div class="card-body" style="z-index:1 ;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Monthly Donations</p>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                                    Rs.
                                                    <span class="counter-value" data-target="{{$monthly}}">0</span>
                                                    /-
                                                </h4>
                                                <button class="btn-view rounded-pill py-2 px-4 lang btn-orange" key="View All Details" onclick="location.href='/donation-portal/donor/donations'">Donation 80G</button>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div
                                                    id="total_jobs"
                                                    data-colors='["--vz-success"]'
                                                    class="apex-charts"
                                                    dir="ltr"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Notifications</h4>
                        </div>
                        <!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="table-responsive">
                                    <table class="table table-nowrap mb-0" id="donations-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">S.No.</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Particulars</th>
                                                <!--<th scope="col">Action</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($donations as $key => $donation)
                                            <tr>
                                                <th scope="row">{{$key+1}}</th>
                                                <td>{{ date('d-M-Y', strtotime($donation->created_on)) }}</td>
                                                <td>
                                                    <span class="badge bg-info">Pending</span>
                                                </td>
                                                <td>{{urldecode($donation->name)}} ({{$donation->phone_number}}) For the amount of Rs.{{$donation->amount}}</td>
                                                <!--<td>-->
                                                <!--    <a href="">View</a>-->
                                                <!--</td>-->
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <td colspan="4">Total</td>
                                                <td>Rs. {{$donatedAmount}}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    © Digiverse
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Design & Develop by Digiverse Technologies
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script>
new DataTable('#donations-table');
</script>
@endsection
