@extends('Admin.layout.master')
@section('content')

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">


                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('user.dashbord') }}"><i
                        class='bx bx-left-arrow-alt fs-4 mb-1 me-3'></i></a>Product</span> / Product List</h4>

                <div class="d-flex mb-3 gap-2">
                    <input type="text" class="form-control w-50" placeholder="Search here.....">
                    <button class="btn btn-primary">Search</button>
                </div>


              
                <div class="card mt-3">
                <h5 class="card-header">Products</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Assigned For</th>
                        <th>Expiry Time</th>
                        <th>Quantity</th>
                        <th>Organization</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <tr>
                        <td>1</td>
                        <td>Graph Paper</td>
                        <td>Others</td>
                        <td>Faculty</td>
                        <td>30</td>
                        <td>100</td>
                        <td>Northern</td>
                        <td><span class="badge bg-label-success me-1">Active</span></td>
                        <td class="d-flex">
                            <a href="#"><i class="bx bx-edit-alt me-1 bg-success p-2 rounded-2 text-white"></i></a>
                            <a href="#"><i class="bx bx-trash me-1 bg-danger p-2 rounded-2 text-white"></i></a>
                        </td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>Pen</td>
                        <td>Others</td>
                        <td>Faculty</td>
                        <td>30</td>
                        <td>100</td>
                        <td>Northern</td>
                        <td><span class="badge bg-label-success me-1">Active</span></td>
                        <td class="d-flex">
                            <a href="#"><i class="bx bx-edit-alt me-1 bg-success p-2 rounded-2 text-white"></i></a>
                            <a href="#"><i class="bx bx-trash me-1 bg-danger p-2 rounded-2 text-white"></i></a>
                        </td>
                      </tr>



                    </tbody>
                  </table>
                </div>


              </div>
            


            <div class="content-backdrop fade"></div>
          </div>
            



@endSection