@extends('donars.layouts.header')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Feedback/Compplaint</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form id="feedbackForm" method="post" action="{{url('/donor/feedbacks')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="feedback-type" class="form-label">Choose type *</label>
                                                <select class="form-select inputbg form-control" id="ddl_ftype" name="feedback_type" onchange="check_binddetails_txt();">
                                                    <option selected="selected" value="">Choose Type</option>
                                                    <option value="1">Profile Update</option>
                                                    <option value="2">Donation</option>
                                                    <option value="3">ECS</option>
                                                    <option value="4">My References</option>
                                                    <option value="5">Others (Please mention the detail)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="lastNameinput" class="form-label">Description *</label>
                                                <textarea name="description" type="text" class="form-control" placeholder="Levae a comment here.." id="lastNameinput"> </textarea>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="attachment" class="form-label">Upload Receipt</label>
                                                <input type="file" class="form-control" placeholder="Enter company name" name="attachment" id="attachment">
                                            </div>
                                        </div>
                                        <div class="col-md-8">

                                        </div>
                                        <!--end col-->
                                        <div class="col-md-4" id="div_feedback_detail" style="display: none;">
                                            <div class="mb-3">
                                                <label for="phonenumberInput" class="form-label">Select Type Detail *</label>
                                                <select id="ddl_ftype_detail" name="feedback_detail" onchange="checkothertxt();" class="form-select inputbg">
                                                    <option selected="selected" value="">--Select--</option>
                                                    <option value="1">My profile is not updated despite request</option>
                                                    <option value="2">My Name is wrongly spelt</option>
                                                    <option value="3">My details were wrongly updated</option>
                                                    <option value="4">There multiple contact of mine</option>
                                                    <option value="5">Others (Please mention the detail)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-md-8" id="div_othrtxt_feedback" style="display: none;">
                                            <div class="mb-3">
                                                <label for="reason" class="form-label">Others (Please mention the detail) *</label>
                                                <input type="text" class="form-control" name="other_details" placeholder="Enter Feedback Type Details" id="reason">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->

            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">My Feedback/Complaints</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="live-preview">
                                <div class="table-responsive table-card">
                                    <table class="table align-middle table-nowrap table-striped-columns mb-0" id="feedback-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">S No.</th>
                                                <th scope="col">Ticket ID</th>
                                                <th scope="col">Current Status</th>
                                                <th scope="col">Feedback Type</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Feedback Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($feedbacks as $key => $compalaint)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$compalaint->feedback_id}}</td>
                                                <td>{{$compalaint->status == 0 ? 'Assign' : 'Solved'}}</td>
                                                <td>Profile Update</td>
                                                <td>{{$compalaint->description}}</td>
                                                <td>{{ \Carbon\Carbon::parse($compalaint->created_at)->format('d-M-Y h:i A') }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
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
    new DataTable('#feedback-table');

    function checkothertxt() {
        // showloadingpopup();
        var ftype_detail = $("#ddl_ftype_detail option:selected").val();
        if (ftype_detail == 5 || ftype_detail == 10 || ftype_detail == 19 || ftype_detail == 24) {
            $("#div_othrtxt_feedback").show();
        } else {
            $("#div_othrtxt_feedback").hide();
        }
        // hideloadingpopup();
    }

    function check_binddetails_txt() {
        var ftype = $("#ddl_ftype option:selected").val();
        if (ftype == 5) {
            // $("#div_othrtxt_feedback").show();
            $("#div_feedback_detail").show();

        } else {
            $("#div_feedback_detail").hide();
            $("#div_othrtxt_feedback").hide();
        }

    }
</script>
@endsection