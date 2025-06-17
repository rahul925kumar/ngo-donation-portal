@extends('donars.layouts.header')

@section('content')
<!-- Add these script includes at the top of the content section -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.css" rel="stylesheet">

<!-- Add DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<style>
    .profile-page .camera-img {
    left: 50%;
    transform: translate(-50%, -20px);
    border: 0;
    background: transparent;
}
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Celebrate in Gaushala</h4>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#celebrationModal">
                                Add New Celebration
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="dataTables_wrapper dt-bootstrap5">
                                    <!--<div class="row">-->
                                    <!--    <div class="col-sm-12 col-md-6">-->
                                    <!--        <div class="dataTables_length">-->
                                    <!--            <label>-->
                                    <!--                Show -->
                                    <!--                <select name="celebrationsTable_length" class="form-select form-select-sm">-->
                                    <!--                    <option value="10">10</option>-->
                                    <!--                    <option value="25">25</option>-->
                                    <!--                    <option value="50">50</option>-->
                                    <!--                    <option value="100">100</option>-->
                                    <!--                </select> entries-->
                                    <!--            </label>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--    <div class="col-sm-12 col-md-6">-->
                                    <!--        <div class="dataTables_filter">-->
                                    <!--            <label>Search:-->
                                    <!--                <input type="search" class="form-control form-control-sm" placeholder="Search records...">-->
                                    <!--            </label>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <table class="table table-bordered" id="celebrationsTable">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Relation</th>
                                                <th>Gotra</th>
                                                <th>Type</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($celebrations as $celebration)
                                            <tr>
                                                <td>
                                                    @if($celebration->image)
                                                        <img src="{{ asset('public/uploads/celebrations/' . $celebration->image) }}" alt="Celebration Image" style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('assets/images/avatar.png') }}" alt="Default Image" style="width: 50px; height: 50px; object-fit: cover;" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iI2RkZCIgZD0iTTEyIDJDNi40OCAyIDIgNi40OCAyIDEyczQuNDggMTAgMTAgMTAgMTAtNC40OCAxMC0xMFMxNy41MiAyIDEyIDJ6bTAgM2MyLjY3IDAgNC44NCAyLjE3IDQuODQgNC44NCAwIDIuNjctMi4xNyA0Ljg0LTQuODQgNC44NC0yLjY3IDAtNC44NC0yLjE3LTQuODQtNC44NCAwLTIuNjcgMi4xNy00Ljg0IDQuODQtNC44NHptMCAxMmE5LjkxIDkuOTEgMCAwIDEtOC4wNC00LjQyYzEuMDctLjYzIDIuMzYtLjk4IDMuNzYtLjk4IDIuNjcgMCA0Ljg0IDIuMTcgNC44NCA0Ljg0IDAgMS40LS4zNSAyLjY5LS45OCAzLjc2QTkuOTEgOS45MSAwIDAgMSAxMiAxN3oiLz48L3N2Zz4='">
                                                    @endif
                                                </td>
                                                <td>{{ $celebration->name }}</td>
                                                <td>{{ $celebration->relation }}</td>
                                                <td>{{ $celebration->gotra }}</td>
                                                <td>{{ $celebration->type }}</td>
                                                <td>{{ $celebration->schedule_date->format('d M Y') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $celebration->status == 'approved' ? 'success' : ($celebration->status == 'rejected' ? 'danger' : 'warning') }}">
                                                        {{ ucfirst($celebration->status) }}
                                                    </span>
                                                </td>
                                                <td>{{$celebration->remarks}}</td>
                                                <!--<td>-->
                                                <!--    <button class="btn btn-sm btn-primary edit-celebration" data-id="{{ $celebration->id }}">Edit</button>-->
                                                <!--    <button class="btn btn-sm btn-danger delete-celebration" data-id="{{ $celebration->id }}">Delete</button>-->
                                                <!--</td>-->
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Celebration Modal -->
<div class="modal fade" id="celebrationModal" tabindex="-1" aria-labelledby="celebrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="celebrationModalLabel">Add New Celebration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="celebrationForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="celebration_id" id="celebration_id">

                    <div class="row align-items-start">
                        <div class="col-lg-12 mb-4">
                            <div class="profile-page mxw-300px" style="display:flex; justify-content:center">
                                <div class="profile_image">
                                    <img src="https://www.gokuldhammahatirth.org/assets/images/avatar.png" id="img_mamber_pic" alt="" width="126" style="border-radius: 100%;height: 100px; width: 100px;" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iI2RkZCIgZD0iTTEyIDJDNi40OCAyIDIgNi40OCAyIDEyczQuNDggMTAgMTAgMTAgMTAtNC40OCAxMC0xMFMxNy41MiAyIDEyIDJ6bTAgM2MyLjY3IDAgNC44NCAyLjE3IDQuODQgNC44NCAwIDIuNjctMi4xNyA0Ljg0LTQuODQgNC44NC0yLjY3IDAtNC44NC0yLjE3LTQuODQtNC44NCAwLTIuNjcgMi4xNy00Ljg0IDQuODQtNC44NHptMCAxMmE5LjkxIDkuOTEgMCAwIDEtOC4wNC00LjQyYzEuMDctLjYzIDIuMzYtLjk4IDMuNzYtLjk4IDIuNjcgMCA0Ljg0IDIuMTcgNC44NCA0Ljg0IDAgMS40LS4zNSAyLjY5LS45OCAzLjc2QTkuOTEgOS45MSAwIDAgMSAxMiAxN3oiLz48L3N2Zz4='">
                                    <button class="position-absolute top-100 camera-img" onclick="document.getElementById('imageupload').click()">
                                        <img src="https://www.gokuldhammahatirth.org/assets/images/camera.svg" alt="" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+PHBhdGggZmlsbD0iI2RkZCIgZD0iTTEyIDEyYzIuMjEgMCA0LTEuNzkgNC00cy0xLjc5LTQtNC00LTQgMS43OS00IDQgMS43OSA0IDQgNHptMCAyYy0yLjY3IDAtOCAxLjMzLTggNHYyaDE2di0yYzAtMi42Ny01LjMzLTQtOC00eiIvPjwvc3ZnPg=='">
                                    </button>
                                    <input type="file" class="d-none" id="imageupload" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mt-0">
                                <label for="txt_donor" class="form-label">Name</label>
                                <input type="text" id="txt_donor" name="name" class="form-control textdemo" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="align-items-center">
                                <label class="form-label">Gender</label>
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="gender" id="radio1" value="Male" required>
                                    <label class="btn btn-outline-primary" for="radio1">Male</label>
                                    <input type="radio" class="btn-check" name="gender" id="radio2" value="Female">
                                    <label class="btn btn-outline-primary" for="radio2">Female</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mt-2">
                                <label for="txtrelation" class="form-label">Relation</label>
                                <input type="text" id="txtrelation" name="relation" class="form-control textdemo" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mt-2">
                                <label for="ddltype" class="form-label">Type</label>
                                <select class="form-select addfloat" id="ddltype" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="Anniversary">Anniversary</option>
                                    <option value="Birthday">Birthday</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mt-2">
                                <label for="txt_type_date" class="form-label">Date</label>
                                <input type="date" id="txt_type_date" name="schedule_date" class="form-control textdemo" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mt-2">
                                <label for="txt_gotra" class="form-label">Gotra</label>
                                <input type="text" id="txt_gotra" name="gotra" class="form-control textdemo" required>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mt-2">
                                <label for="txt_othertext">Enter Remark</label>
                                <textarea class="form-control" placeholder="Leave a comment here" id="txt_othertext" 
                                          name="remarks" style="height: 100px !important; resize: none;" required></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveCelebration">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Add DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize toastr
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right"
    };

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

    // Reset form when modal is closed
    $('#celebrationModal').on('hidden.bs.modal', function () {
        $('#celebrationForm')[0].reset();
        $('#img_mamber_pic').attr('src', "{{ asset('assets/images/avatar.png') }}");
        $('#celebration_id').val('');
        $('#celebrationModalLabel').text('Add New Celebration');
    });

    // Save celebration
    $('#saveCelebration').click(function(e) {
        e.preventDefault();
        var form = $('#celebrationForm')[0];
        var formData = new FormData(form);
        var celebrationId = $('#celebration_id').val();
        var url = celebrationId ? '/celebrations/' + celebrationId : '/celebrations';
        var method = celebrationId ? 'PUT' : 'POST';

        $.ajax({
            url: "/donation-portal"+url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('Success:', response);
                toastr.success('Celebration saved successfully');
                $('#celebrationModal').modal('hide');
                location.reload();
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error('Error saving celebration: ' + error);
                }
            }
        });
    });

    // Edit celebration
    $('.edit-celebration').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: '/celebrations/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                var celebration = response;
                $('#celebration_id').val(celebration.id);
                $('#txt_donor').val(celebration.name);
                $('input[name="gender"][value="' + celebration.gender + '"]').prop('checked', true);
                $('#txtrelation').val(celebration.relation);
                $('#ddltype').val(celebration.type);
                $('#txt_type_date').val(celebration.schedule_date);
                $('#txt_gotra').val(celebration.gotra);
                $('#txt_othertext').val(celebration.remarks);
                if (celebration.image) {
                    $('#img_mamber_pic').attr('src', '/uploads/celebrations/' + celebration.image);
                }
                $('#celebrationModalLabel').text('Edit Celebration');
                $('#celebrationModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
                toastr.error('Error loading celebration data');
            }
        });
    });

    // Delete celebration
    $('.delete-celebration').click(function() {
        if (confirm('Are you sure you want to delete this celebration?')) {
            var id = $(this).data('id');
            $.ajax({
                url: '/celebrations/' + id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success('Celebration deleted successfully');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                    toastr.error('Error deleting celebration');
                }
            });
        }
    });

    // Initialize DataTable
    var table = $('#celebrationsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        dom: '<"top"lf>rt<"bottom"ip><"clear">',
        language: {
            search: "",
            searchPlaceholder: "Search records...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        order: [[3, 'desc']], // Default sort by date column
        columnDefs: [
            { orderable: false, targets: [0, 5] }, // Disable sorting for image and actions columns
            { searchable: false, targets: [0, 5] } // Disable searching for image and actions columns
        ]
    });
});
</script>
@endsection 