@extends('donars.layouts.header')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="d-flex flex-column h-100">
                        <div class="row">
                            <div class="col-xl-4 col-md-4">
                                <div class="card card-animate overflow-hidden" style="height: 200px;">
                                    <div class="position-absolute start-0" style="z-index: 0;margin-left: 50%; margin-top: 5%;">
                                        <img src="{{asset('assets/images/pngtree-donate.png')}}" height="150px">
                                    </div>
                                    <div class="card-body" style="z-index:1 ;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3"> Total Donations</p>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">Rs.<span class="counter-value" data-target="{{$donatedAmount + $eightyGAmount}}">0</span>/-</h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div id="total_jobs" data-colors='["--vz-success"]' class="apex-charts" dir="ltr"></div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!--end col-->
                            <div class="col-xl-4 col-md-4">
                                <div class="card card-animate overflow-hidden" style="height: 200px;">
                                    <div class="position-absolute start-0" style="z-index: 0;margin-left: 50%; margin-top: 5%;">
                                        <img src="{{asset('assets/images/pngtree-donate1.png')}}" height="150px">
                                    </div>
                                    <div class="card-body" style="z-index:1 ;">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-3"> Monthly Donations</p>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">Rs.<span class="counter-value" data-target="{{$monthly}}">0</span>/-</h4>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div id="total_jobs" data-colors='["--vz-success"]' class="apex-charts" dir="ltr"></div>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!--end col-->
                        </div><!--end row-->
                    </div>
                </div><!--end col-->
            </div><!--end row-->

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Notifications</h4>
                        </div><!-- end card header -->

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
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($donations as $key => $donation)
                                            <tr>
                                                <th scope="row">{{$key+1}}</th>
                                                <td>{{ date('d-M-Y', strtotime($donation->created_on)) }}</td>
                                                <td><span class="badge bg-info">Pending</span></td>
                                                <td>{{urldecode($donation->name)}} ({{$donation->phone_number}}) For the amount of Rs.{{$donation->amount}}</td>
                                                <td><a href="">View</a></td>
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

                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div><!-- end col -->

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
                    </script> © Digiverse
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