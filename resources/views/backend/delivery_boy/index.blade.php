@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">All Delivery Boys</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('delivery_boy.create') }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Add New Delivery Boys') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <form class="" id="sort_sellers" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('Delivery Boys') }}</h5>
                </div>
    
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="search"
                            name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type search word & Enter') }}">
                    </div>
                </div>
            </div>
        </form>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th  width="10%">#</th>
                        <th>Name</th>
                        <th>Shop Name</th>
                        <th >Email</th>
                        <th >Phone</th>
                        <th class="text-center" >Active Status</th>
                        <th class="text-center" width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $staff)
                        <tr>
                            <td>{{ $key + 1 + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td>{{ $staff->name }}</td>
                            <td>{{ $staff->shop?->name }}</td>
                            <td>{{ $staff->email }}</td>
                            <td>{{ $staff->phone }}</td>
                            <td class="text-center">
                                @if ($staff->banned == 0)
                                    <span class="badge badge-soft-success" style="width:40px;">Active </span>
                                @elseif ($staff->banned == 1)
                                    <span class="badge badge-soft-danger w-40" style="width:50px;">Inactive </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                    href="{{ route('delivery_boy.edit', encrypt($staff->id)) }}" title="Edit">
                                    <i class="las la-edit"></i>
                                </a>
                                @if ($staff->device_token != NULL)
                                    <button class="btn btn-sm btn-success d-innline-block clearDeviceToken" data-id="{{$staff->id}}">Clear Device Token</button>
                                @endif
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $users->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $(document).on("click", ".clearDeviceToken", function(e) {
            var id = $(this).attr('data-id');
            
            swal({
                title: "Are you sure?",
                text: "Do you want to clear device token?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ route('clear-device-token') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: '{{ @csrf_token() }}',
                        },
                        dataType: "html",
                        success: function(response) {
                            if(response == 1){
                                swal('Device token has been cleared successfully', {
                                    icon: "success",
                                });
                            }else{
                                swal("Something went wrong!", {
                                    icon: "error",
                                });
                            }
                            setTimeout(function () { 
                                location.reload(true); 
                            }, 3000); 
                        }
                    });
                }else{
                    $(this).val('');
                }
            });
           
        });

       
    </script>
@endsection
