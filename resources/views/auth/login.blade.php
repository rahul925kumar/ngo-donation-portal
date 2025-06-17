<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="sm-hover" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Shreeji Gau Sewa Society | Donation for Cow | Gaushala seva</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Shree Ji Gau Sewa Society is a shelter of hope for countless cows in need. Join us in our mission - Gaushala seva to protect and care for these gentle beings." name="description" />
    <!-- <meta content="Themesbrand" name="author" /> -->
    <!-- App favicon -->
    <link rel="shortcut icon" href="/donation-portal/public/assets/images/favicon.icon">

    <!-- Layout config Js -->
    <script src="/donation-portal/public/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="/donation-portal/public/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/donation-portal/public/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/donation-portal/public/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="/donation-portal/public/assets/css/custom.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position" id="auth-particles">
            <!-- <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div> -->
            <!-- <img src="https://gausevasociety.com/wp-content/uploads/2024/04/gausala-slider-img1.png"> -->
            <video class="elementor-video" src="https://gausevasociety.com/wp-content/uploads/2024/11/gaushala.mp4" autoplay="" loop="" muted="muted" playsinline=""></video>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                            </div>
                            <p class="mt-3 fs-15 fw-medium"></p>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4">
            <div class="card-body p-4">
                <div class="text-center mt-2">
                    <h5 class="text-primary">Welcome</h5>
                    <p class="text-muted">Log in using your email and password or your phone number with OTP.</p>
                </div>

                <div class="mt-4">
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#email-login" role="tab" aria-selected="true">
                                <i class="ri-mail-line align-bottom me-1"></i> User Id
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#phone-login" role="tab" aria-selected="false">
                                <i class="ri-phone-line align-bottom me-1"></i> Phone
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content p-2 mt-4">
                        <div class="tab-pane active" id="email-login" role="tabpanel">
                            <form id="emailLoginForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="username" class="form-label">UserId</label>
                                    <input type="username" class="form-control" name="username" id="username" placeholder="Enter UserId">
                                    <div id="email_error" class="text-danger"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password-input">Password</label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                        <input type="password" class="form-control pe-5 password-input" name="password" placeholder="Enter password" id="password">
                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon-email"><i class="ri-eye-fill align-middle"></i></button>
                                        <div id="password_error" class="text-danger"></div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary w-100">Login</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="phone-login" role="tabpanel">
                            <form id="phoneLoginForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="number" class="form-control" name="phone_number" id="phone_number" required placeholder="Enter phone number">
                                    <div id="phone_error" class="text-danger"></div>
                                </div>
                                <div class="mb-3" id="otp-field" style="display: none;">
                                    <label class="form-label" for="otp-input">OTP</label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                        <input type="password" class="form-control pe-5 password-input" name="otp" placeholder="Enter otp" id="otp">
                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon-otp"><i class="ri-eye-fill align-middle"></i></button>
                                        <div id="otp_error" class="text-danger"></div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="button" id="sendOtpBtn" class="btn btn-primary w-100">
                                        Send OTP
                                    </button>
                                    <button type="button" id="verifyOtpBtn" class="btn btn-success w-100" style="display: none;">
                                        Verify OTP
                                    </button>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
            </div>
            </div>
    </div>
</div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->
        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <!--<script>document.write(new Date().getFullYear())</script>Crafted <i class="mdi mdi-heart text-danger"></i> by Digiverse-->
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="/donation-portal/public/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/donation-portal/public/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/donation-portal/public/assets/libs/node-waves/waves.min.js"></script>
    <script src="/donation-portal/public/assets/libs/feather-icons/feather.min.js"></script>
    <script src="/donation-portal/public/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="/donation-portal/public/assets/js/plugins.js"></script>

    <!-- particles app js -->
    <script src="/donation-portal/public/assets/js/pages/particles.app.js"></script>
    <!-- password-addon init -->
    <script src="/donation-portal/public/assets/js/pages/password-addon.init.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#sendOtpBtn').click(function(e) {
            e.preventDefault();
            var phoneNumber = $('#phone_number').val();
            $('#phone_error').text('');

            $.ajax({
                url: '{{ route('login.check-user-send-otp') }}', // Define this route
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    phone_number: phoneNumber
                },
                success: function(response) {
                    if (response.success) {
                        $('#otp-field').show();
                        $('#sendOtpBtn').hide();
                        $('#verifyOtpBtn').show();
                        $('#phone_number').prop('readonly', true);
                        alert(response.message); // Optionally show a success message
                    } else {
                        $('#phone_error').text(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    var err = JSON.parse(xhr.responseText);
                    $('#phone_error').text(err.message || 'Something went wrong.');
                }
            });
        });

        $('#verifyOtpBtn').click(function(e) {
            e.preventDefault();
            var phoneNumber = $('#phone_number').val();
            var otp = $('#otp').val();
            $('#otp_error').text('');

            $.ajax({
                url: '{{ route('login.verify-otp-login') }}', // Define this route
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    phone_number: phoneNumber,
                    otp: otp
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = '{{ route('dashboard') }}'; // Redirect to dashboard
                    } else {
                        $('#otp_error').text(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    var err = JSON.parse(xhr.responseText);
                    $('#otp_error').text(err.message || 'Something went wrong.');
                }
            });
        });
    });
$(document).ready(function() {
    $('#emailLoginForm').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Clear previous error messages
        $('#email_error').text('');
        $('#password_error').text('');

        // Get form data
        var formData = $(this).serialize();

        // Send AJAX request
        $.ajax({
            url: '/donation-portal/login', // Replace with your actual login route
            type: 'POST',
            data: formData,
            dataType: 'json', // Expecting JSON response from the server
            success: function(response) {
                if (response.success) {
                    // Redirect the user upon successful login
                    //window.location.href = response.redirect_url || '/dashboard'; // Redirect to dashboard or a URL provided in the response
                        window.location.href = '{{ route('dashboard') }}';
                } else {
                    // Display error messages from the server
                    if (response.errors) {
                        $.each(response.errors, function(key, value) {
                            $('#' + key + '_error').text(value[0]); // Display the first error message for each field
                        });
                    } else if (response.message) {
                        // Display a general error message
                        alert(response.message); // Or you could display it in a specific div
                    } else {
                        alert('An error occurred during login.');
                    }
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX errors (e.g., network issues, server errors)
                console.error("AJAX error:", status, error);
                alert('There was an error communicating with the server.');
            }
        });
    });
});
</script>
</body>

</html>