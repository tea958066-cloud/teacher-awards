@extends('layouts.admin')

@section('title', 'Manage Teachers')
@section('page-title', 'Manage Teachers')

@section('content')

<div class="row g-4">
    <!-- Add Teacher -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h6 class="fw-bold mb-0"><i class="bi bi-person-plus-fill me-2 text-success"></i>Add New Teacher</h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.teachers.add') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Teacher Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               placeholder="e.g. Mr Smith" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-plus-circle me-1"></i>Add Teacher
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Teacher List -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-people-fill me-2 text-primary"></i>All Teachers</h6>
                <span class="badge bg-primary">{{ $teachers->count() }} total</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Name</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Voted</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $teacher)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width:36px;height:36px;border-radius:50%;background:{{ $teacher->is_active ? 'linear-gradient(135deg,#3949ab,#7b1fa2)' : '#e0e0e0' }};color:{{ $teacher->is_active ? '#fff' : '#9e9e9e' }};display:flex;align-items:center;justify-content:center;font-weight:700">
                                            {{ substr($teacher->name, 0, 1) }}
                                        </div>
                                        <span class="fw-semibold {{ !$teacher->is_active ? 'text-muted' : '' }}">{{ $teacher->name }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $teacher->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($teacher->has_voted)
                                        <span class="badge bg-primary"><i class="bi bi-check me-1"></i>Voted</span>
                                    @else
                                        <span class="badge bg-light text-muted">Not Yet</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <!-- Edit -->
                                    <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $teacher->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <!-- Toggle -->
                                    <form method="POST" action="{{ route('admin.teachers.toggle', $teacher) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $teacher->is_active ? 'btn-outline-warning' : 'btn-outline-success' }} me-1"
                                                title="{{ $teacher->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="bi bi-{{ $teacher->is_active ? 'toggle-on' : 'toggle-off' }}"></i>
                                        </button>
                                    </form>
                                    <!-- Delete -->
                                    <form method="POST" action="{{ route('admin.teachers.delete', $teacher) }}" class="d-inline"
                                          onsubmit="return confirm('Remove {{ $teacher->name }}? This will also delete their votes.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $teacher->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius:14px;overflow:hidden">
                                        <div class="modal-header" style="background:#1a237e;color:#fff">
                                            <h6 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Teacher</h6>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}">
                                            @csrf
                                            <div class="modal-body p-4">
                                                <label class="form-label fw-semibold">Teacher Name</label>
                                                <input type="text" name="name" class="form-control"
                                                       value="{{ $teacher->name }}" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
