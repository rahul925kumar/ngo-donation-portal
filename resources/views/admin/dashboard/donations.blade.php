@extends('donars.layouts.header')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- end page title -->
            <div class="row">
                <div class="col-xxl-5">
                    <div class="d-flex flex-column h-100">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="fw-medium text-muted mb-0">Total Donation Made's</p>
                                                <h2 class="mt-4 ff-secondary fw-semibold">Rs.<span class="counter-value" data-target="{{$donatedAmount + $eightyGAmount}}">0</span></h2>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div> <!-- end row-->
                    </div>
                </div> <!-- end col-->
            </div> <!-- end row-->
            <div class="row">
                <div class="col-xxl-12">
                    <h5 class="mb-3">Donation's List</h5>
                    <div class="card">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#donation" role="tab" aria-selected="false">
                                        Donation
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#80GDonation" role="tab" aria-selected="false">
                                        80G Donation's
                                    </a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content  text-muted">
                                <div class="tab-pane" id="donation" role="tabpanel">
                                    <table class="table caption-top table-nowrap" id="donation-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">Id</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($donations as $key => $donation)
                                            <tr>
                                                <th scope="row">{{$key+1}}</th>
                                                <td>{{urldecode($donation->name)}}</td>
                                                <td>Rs.{{$donation->amount}}</td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                                <td>{{$donation->created_on}}</td>
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
                                <div class="tab-pane active" id="80GDonation" role="tabpanel">
                                    <table class="table caption-top table-nowrap" id="donation-table-eighty">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">Id</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Number</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($eightyGDonations as $key => $donation)
                                            <tr>
                                                <th scope="row">{{$key+1}}</th>
                                                <td>{{urldecode($donation->name)}}</td>
                                                <td>{{$donation->number}}</td>
                                                <td>Rs.{{$donation->amount}}</td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                                <td>{{$donation->created_on}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <td colspan="5">Total</td>
                                                <td>Rs. {{$eightyGAmount}}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div>
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
    new DataTable('#donation-table');
    new DataTable('#donation-table-eighty');
</script>
@endsection