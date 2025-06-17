@extends('donars.layouts.header')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- end page title -->

            <div class="row">
                <div class="col-xxl-12">
                    <div class="flex-shrink-0" style="height: 80px;">
                        <h5 class="mb-3">Donation's List</h5>
                        <form action="{{url('donor/donations')}}" method="GET" style="float:right; margin-top:-10px; display: flex;">
                            <div class="">
                                <select class="form-select mb-3" name="status" aria-label="Default select example">
                                    <option value="null" selected>---Select---</option>
                                    <option value="pending">Pending</option>
                                    <option value="complete">Complete</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Search</button>
                            </div>
                        </form>
                    </div>
                     <table class="table caption-top table-nowrap" id="donation-table-eighty">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">SNo.</th>
                                                <th scope="col">Receipt No.</th>
                                                <th scope="col">Payment Date</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Payment Status</th>
                                                <th scope="col">Payment Mode</th>
                                                <th scope="col">Source</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($eightyGDonations as $key => $donation)
                                            <tr>
                                                <th scope="row">{{$key+1}}</th>
                                                <td>
                                                    @if($donation->payment_status != 'pending')
                                                    <a href="{{ route('reciept.pdf', ['amount' => $donation->amount, 'date'=>$donation->created_on]) }}" target="_blank" class="btn btn-sm btn-soft-info">Reciept</a>
                                                    @else
                                                        <span class="badge {{ $donation->payment_status != 'pending' ? 'bg-success' : 'bg-warning' }}">
                                                            {{ $donation->payment_status }}
                                                        </span>
                                                    @endif
                                                    </td>
                                                <td>{{ \Carbon\Carbon::parse($donation->created_on)->format('d-M-Y h:i A') }}</td>
                                                <td>Rs.{{$donation->amount}}</td>
                                                <td>
                                                    <span class="badge {{ $donation->payment_status != 'pending' ? 'bg-success' : 'bg-warning' }}">
                                                        {{ $donation->payment_status }}
                                                    </span>
                                                </td>

                                                <td>Online</td>
                                                <td>Website</td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <td colspan="6">Total</td>
                                                <td>Rs. {{$eightyGAmount}}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
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