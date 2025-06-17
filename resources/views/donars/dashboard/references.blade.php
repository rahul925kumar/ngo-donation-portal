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
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="ref-btn">
                            <a type="button" class="btn btn-primary1 Member" href="{{route('getRefferenceRegistration')}}">New Reference</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Reference's</h4>
                        </div><!-- end card header -->

                        <div class="card-body">

                            <div class="live-preview">
                                <div class="table-responsive">
                                    <table class="table table-nowrap mb-0" id="donations-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">S.No.</th>
                                                <td scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Mobile</th>
                                                <th scope="col">Created</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($references as $key => $reference)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $reference->salutation }} {{ $reference->name }}</td>
                                                    <td>{{ $reference->email }}</td>
                                                    <td>{{ $reference->phone_number }}</td>
                                                    <td>{{ $reference->created_at->format('d-m-Y') }}</td>
                                                    <td><button class="btn btn-danger delete-reference-btn" data-id="{{$reference->id}}" onclick="">Delete</button></td>
                                                    deleteRefferenceRegistration
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-light">

                                        </tfoot>
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
new DataTable('#donations-table');

$(document).on('click', '.delete-reference-btn', function () {
    let id = $(this).data('id');

    if (!confirm('Are you sure you want to delete this reference?')) return;

    $.ajax({
        url: "{{ route('deleteRefferenceRegistration') }}",
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id
        },
        success: function (response) {
            alert('Reference deleted successfully.');
            location.reload(); // Or remove the row dynamically
        },
        error: function (xhr) {
            alert('An error occurred while deleting.');
            console.log(xhr.responseText);
        }
    });
});
</script>

@endsection