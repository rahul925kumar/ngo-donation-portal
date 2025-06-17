    @extends('donars.layouts.header')
    @section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <style>
        .btn-primary1 {
        /* background: linear-gradient(#74489d 0%, #eae09b 100%); */
        color: white;
        border: 0;
        padding: 5px 15px;
        border-radius: 5px;
        white-space: nowrap;
        background: -webkit-gradient(linear,left top,right top,color-stop(28.12%,#ff7400),to(#f91717));
        background: -webkit-linear-gradient(left,#ff7400 28.12%,#f91717);
        background: -moz-linear-gradient(left,#ff7400 28.12%,#f91717 100%);
        background: linear-gradient(90deg,#ff7400 28.12%,#f91717);
        border: 1px solid #ff7400;
    }

    .ref-btn {
        float: right;
        justify-content: right;
        display: inline-flex;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
        padding: 0.5rem 0.75rem;
    }

    .form-control:focus {
        border-color: #ff7400;
        box-shadow: 0 0 0 0.2rem rgba(255, 116, 0, 0.25);
    }

    .form-select {
        border-radius: 5px;
        border: 1px solid #ced4da;
        padding: 0.5rem 0.75rem;
    }

    .form-select:focus {
        border-color: #ff7400;
        box-shadow: 0 0 0 0.2rem rgba(255, 116, 0, 0.25);
    }

    .btn-primary {
        background: -webkit-gradient(linear,left top,right top,color-stop(28.12%,#ff7400),to(#f91717));
        background: -webkit-linear-gradient(left,#ff7400 28.12%,#f91717);
        background: -moz-linear-gradient(left,#ff7400 28.12%,#f91717 100%);
        background: linear-gradient(90deg,#ff7400 28.12%,#f91717);
        border: none;
    }

    .btn-primary:hover {
        background: -webkit-gradient(linear,left top,right top,color-stop(28.12%,#f91717),to(#ff7400));
        background: -webkit-linear-gradient(left,#f91717 28.12%,#ff7400);
        background: -moz-linear-gradient(left,#f91717 28.12%,#ff7400 100%);
        background: linear-gradient(90deg,#f91717 28.12%,#ff7400);
    }
    </style>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Reference Registration</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <form id="referenceForm" class="w-100 mx-auto" method="POST" action="{{ route('saveRefferenceRegistration') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6 col-xl-3 mt-3">
                                            <div class="">
                                                <label>Salutation</label>
                                                <select class="form-select addfloat form-control" id="salutation" name="salutation" required>
                                                    <option value="">Please Select</option>
                                                    <option value="Shri">Shri</option>
                                                    <option value="Smt">Smt</option>
                                                    <option value="Kumari">Kumari</option>
                                                    <option value="Dr.">Dr.</option>
                                                    <option value="M/S">M/S</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-3 mt-3">
                                            <div class="">
                                                <label>First Name</label>
                                                <input type="text" id="txt_firstname" name="first_name" class="form-control textdemo" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-3 mt-3">
                                            <div class="">
                                                <label>Last Name</label>
                                                <input type="text" id="txt_lastname" name="last_name" class="form-control textdemo" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-3 mt-3">
                                            <div class="">
                                                <label>Date of birth</label>
                                                <input type="date" id="txt_d_dob" name="dob" class="form-control textdemo" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-3 mt-3">
                                            <div class="">
                                                <label>Mobile Number</label>
                                                <input type="text" id="txt_mobile" name="phone_number" class="form-control textdemo mobile_number_validation" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-3 mt-3">
                                            <div class="">
                                                <label>Email</label>
                                                <input type="email" id="txt_email" name="email" class="form-control textdemo" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-3 mt-3">
                                            <div class="">
                                                <label>State</label>
                                                <select class="form-select addfloat form-control" id="ddl_state" name="state" required>
                                                    <option value="">Select State</option>
                                                    @foreach($statesCities->states as $state)
                                                        <option value="{{ $state->name }}">{{ $state->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-3 mt-3">
                                            <div class="">
                                                <label>City</label>
                                                <select class="form-select addfloat form-control" id="ddl_city" name="city" required>
                                                    <option value="">Select City</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-3 mt-3">
                                            <div class="">
                                                <label>Pincode</label>
                                                <input type="text" id="txt_pincode" name="pincode" class="form-control textdemo number_only" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-3 mt-3">
                                            <div class="">
                                                <label>Source</label>
                                                <select class="form-select addfloat form-control" id="ddl_source" name="source" required>
                                                    <option value="">Please Select</option>
                                                    <option value="Friends/ Aquaintances">Friends/ Aquaintances</option>
                                                    <option value="Gokul Dham Gau Sewa Mahatirth">Gokul Dham Gau Sewa Mahatirth</option>
                                                    <option value="Messages">Messages</option>
                                                    <option value="New Letters">New Letters</option>
                                                    <option value="Others">Others</option>
                                                    <option value="Search Engines">Search Engines</option>
                                                    <option value="Social Media">Social Media</option>
                                                    <option value="Word of Mouth">Word of Mouth</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <div class="form-check align-self-start">
                                                <input class="form-check-input addaddress" type="checkbox" value="1" id="addaddress" name="add_complete_address">
                                                <label class="form-check-label" for="addaddress">Enter Complete Address for Postal Communication</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div id="comAddress" class="mt-3" style="display: none; transition: all 0.3s ease;">
                                                <div class="row gy-4">
                                                    <div class="col-lg-12">
                                                        <div class="">
                                                            <label>Address</label>
                                                            <textarea id="Address" name="address" class="form-control textdemo" rows="3" placeholder="Enter your complete address here..."></textarea>
                                                        </div>
                                                        <span class="small">(Don't enter State, City & Country again)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-12 d-flex justify-content-between flex-wrap">
                                            <button type="submit" class="btn btn-primary px-5">Register</button>
                                            <button type="reset" class="btn btn-primary px-5">Reset</button>
                                        </div>
                                    </div>
                                </form>
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
    $(document).ready(function() {
        // Show/hide complete address section with animation
        $('#addaddress').on('change', function() {
            if($(this).is(':checked')) {
                $('#comAddress').slideDown(300);
                $('#Address').focus();
            } else {
                $('#comAddress').slideUp(300);
                $('#Address').val(''); // Clear the textarea when hidden
            }
        });

        // Handle state change
        $(document).on('change', '#ddl_state', function() {
            var selectedState = $(this).val();
            console.log('Selected State:', selectedState); // Debug log
            
            // Find cities for selected state
            var statesData = {!! json_encode($statesCities->states) !!};
            console.log('States Data:', statesData); // Debug log
            
            var cities = [];
            for (var i = 0; i < statesData.length; i++) {
                if (statesData[i].name === selectedState) {
                    cities = statesData[i].cities;
                    break;
                }
            }
            
            console.log('Found Cities:', cities); // Debug log

            // Update cities dropdown
            var citySelect = $('#ddl_city');
            citySelect.empty();
            citySelect.append('<option value="">Select City</option>');
            
            if (cities && cities.length > 0) {
                cities.forEach(function(city) {
                    citySelect.append(`<option value="${city}">${city}</option>`);
                });
            }
        });

        // Form submission
        $('#referenceForm').submit(function(e) {
            e.preventDefault();
            
            // Basic validation
            var isValid = true;
            $(this).find('input[required], select[required]').each(function() {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (!isValid) {
                alert('Please fill in all required fields');
                return;
            }

            // Submit form
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert('Reference registered successfully!');
                    window.location.href = "{{ route('MyReferences') }}";
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });
    });
    </script>
    @endsection