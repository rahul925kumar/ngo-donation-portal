

@extends('donars.layouts.header')

<style>
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
@section('content')
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
        $user->username,
        $user->gender,
        $user->father_spouse_name
    ];

    $filled = collect($fields)->filter(fn($value) => !empty($value))->count();
    $total = count($fields);
    $percentage = ($total > 0) ? round(($filled / $total) * 100) : 0;
@endphp
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="position-relative mx-n4 mt-n4">
                <div class="profile-wid-bg profile-setting-img">
                    <img src="assets/images/profile-bg.jpg" class="profile-wid-img" alt="">
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-3">
                    <div class="card mt-n5">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <form action="{{ url('profile-settings') }}" method="POST" enctype="multipart/form-data">
                                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                    <img src="/donation-portal/public/uploads/users/{{auth()->user()->user_img}}" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                        <input id="profile-img-file-input" name="user_img" type="file" class="profile-img-file-input">
                                        <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                            <span class="avatar-title rounded-circle bg-light text-body">
                                                <i class="ri-camera-fill"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <h5 class="fs-16 mb-1">{{auth()->user()->name}}</h5>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
                <div class="col-xxl-9">
                    <div class="card mt-xxl-n5">
                        <div class="card-header">
                            <div class="profile-completion-wrapper" style="margin-bottom: 20px;">
    <label style="font-weight: bold;">Profile Completion: {{ $percentage }}%</label>
    <div class="progress-bar-container" style="width: 100%; background-color: #e0e0e0; border-radius: 20px; overflow: hidden; height: 25px; position: relative;">
        <div class="progress-bar-fill" style="width: {{ $percentage }}%; background-color: #28a745; height: 100%; transition: width 0.5s; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
            {{ $percentage }}%
        </div>
    </div>
