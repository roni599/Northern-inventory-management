@extends('Admin.layout.master')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">


            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Developer /</span> Organization</h4>

            <div class="mt-3">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
                    Add Organization
                </button>

                <!-- Modal -->
                <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">Add Organization</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="errMsgContainer"></div>
                                <form id="createOrganization" data-route="{{ route('organization.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="nameWithTitle" class="form-label">Organization Name</label>
                                            <input type="text" id="nameWithTitle" class="form-control"
                                                placeholder="Enter Name" />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" id="addOrganization" type="button"
                                            class="btn btn-primary">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <!-- Basic Bootstrap Table -->
            <div class="card mt-3" id="organizationTableDiv">
                <h5 class="card-header">Categories</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table" id="organizationTable">
                        <thead>
                            <tr>
                                <th>Organization ID</th>
                                <th>Organization Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($organizations as $key => $organization)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $organization->organization_name }}</td>
                                    <td><span class="badge bg-label-success me-1">{{ $organization->status }}</span></td>
                                    <td class="d-flex">
                                        <button type="button" class="btn btn-link p-0 updateOrganizationButton"
                                            data-bs-toggle="modal" data-bs-target="#organizationUpdate"
                                            data-organization_id="{{ $organization->id }}"
                                            data-organization_name="{{ $organization->organization_name }}">
                                            <i class="bx bx-edit-alt me-1 bg-success p-2 rounded-2 text-white"></i>
                                        </button>
                                        <form id="organizationDelete" action="{{ route('organization.destroy') }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="organization_id" value="{{ $organization->id }}">
                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                class="btn btn-link p-0">
                                                <i class="bx bx-trash me-1 bg-danger p-2 rounded-2 text-white"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <span class="p-4 d-flex gap-3">
                        {!! $organizations->withQueryString()->links('pagination::bootstrap-5') !!}
                    </span>
                </div>
            </div>
        </div>


        <div class="modal fade" id="organizationUpdate" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="organizationUpdateTitle">Add Organization</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="errMsgContainer"></div>
                        <form id="updateOrganization" data-route="{{ route('organization.edit') }}">
                            @csrf
                            <input type="hidden" name="organization_id" id="organization_id">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Organization Name</label>
                                    <input type="text" name="nameWithTitle" id="organizationNameUpdate"
                                        class="form-control" placeholder="Enter Name" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" type="button" class="btn btn-primary">update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- / Content -->
        <div class="content-backdrop fade"></div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('Admin/js/organization.js') }}"></script>
    </div>
@endSection
