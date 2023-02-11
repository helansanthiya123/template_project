@include('admin.header')
@include('admin.sidebar')
<main id="main" class="main">
    <section class="section">
        <div class="row">
          <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Shipping Details</h5>
                    @foreach ($orders as $order)
                        <label for="" class="text-secondary">Name</label>
                        <div class="border p-2">{{ $order->name }}</div>
                        <label for="" class="text-secondary">Email</label>
                        <div class="border p-2">{{ $order->email }}</div>
                        <label for="" class="text-secondary">Contact</label>
                        <div class="border p-2">{{ $order->phone }}</div>
                        <label for="" class="text-secondary">Billing Address</label>
                        <div class="border p-2">{{ $order->address }}</div>
                    @endforeach
                   
                </div>
              </div>
          </div>
          <div class="col-lg-7">
    
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Order Details</h5>
    
                <!-- Default Table -->
                <table class="table data-table" id="mytable">
                  <thead>
                    <tr>
                      
                      <th scope="col">Name</th>
                      <th scope="col">Quantity</th>
                      <th scope="col">Price</th>
                      <th scope="col">Image</th> 
                    </tr>
                  </thead>
    
                  <tbody>
                   @foreach ($orderitems as $orderitem)
                        <tr>
                            <td>{{ $orderitem->fruit_name }}</td>
                            <td>{{ $orderitem->quantity }}</td>
                            <td>{{ $orderitem->price*$orderitem->quantity }}</td>
                            <td><img src="{{ asset('images/'.$orderitem->image_name) }}" alt="" width="100" height="70"></td>
                        </tr>
                   @endforeach
                   
                  </tbody>
                  
                </table>
                <h4 class="mt-3">Grand Total:{{ $order->subtotal }}</h4>
                <label class="col-sm-2 col-form-label ">Order Status</label>
                <form action="{{ url('update-order/'.$order->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <select class="form-select" aria-label="Default select example" name="order_status">
                        
                        <option {{ $order->status == '0'?'selected':'' }}value="0">Pending</option>
                        <option {{ $order->status == '1'?'selected':''  }}value="1">Completed</option>
                    </select>
                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                </form>
                <!-- End Default Table Example -->
              </div>
            </div>
          </div>
    
          
        </div>
      </section>
    </main>