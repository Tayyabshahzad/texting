@extends('layouts.master')
@section('page_css')
    <style>
        .modal-content{
            transform: unset !important;
        }
    </style>
@endsection
@section('content')
    <div class="row td-subscriptions">
        <div class="col-md-12 px-5 py-3">
            <h2 class="td-dashboard-title">Subscriptions</h2>
        </div>
        <div class="col-md-12 px-5 py-3 d-md-flex justify-content-between">
            <div class="search w-75">
                <input class="td-subscription-search" type="text" placeholder="Search" />
            </div>
            <div>
                <button class="td-addGroup-btn" data-bs-toggle="modal" data-bs-target="#myModal" >+ Add New Group</button>
                <button class="td-addGroup-btn" data-bs-toggle="modal" data-bs-target="#myModalViewGroup" > View Groups</button>
            </div>

             <!-- Button to trigger the modal -->


      <!-- Modal -->
      <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:20%">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"> Create Subscriber Group             </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('create-group') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                            <label for=""> Group Name </label>
                            <input type="text" name="group_name" id="" required>
                    </div>
                    <table class="table">
                        @foreach ($subscribers as $subscriber )
                            <tr>
                                <td> <input type="checkbox" name="subscribers[]" value="{{  $subscriber->id  }}"/> </td> <td>  {{ $subscriber->name }} </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="myModalViewGroup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:20%">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"> View Groups  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('delete-group-v2') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <table class="table">
                        @foreach ($groups as $group )
                            <tr>
                                <td>    <input type="radio" name="group_id" value="{{  $group->id  }}" required/> </td>
                                 <td>   {{ $group->name }} </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Delete Group</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
        </div>
        <div class="col-md-12 px-5 py-3 td-subscribers-table">
            <div>
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Redeemed Coupon</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscribers as $subscriber)
                            <tr>
                                <td> {{ $subscriber->name }} </td>
                                <td> {{ $subscriber->phone }} </td>
                                <td> {{ $subscriber->redeemed_count }}</td>
                                <td>
                                    <button type="button" class="btn-popup" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        View
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog h-100">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    Redeemed Coupons
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="d-flex justify-content-between align-items-center border-bottom mb-2">
                                    <div>
                                        <h3>Business Testing 2</h3>
                                        <p>Business Testing 2</p>
                                    </div>
                                    <div>
                                        <button class="td-eye">
                                            <img src="./assets/images/eye.png" alt="eye" />
                                        </button>
                                        <button class="td-del">
                                            <img src="./assets/images/delete.png" alt="bin" />
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center border-bottom mb-2">
                                    <div>
                                        <h3>Business Testing 2</h3>
                                        <p>Business Testing 2</p>
                                    </div>
                                    <div>
                                        <button class="td-eye">
                                            <img src="./assets/images/eye.png" alt="eye" />
                                        </button>
                                        <button class="td-del">
                                            <img src="./assets/images/delete.png" alt="bin" />
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center border-bottom mb-2">
                                    <div>
                                        <h3>Business Testing 2</h3>
                                        <p>Business Testing 2</p>
                                    </div>
                                    <div>
                                        <button class="td-eye">
                                            <img src="./assets/images/eye.png" alt="eye" />
                                        </button>
                                        <button class="td-del">
                                            <img src="./assets/images/delete.png" alt="bin" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_js')
@endsection
