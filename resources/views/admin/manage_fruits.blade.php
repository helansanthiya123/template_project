 @include('admin.header')
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
   @include('admin.sidebar')
  <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>General Tables</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active">General</li>
        </ol>
      </nav>
      <span id="success_alert"></span>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Default Table</h5>

              <!-- Default Table -->
              <table class="table data-table" id="mytable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Files</th>
                    <th scope="col">Fruit Name</th>
                    <th scope="col">Fruit Rate</th>
                    <th scope="col">Action</th> 
                  </tr>
                </thead>
                
              </table>
              <!-- End Default Table Example -->
            </div>
          </div>
        </div>

        
      </div>
    </section>
    <section class="section">
      <div class="row">
        <div class="col-lg-6">

         
              
             
              <div class="modal fade" id="basicModal" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Basic Modal</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ url('updatefruit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id='id' name="edit_id">
                        <div class="row mb-3">
                          <label for="inputNumber" class="col-sm-3 col-form-label">File Upload</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="file" id="image" name="image" id="formFile" accept="image/*" required>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="inputText" class="col-sm-3 col-form-label">Rate</label>
                          <div class="col-sm-9">
                            <input type="text" name="rate" id="rate" class="form-control" pattern="[0-9]{1,5}" required>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label for="inputText" class="col-sm-3 col-form-label">Fruit Name</label>
                          <div class="col-sm-9">
                            <input type="text" name="fruit_name" id="fruit_name" class="form-control" pattern="[A-Za-z]{1,32}" required>
                          </div>
                        </div>
                        <div class="row mb-3">
                          {{-- <label class="col-sm-2 col-form-label">Submit Button</label> --}}
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary" id="update_fruit">Update Portfolio</button>
                          </div>
                        </div>
        
                      </form>
                    </div>
                    {{-- <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary">Save changes</button>
                    </div> --}}
                  </div>
                </div>
              </div><!-- End Basic Modal-->

        </div>

      </div>
    </section>
  </main><!-- End #main -->


  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


@include('admin.scripts')

<script type="text/javascript">
  $(function () {
      
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('managefruit') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'image_name', name: 'image_name',
                      render: function( data, type, full, meta ) {
                        return "<img src=\"/template_project/public/images/" + data + "\" height=\"50\"/>";
                      }
                  },
            {data: 'fruit_name', name: 'fruit_name'},
            {data: 'rate', name: 'rate'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
      
  });

  $(document).ready(function(){

     $('#mytable').on('click','.edit',function(){
          var id=$(this).attr('id');
          
          $('#basicModal').modal('show');
          $.ajax({
              url:'editfruit/'+id,
              dataType:'json',
              success:function(data)
              {
                  // $('#image').val(data.result.image_name);
                  $('#rate').val(data.result.rate);
                  $('#fruit_name').val(data.result.fruit_name);
                  $('#id').val(data.result.id);
              }
            });
        
  });

  $('#mytable').on('click','.delete',function(){
            var id=$(this).attr('id');
            
            $.ajax({
              url:'deletefruit/'+id,
              dataType:'json',
              success:function(data)
              {
                
                if(data.success)
                {
                   
                  // $('#success_alert').html('<div class="alert alert-success">' + data.success + '</div>');
                  $('#success_alert').append('<div class="toast show" role="alert" aria-live="assertive" aria-atomic="true"><div class="toast-header"><span class="svg-icon svg-icon-2 svg-icon-primary me-3"><img src="assets/img/logo2.png" height="10" width="10"></span><strong class="me-auto">Fruit detail deleted</strong><small>!</small><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div></div>');
                  $('#mytable').DataTable().ajax.reload();
                }
                
              }
            });

          });

  });
</script>

</body>

</html>