</div>

                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab" aria-selected="true">
                                        <i class="fas fa-home"></i> Personal Details
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link " data-bs-toggle="tab" href="#passwordDetails" role="tab" aria-selected="true">
                                        <i class="fas fa-home"></i> update Password
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="personalDetails" role="tabpanel">
                                    
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="">
                                                    <label>Salutation</label>
                                                    <select class="form-select addfloat form-control" id="salutation" name="salutation">
                                                        <option value="">Please Select</option>
                                                        <option value="Shri" {{ auth()->user()->salutation == 'Shri' ? 'selected' : '' }}>Shri</option>
                                                        <option value="Smt" {{ auth()->user()->salutation == 'Smt' ? 'selected' : '' }}>Smt</option>
                                                        <option value="Kumari" {{ auth()->user()->salutation == 'Kumari' ? 'selected' : '' }}>Kumari</option>
                                                        <option value="Dr." {{ auth()->user()->salutation == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                                                        <option value="M/S" {{ auth()->user()->salutation == 'M/S' ? 'selected' : '' }}>M/S</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="firstnameInput" class="form-label">Name</label>
                                                    <input type="text" name="name" class="form-control" id="firstnameInput"
                                                        placeholder="Enter your name" value="{{ auth()->user()->name }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="phonenumberInput" class="form-label">Phone Number</label>
                                                    <input type="tel" class="form-control" id="phonenumberInput" name="phone_number"
                                                        placeholder="Enter your phone number" value="{{ auth()->user()->phone_number }}">
                                                </div>
                                            </div>
                                             <div class="col-lg-4">
                                                <div class="align-items-center">
                                                    <label class="form-label">Gender</label>
                                                                                                   @php
                                                    $gender = Auth::user()->gender ?? '';
                                                @endphp
                                                
                                                <div class="btn-group w-100" role="group">
                                                    <input type="radio" class="btn-check" name="gender" id="radio1" value="Male" required
                                                        {{ $gender === 'Male' ? 'checked' : '' }}>
                                                    <label class="btn btn-outline-primary" for="radio1">Male</label>
                                                
                                                    <input type="radio" class="btn-check" name="gender" id="radio2" value="Female"
                                                        {{ $gender === 'Female' ? 'checked' : '' }}>
                                                    <label class="btn btn-outline-primary" for="radio2">Female</label>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="emailInput" class="form-label">Email Address</label>
                                                    <input type="email" class="form-control" id="emailInput" name="email"
                                                        placeholder="Enter your email" value="{{ auth()->user()->email }}">
                                                </div>
                                            </div>
                                             <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="father_spouse_name" class="form-label">Father/Spouse Name</label>
                                                    <input type="text" class="form-control" id="father_spouse_name" name="father_spouse_name" rows="3" value="{{ auth()->user()->father_spouse_name }}" />
                                                </div>
                                            </div>
                                            
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="addressInput" class="form-label">Address</label>
                                                    <textarea class="form-control" id="addressInput" name="address" rows="3"
                                                        placeholder="Enter your address">{{ auth()->user()->address }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="stateInput" class="form-label">State</label>
                                                      @php
                                                      
                                                      $stateArray = json_decode($statesCities);
                                                        $newStatesCitiesArray = $stateArray->states; 
                                                        @endphp
                                                    <select class="form-select" id="stateInput" name="state">
                                                        <option value="">Select State</option>
                                                        @foreach($newStatesCitiesArray as $state)
                                                        @php
                                                       
                                                        
                                                        @endphp
                                                            <option value="{{ $state->name }}" {{ auth()->user()->state == $state->name ? 'selected' : '' }}>
                                                                {{ $state->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="cityInput" class="form-label">City</label>
                                                    <select class="form-select" id="cityInput" name="city">
                                                        <option value="">Select City</option>
                                                        {{-- Populated by JS --}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="pincodeInput" class="form-label">Pincode</label>
                                                    <input type="text" class="form-control" id="pincodeInput" name="pincode"
                                                        placeholder="Enter your pincode" value="{{ auth()->user()->pincode }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="countryInput" class="form-label">Country</label>
                                                    <input type="text" class="form-control" id="countryInput" name="country" value="India" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label for="panInput" class="form-label">PAN Number</label>
                                                    <input type="text" class="form-control" id="panInput" name="pan_number"
                                                        placeholder="Enter your PAN number" value="{{ auth()->user()->pan_number }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                                    <button type="button" class="btn btn-soft-success">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!--end tab-pane-->
                                    <div class="tab-pane" id="passwordDetails" role="tabpanel">
                                    <h2>Update Password</h2>

                                    @if (session('status'))
                                        <div class="alert alert-success">{{ session('status') }}</div>
                                    @endif
                                
                                    <form method="POST" action="{{ route('password.update') }}">
                                        @csrf
                                
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">Current Password</label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                                            @error('current_password')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                
                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                                            @error('new_password')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                
                                        <div class="mb-3">
                                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                            <span id="password-match-msg" class="text-danger"></span>
                                        </div>
                                
                                        <button type="submit" class="btn btn-primary">Update Password</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div>
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
<script>
 const statesCities = @json($newStatesCitiesArray);
    const selectedState = "{{ auth()->user()->state }}";
    const selectedCity = "{{ auth()->user()->city }}";

    function populateCities(stateName) {
        const cityInput = document.getElementById('cityInput');
        cityInput.innerHTML = '<option value="">Select City</option>';

        const state = statesCities.find(s => s.name === stateName);
        if (state) {
            state.cities.forEach(city => {
                const selected = city === selectedCity ? 'selected' : '';
                cityInput.innerHTML += `<option value="${city}" ${selected}>${city}</option>`;
            });
        }
    }

    // Initial population on page load
    document.addEventListener('DOMContentLoaded', () => {
        if (selectedState) {
            populateCities(selectedState);
        }
    });

    // Change event listener
    document.getElementById('stateInput').addEventListener('change', function () {
        populateCities(this.value);
    });
</script>
<script>
    const password = document.getElementById('new_password');
    const confirmPassword = document.getElementById('new_password_confirmation');
    const msg = document.getElementById('password-match-msg');

    confirmPassword.addEventListener('input', function () {
        if (password.value !== confirmPassword.value) {
            msg.textContent = 'Passwords do not match.';
        } else {
            msg.textContent = '';
        }
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const hash = window.location.hash;

  if (hash) {
    const triggerEl = document.querySelector(`a[href="${hash}"]`);
    if (triggerEl) {
      const tab = new bootstrap.Tab(triggerEl);
      tab.show();
    }
  }
});
</script>

@endsection