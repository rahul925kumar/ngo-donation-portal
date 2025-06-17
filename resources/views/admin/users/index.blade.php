@extends('admin.layouts.app')

@section('title', 'Users Management')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Users List</h5>
    </div>
    <div class="mb-3 text-end">
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addUserModal">
            + Add User
        </button>
        <!-- CSV Export Button -->
        <button id="exportCsv" class="btn btn-success">
            Export to CSV
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="usersTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <!--<th>Donations</th>-->
                        <!--<th>Amount</th>-->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ urldecode($user->name) }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>{{ $user->city }}, {{ $user->state }}</td>
                        <!--<td>{{ $user->donations_count }}</td>-->
                        <!--<td>{{ $user->total_donations }}</td>-->
                        <td>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('admin.donations') }}?user={{ $user->id }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-warning send-password" data-user-id="{{ $user->id }}">
                                <i class="fas fa-key"></i>
                            </button>
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
          @csrf

          <div class="row mb-3">
              <div class="col-md-6">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                  @error('name')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-md-6">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                  @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
          </div>

          <div class="row mb-3">
              <div class="col-md-6">
                  <label for="phone_number" class="form-label">Phone Number</label>
                  <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                  @error('phone_number')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-md-6">
                  <label for="state" class="form-label">State</label>
                  <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" value="{{ old('state') }}" required>
                  @error('state')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
          </div>

          <div class="row mb-3">
              <div class="col-md-6">
                  <label for="city" class="form-label">City</label>
                  <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}" required>
                  @error('city')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-md-6">
                  <label for="pincode" class="form-label">Pincode</label>
                  <input type="text" class="form-control @error('pincode') is-invalid @enderror" id="pincode" name="pincode" value="{{ old('pincode') }}" required>
                  @error('pincode')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
          </div>

          <div class="text-end">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Create User</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>


<!-- Add User Modal (remains unchanged) -->
<!-- Your existing modal code goes here -->

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize the DataTable
        var usersTable = $('#usersTable').DataTable({
            order: [] // Disable initial sorting
        });

        // Export to CSV functionality
        $('#exportCsv').on('click', function() {
            // Get the data from the table
            var data = usersTable.rows().data();

            // Prepare the CSV header
            var csvContent = "Name,Email,Phone,Location\n";

            // Loop through the data and append each row to the CSV content
            data.each(function(row) {
                csvContent += row[0] + "," + row[1] + "," + row[2] + "," + row[3] + "\n";
            });

            // Create a Blob object from the CSV content
            var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            var url = URL.createObjectURL(blob);

            // Create a link and simulate a click to trigger the download
            var link = document.createElement("a");
            link.setAttribute("href", url);
            link.setAttribute("download", "users_list.csv");
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });

    $('#modal_state').on('change', function () {
        var selectedState = $(this).val();
        var statesData = {!! json_encode($statesCities->states) !!};
        
        var cities = [];
        for (var i = 0; i < statesData.length; i++) {
            if (statesData[i].name === selectedState) {
                cities = statesData[i].cities;
                break;
            }
        }

        var modalCitySelect = $('#modal_city');
        modalCitySelect.empty().append('<option value="">Select City</option>');
        
        if (cities && cities.length > 0) {
            cities.forEach(function (city) {
                modalCitySelect.append(`<option value="${city}">${city}</option>`);
            });
        }
    });

    $('#addUserForm').submit(function(e) {
        e.preventDefault(); // Prevent default submission

        let form = $(this);
        let submitBtn = form.find('button[type="submit"]');
        let formData = form.serialize();

        submitBtn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                showToast('User added successfully!', 'success');
                form[0].reset();
                $('#addUserModal').modal('hide');
            },
            error: function(xhr) {
                let message = 'Something went wrong.';
            
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    // Show validation errors
                    message = Object.values(xhr.responseJSON.errors).join('\n');
                } else if (xhr.status === 409 && xhr.responseJSON.message) {
                    // Handle duplicate user conflict
                    message = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
            
                showToast(message, 'danger');
            },
            complete: function() {
                submitBtn.prop('disabled', false).text('Save User');
                window.reload()
            }
        });
    });

    function showToast(message, type = 'success') {
        const toastEl = $('#toastAlert');
        const toastBody = $('#toastMessage');

        toastBody.text(message);

        toastEl.removeClass('text-bg-success text-bg-danger text-bg-warning')
                .addClass(`text-bg-${type}`);

        const toast = new bootstrap.Toast(toastEl[0]);
        toast.show();
    }
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.send-password').forEach(function (button) {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-user-id');

            if (confirm("Are you sure you want to send the user's password?")) {
                fetch(`/donation-portal/admin/send-password/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to send password.');
                });
            }
        });
    });
});
</script>
@endpush
@endsection
