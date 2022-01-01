
@extends('base')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="text-uppercase">{{$active_dir}} Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Edit Form</h3>
          </div>
          <!-- /.card-header -->
        <form method="post" action='{{route("$active_dir.update",$data->id)}}' enctype="multipart/form-data" >
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Select Product</label>
                  <select name="product_id" class="form-control select2bs4" style="width: 100%;">
                    @foreach($products as $product)
                      <option value="{{ $product->id }}" {{ $data->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>

            <div class="row">

              <div class="col-sm-12">
                <div class="form-group">
                    <label>Price Currency:</label>
                    <input type="text" name="price" value="{{ $data->price }}" class="form-control">
                  </div>
              </div>

            </div>
            
            <div class="row">

              <div class="col-sm-12">
                <div class="form-group">
                  <label>Proposal:</label>
                  <textarea class="form-control" name="proposal" id="" cols="30" rows="10"> {{ $data->proposal }} </textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <!-- radio -->
                <div class="form-group clearfix">
                  <div class="icheck-primary d-inline">
                    <input type="radio" value="1" id="radioPrimary1" name="favorite" {{ $data->favorite == 1 ? 'checked' : '' }} >
                    <label for="radioPrimary1">
                      Yes
                    </label>
                  </div>
                  <div class="icheck-primary d-inline">
                    <input type="radio" value="0" id="radioPrimary3" name="favorite" {{ $data->favorite == 0 ? 'checked' : '' }} >
                    <label for="radioPrimary3">
                      No
                    </label>
                  </div>
                </div>
              </div>

              <!-- /.col -->
            </div>
            <!-- /.row -->


        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="custom-file">
                <input type="file" name="image" accept="image/*" class="custom-file-input" id="customFile1">
                <label class="custom-file-label" for="customFile1">Choose an image</label>
              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <div class="custom-file">
                <input type="file" name="document" accept="application/pdf" class="custom-file-input" id="customFile2">
                <label class="custom-file-label" for="customFile2">Choose a document</label>
              </div>
            </div>
          </div>
        </div>

        <div class="row">

          <div class="col-sm-4">
            <div class="form-group">
                <label>Longitude:</label>
                <input type="text" name="longitude" value="{{ $data->longitude }}" class="form-control">
              </div>
          </div>

          <div class="col-sm-4">
            <div class="form-group">
                <label>Latitude:</label>
                <input type="text" name="latitude" value="{{ $data->latitude }}" class="form-control">
              </div>
          </div>

          <div class="col-sm-4">
            <div class="form-group">
                <label>Country:</label>
                <input type="text" name="country" value="{{ $data->country }}" class="form-control">
              </div>
          </div>


        </div>

        <div class="row">

          <div class="col-sm-12">
            <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary form-control">
              </div>
          </div>

        </div>


          </div>
          <!-- /.card-body -->

      </form>

        </div>
        <!-- /.card -->

  
        <!-- /.row -->
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  @endsection

  @section('js')
  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
  <script type="text/javascript"
src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>

  <!-- <script
      src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initAutocomplete&libraries=places&v=weekly"
      async
    ></script> -->
    src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>

    <script type="text/javascript">
    google.maps.event.addDomListener(window, 'load', function() {
        var places = new google.maps.places.Autocomplete(document
                .getElementById('txtPlaces'));
        google.maps.event.addListener(places, 'place_changed', function() {
            var place = places.getPlace();
            var address = place.formatted_address;
            var  value = address.split(",");
            console.log(address);
            alert("ok");
            count=value.length;
            country=value[count-1];
            state=value[count-2];
            city=value[count-3];
            var z=state.split(" ");
            document.getElementById("selCountry").text = country;
            var i =z.length;
            document.getElementById("pstate").value = z[1];
            if(i>2)
            document.getElementById("pzcode").value = z[2];
            document.getElementById("pCity").value = city;
            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();
            var mesg = address;
            document.getElementById("txtPlaces").value = mesg;
            var lati = latitude;
            document.getElementById("plati").value = lati;
            var longi = longitude;
            document.getElementById("plongi").value = longi;            
        });
    });
</script>

  @endsection