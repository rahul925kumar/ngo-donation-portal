@extends('admin.layouts.app')

@section('title', 'Celebrations Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Celebrations List</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="celebrationsTable">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($celebrations as $celebration)
                    <tr>
                        <td>{{ $celebration->user->name }}</td>
                        <td>{{ $celebration->title }}</td>
                        <td>{{ $celebration->date }}</td>
                        <td>
                            <span class="badge bg-{{ $celebration->status === 'approved' ? 'success' : 'warning' }}">
                                {{ ucfirst($celebration->status) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.celebrations.delete', $celebration) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this celebration?')">
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('#celebrationsTable').DataTable();
    });
</script>
@endpush
@endsection