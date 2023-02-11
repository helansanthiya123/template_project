@include('template_folder.header')

	<!-- search area -->
	<div class="search-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<span class="close-btn"><i class="fas fa-window-close"></i></span>
					<div class="search-bar">
						<div class="search-bar-tablecell">
							<h3>Search For:</h3>
							<input type="text" placeholder="Keywords">
							<button type="submit">Search <i class="fas fa-search"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end search arewa -->
	
	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Fresh and Organic</p>
						<h1>Check Out Product</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- check out section -->
	<div class="checkout-section mt-4">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-6">
					<div class="checkout-accordion-wrap">
						<div class="accordion" id="accordionExample">
						  <div class="card single-accordion">
						    <div class="card-header" id="headingOne">
						      <h5 class="mb-0">
						        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						          Billing Address <span><a href="{{ url('order') }}" class="btn btn-primary float-right">Back</a></span>
						        </button>
								
						      </h5>
						    </div>

						    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
						      <div class="card-body">
								@foreach ($orders as $order )
									
								
                                <label for="">Name</label>
                                <div class="border p-2">{{ $order->name }}</div>
                                <label for="">Email</label>
                                <div class="border p-2">{{ $order->email }}</div>
                                <label for="">Contact</label>
                                <div class="border p-2">{{ $order->phone }}</div>
                                <label for="">Billing Address</label>
                                <div class="border p-2">
                                   {{ $order->address }}
                                </div>
								@endforeach
						        {{-- <div class="billing-address-form">
						        	<form action="#" id="myform" method="POST">
						        		@csrf
										<p><input type="text" placeholder="Name" name="name"></p>
						        		<p><input type="email" placeholder="Email"  name="email"></p>
						        		<p><input type="text" placeholder="Address" name="address"></p>
						        		<p><input type="tel" placeholder="Phone" name="phone"></p>
						        		<p><textarea name="message" id="bill" cols="30" rows="10" placeholder="Say Something"></textarea></p>
										<input type="hidden" id="subtotal" name="subtotal">
									</form>
						        </div> --}}
						      </div>
						    </div>
						  </div>
						 
						</div>

					</div>
				</div>

				<div class="col-lg-6">
					<div class="order-details-wrap">
						<table class="order-details" style="width: 100%;">
							<thead>
                                <tr class="text-center">
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                </tr>        
                            </thead>
                            <tbody>
								@foreach ($orderitems as $item)
								<tr class="text-center">
                                    <td>{{ $item->fruit_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->price*$item->quantity }}</td>
                                    <td><img src="{{ asset('images/'.$item->image_name) }}" alt="" width="100" height="70"></td>
                                </tr>
								@endforeach
								
								
                                
                            </tbody>
						</table>
						<h4 class="mt-3">Grand Total:{{ $order->subtotal }}</h4>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end check out section -->

	<!-- logo carousel -->
	<div class="logo-carousel-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="logo-carousel-inner">
						<div class="single-logo-item">
							<img src="assets/img/company-logos/1.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/2.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/3.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/4.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/5.png" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end logo carousel -->

	<!-- footer -->
	<div class="footer-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<div class="footer-box about-widget">
						<h2 class="widget-title">About us</h2>
						<p>Ut enim ad minim veniam perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae.</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box get-in-touch">
						<h2 class="widget-title">Get in Touch</h2>
						<ul>
							<li>34/8, East Hukupara, Gifirtok, Sadan.</li>
							<li>support@fruitkha.com</li>
							<li>+00 111 222 3333</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box pages">
						<h2 class="widget-title">Pages</h2>
						<ul>
							<li><a href="index.html">Home</a></li>
							<li><a href="about.html">About</a></li>
							<li><a href="services.html">Shop</a></li>
							<li><a href="news.html">News</a></li>
							<li><a href="contact.html">Contact</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box subscribe">
						<h2 class="widget-title">Subscribe</h2>
						<p>Subscribe to our mailing list to get the latest updates.</p>
						<form action="index.html">
							<input type="email" placeholder="Email">
							<button type="submit"><i class="fas fa-paper-plane"></i></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end footer -->
	
	<!-- copyright -->
	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<p>Copyrights &copy; 2019 - <a href="https://imransdesign.com/">Imran Hossain</a>,  All Rights Reserved.<br>
						Distributed By - <a href="https://themewagon.com/">Themewagon</a>
					</p>
				</div>
				<div class="col-lg-6 text-right col-md-12">
					<div class="social-icons">
						<ul>
							<li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end copyright -->
	@include('template_folder.scripts')


</body>
</html>