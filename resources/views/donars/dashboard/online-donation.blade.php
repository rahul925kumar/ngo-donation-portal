@extends('donars.layouts.header')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-6">
                    <div class="card">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-justified mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="donations nav-link active" data-bs-toggle="tab" href="#donate-monthly" role="tab" aria-selected="false">
                                        Donate Monthly
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="donations nav-link" data-bs-toggle="tab" href="#qr-pay" role="tab" aria-selected="false">
                                        QR-Scan & Pay
                                    </a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content text-muted">
                                <div class="tab-pane" id="donatte-now" role="tabpanel" style="display: none;">

                                </div>
                                <div class="tab-pane active donatte-now" id="donatte-now" role="tabpanel">
                                    <h3>Get 80G Benefits</h3>
                                    <form id="form-to-submit">
                                        <div class="form-group">
                                            <div class="form row">
                                                <div class="col-lg-6">
                                                    <label class="col-form-label">Amount
                                                        <span style="color: #ff0000">*</span>
                                                    </label>
                                                    <input
                                                        id="txt_amount"
                                                        type="text"
                                                        style="text-transform: capitalize"
                                                        placeholder="Amount"
                                                        maxlength="10"
                                                        class="form-control number_only cut_copy_paste_block"
                                                        autofocus
                                                        tabindex="1"
                                                        required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="col-form-label">Mobile Number
                                                        <span style="color: #ff0000">*</span>
                                                    </label>
                                                    <input
                                                        id="txt_mobile_number"
                                                        value="{{$user->phone_number}}"
                                                        type="text"
                                                        placeholder="Enter Mobile Number"
                                                        maxlength="10"
                                                        class="form-control number_only mobile_number_validation"
                                                        tabindex="2"
                                                        required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="col-form-label">Name
                                                        <span style="color: #ff0000">*</span>
                                                    </label>
                                                    <input
                                                        id="txt_name"
                                                        type="text"
                                                        style="text-transform: capitalize"
                                                        placeholder="Enter Your Name"
                                                        value="{{$user->name}}"
                                                        class="form-control"
                                                        tabindex="3"
                                                        required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="col-form-label">Email
                                                        <span style="color: #ff0000">*</span>
                                                    </label>
                                                    <input
                                                        id="txt_email"
                                                        type="email"
                                                        placeholder="Enter Email-ID"
                                                        value="{{$user->email}}"
                                                        style="text-transform: lowercase;"
                                                        class="form-control"
                                                        tabindex="4"
                                                        required>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="col-form-label">PAN No.</label>
                                                    <input
                                                        id="txt_pan_number"
                                                        type="text"
                                                        placeholder="Mandatory for 80G"
                                                        maxlength="10"
                                                        style="text-transform: uppercase"
                                                        class="form-control pan_number_validation"
                                                        tabindex="5">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="col-form-label">State
                                                        <span style="color: #ff0000">*</span>
                                                    </label>
                                                    <select id="ddl_state" data-placeholder="Choose a State..."
                                                        class="form-control chosen-select"
                                                        tabindex="6"
                                                        required>
                                                        <option value="">Select State</option>
                                                        <option value="35">Andaman and Nicobar Islands</option>
                                                        <option value="28">Andhra Pradesh</option>
                                                        <option value="12">Arunachal Pradesh</option>
                                                        <option value="18">Assam</option>
                                                        <option value="10">Bihar</option>
                                                        <option value="04">Chandigarh</option>
                                                        <option value="22">Chhattisgarh</option>
                                                        <option value="26">Dadra and Nagar Haveli</option>
                                                        <option value="25">Daman and Diu</option>
                                                        <option value="07">Delhi</option>
                                                        <option value="30">Goa</option>
                                                        <option value="24">Gujarat</option>
                                                        <option value="06">Haryana</option>
                                                        <option value="02">Himachal Pradesh</option>
                                                        <option value="01">Jammu and Kashmir</option>
                                                        <option value="20">Jharkhand</option>
                                                        <option value="29">Karnataka</option>
                                                        <option value="32">Kerala</option>
                                                        <option value="31">Lakshadweep</option>
                                                        <option value="23">Madhya Pradesh</option>
                                                        <option value="27">Maharashtra</option>
                                                        <option value="14">Manipur</option>
                                                        <option value="17">Meghalaya</option>
                                                        <option value="15">Mizoram</option>
                                                        <option value="13">Nagaland</option>
                                                        <option value="21">Odisha</option>
                                                        <option value="34">Puducherry</option>
                                                        <option value="03">Punjab</option>
                                                        <option value="08">Rajasthan</option>
                                                        <option value="11">Sikkim</option>
                                                        <option value="33">Tamil Nadu</option>
                                                        <option value="36">Telangana</option>
                                                        <option value="16">Tripura</option>
                                                        <option value="09">Uttar Pradesh</option>
                                                        <option value="05">Uttarakhand</option>
                                                        <option value="19">West Bengal</option>
                                                    </select>
                                                </div>
                                                 <div class="col-lg-12">
                                                    <label class="form-check-label">
                                                        Address
                                                    </label>
                                                    <br>
                                                    <textarea
    id="address"
    class="form-control"
    name="address"
    rows="5"
    cols="10"></textarea>

                                                </div>
                                                <div class="col-lg-12">
                                                    <input
                                                        type="checkbox"
                                                        id="monthly_donation"
                                                        class="form-check-input">
                                                    <label class="form-check-label" for="monthly_donation">
                                                        I would like to automatically donate Rs. once a Month until I cancel.
                                                    </label>
                                                </div>
                                                <div class="col-lg-12 text-center" style="padding: 15px;">
                                                    <button type="submit" class="btn btn-success">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane" id="qr-pay" role="tabpanel">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div>
                                            <p style=" text-align: center; font-weight: 600; font-size: 21px; margin: 0px; padding-top: 15px;  line-height: 30px;  color: #e99140;">
                                                QR- कोड से दिए गए दान की रसीद नहीं मिलेगी। <br>
                                                Donation through QR-code receipt will not generated. </p>
                                        </div>
                                        <div class="elementor-element elementor-element-db60923 elementor-widget__width-initial elementor-widget elementor-widget-image" data-id="db60923" data-element_type="widget" data-widget_type="image.default">
                                            <div class="elementor-widget-container" style="text-align: center;">
                                                <img fetchpriority="high" decoding="async" width="300" height="300" src="https://gausevasociety.com/wp-content/uploads/2024/01/Gau-sewa-Qr-code-5x7-inch.pdf-e1732621862870-1024x1011.png" class="attachment-large size-large wp-image-8559" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div>
                <!--end col-->
            </div>

            <!--end col-->
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
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
    $(document).ready(function() {
        $(".donations").click(function(e) {
            e.preventDefault(); // Prevent default anchor behavior

            // Remove 'active' class from all tabs
            $(".donations").removeClass("active");

            // Add 'active' class to the clicked tab
            $(this).addClass("active");

            // Hide all tab sections
            $(".tab-content-section").hide();

            // Get the target section ID from href attribute
            var target = $(this).attr("href");
            console.log('target: ', target);

            if(target == '#qr-pay'){
                $(".donatte-now").hide();
            }else{
                $(".donatte-now").show();
            }
            // Show the corresponding section
            $(target).show();
        });
        $("#form-to-submit").on("submit", donate_btn_now);
    });

    function donate_btn_now(e) {
        e.preventDefault(); // Prevent default form submission

        var name = $('#txt_name').val().trim();
        var number = $('#txt_mobile_number').val().trim();
        var address = "N/A"; // Address field isn't present in your form
        var adhar = "000000000000"; // Aadhaar isn't in form, use dummy or optional
        var pan = $('#txt_pan_number').val().trim();
        var email = $('#txt_email').val().trim();
        var amt = $('#txt_amount').val().trim();

        // Validation: Check if amount is valid
        if (amt === "" || isNaN(amt) || amt <= 0) {
            alert("Please enter a valid amount.");
            return;
        }

        if (name === "") {
            alert("Please enter your name.");
            return;
        }

        if (number === "" || !/^\d{10}$/.test(number)) {
            alert("Please enter a valid 10-digit contact number.");
            return;
        }

        if (email === "") {
            alert("Please enter your email.");
            return;
        }

        // if (pan === "" || !/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(pan)) {
        //     alert("Please enter a valid PAN number.");
        //     return;
        // }

        // Proceed with AJAX call
        jQuery.ajax({
            type: 'post',
            url: 'https://gausevasociety.com/donation/payment_process2.php',
            data: {
                name: encodeURIComponent(name),
                number: encodeURIComponent(number),
                address: encodeURIComponent(address),
                adhar: encodeURIComponent(adhar),
                pan: encodeURIComponent(pan),
                amt: encodeURIComponent(amt)
            },
            success: function(result) {
                var options = {
                    "key": "rzp_live_KkBrG1e89Uy7Km",
                    "amount": amt * 100,
                    "currency": "INR",
                    "name": "Gauseva Society",
                    "description": "Give your donation to save Gau Maata",
                    "image": "https://marcawebdev.in/gaushala/wp-content/uploads/2024/01/gaushala-logo.png",
                    "handler": function(response) {
                        jQuery.ajax({
                            type: 'post',
                            url: 'https://gausevasociety.com/donation/payment_process2.php',
                            data: {
                                payment_id: response.razorpay_payment_id
                            },
                            success: function() {
                                jQuery.ajax({
                                    type: 'post',
                                    url: 'https://gausevasociety.com/donation/send_mail.php',
                                    data: {
                                        name: decodeURIComponent(name),
                                        number: decodeURIComponent(number),
                                        address: decodeURIComponent(address),
                                        adhar: decodeURIComponent(adhar),
                                        pan: decodeURIComponent(pan),
                                        amt: decodeURIComponent(amt)
                                    },
                                    success: function(email_result) {
                                        console.log(email_result);
                                    }
                                });
                                // window.location.href = "https://gausevasociety.com/donation/thank_you.php";
                                alert('Payment successfully Done');
                            }
                        });
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            }
        });
    }
</script>
@endsection