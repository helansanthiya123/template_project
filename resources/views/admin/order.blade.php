@include('admin.header')
@include('admin.sidebar')
<main id="main" class="main">
<section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">New Order <span class="float-right"><a href="{{ url('order-history') }}" class="btn btn-warning ">Order History</a></span> </h5>
            
            <!-- Default Table -->
            <table class="table data-table" id="mytable">
              <thead>
                <tr>
                  
                  <th scope="col">Order Date</th>
                  <th scope="col">Tracking Number</th>
                  <th scope="col">Total Price</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th> 
                </tr>
              </thead>

              <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ date('d-m-Y',strtotime($order->created_at))  }}</td>
                    <td>{{ $order->tracking_no }}</td>
                    <td>{{ $order->subtotal }}</td>
                    <td>{{ $order->status='0' ? 'Completed' :  'Pending' }}</td>
                    <td><a href="{{ url('admin_view_order/'.$order->id) }}" class="btn btn-primary">View</a></td>
                </tr>
                @endforeach
                
              </tbody>
              
            </table>

            <!-- End Default Table Example -->
          </div>
        </div>
      </div>

      
    </div>
  </section>
</main>