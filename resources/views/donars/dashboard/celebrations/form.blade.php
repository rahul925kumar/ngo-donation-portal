@extends('donars.layouts.header')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ isset($celebration) ? 'Edit' : 'Create' }} Celebration</h4>
                        </div>
                        <div class="card-body">
                            <form id="celebrationForm" enctype="multipart/form-data">
                                @csrf
                                @if(isset($celebration))
                                    @method('PUT')
                                @endif

                                <div class="row align-items-start">
                                    <input type="hidden" id="hdn_donorsession" value="0">

                                    <div class="col-lg-12 mb-4" style="display: flex !important; justify-content: center !important;">
                                        <div class="profile-page mxw-300px">
                                            <div class="">
                                                <img src="{{ isset($celebration) && $celebration->image ? asset('uploads/celebrations/' . $celebration->image) : 'https://www.gokuldhammahatirth.org/assets/images/avatar.png' }}" 
                                                     id="img_mamber_pic" alt="" width="126" style="border-radius: 100%;height: 100px; width: 100px;">
                                                <button class="position-absolute top-100 camera-img" onclick="document.getElementById('imageupload').click()">
                                                    <img src="https://www.gokuldhammahatirth.org/assets/images/camera.svg" alt="">
                                                </button>
                                                <input type="file" class="d-none" id="imageupload" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                                                <input type="hidden" id="hdn_img_path">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mt-0">
                                            <label for="txt_donor" class="form-label">Name</label>
                                            <input type="text" id="txt_donor" name="name" class="form-control textdemo" 
                                                   value="{{ isset($celebration) ? $celebration->name : '' }}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="align-items-center">
                                            <label class="form-label">Gender</label>
                                            <div class="btn-group w-100" role="group">
                                                <input type="radio" class="btn-check" name="gender" id="radio1" value="Male" 
                                                       {{ isset($celebration) && $celebration->gender == 'Male' ? 'checked' : '' }} required>
                                                <label class="btn btn-outline-primary" for="radio1">Male</label>
                                                <input type="radio" class="btn-check" name="gender" id="radio2" value="Female"
                                                       {{ isset($celebration) && $celebration->gender == 'Female' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-primary" for="radio2">Female</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mt-2">
                                            <label for="txtrelation" class="form-label">Relation</label>
                                            <input type="text" id="txtrelation" name="relation" class="form-control textdemo"
                                                   value="{{ isset($celebration) ? $celebration->relation : '' }}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mt-2">
                                            <label for="ddltype" class="form-label">Type</label>
                                            <select class="form-select addfloat" id="ddltype" name="type" required>
                                                <option value="">Select Type</option>
                                                <option value="Anniversary" {{ isset($celebration) && $celebration->type == 'Anniversary' ? 'selected' : '' }}>Anniversary</option>
                                                <option value="Birthday" {{ isset($celebration) && $celebration->type == 'Birthday' ? 'selected' : '' }}>Birthday</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mt-2">
                                            <label for="txt_type_date" class="form-label">Date</label>
                                            <input type="date" id="txt_type_date" name="schedule_date" class="form-control textdemo"
                                                   value="{{ isset($celebration) ? $celebration->schedule_date->format('Y-m-d') : '' }}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mt-2">
                                            <label for="txt_gotra" class="form-label">Gotra</label>
                                            <input type="text" id="txt_gotra" name="gotra" class="form-control textdemo"
                                                   value="{{ isset($celebration) ? $celebration->gotra : '' }}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mt-2">
                                            <label for="txt_othertext">Enter Remark</label>
                                            <textarea class="form-control" placeholder="Leave a comment here" id="txt_othertext" 
                                                      name="remarks" style="height: 100px !important; resize: none;" required>{{ isset($celebration) ? $celebration->remarks : '' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mt-3">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <a href="{{ route('celebrations.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Image preview
    $('#imageupload').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#img_mamber_pic').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // Form submission
    $('#celebrationForm').submit(function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const url = $(this).attr('action');
        const method = $(this).attr('method');

        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                toastr.success('Celebration saved successfully');
                setTimeout(function() {
                    window.location.href = "{{ route('celebrations.index') }}";
                }, 1500);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error('Error saving celebration');
                }
            }
        });
    });
});
</script>
@endsection 