@extends('admin.layouts.default')
@section('content')
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{$title}}</h1>
        </div>
        <div class="col-sm-6">
           @include('admin.includes.breadcrumb',['breadcrumb'=>$breadcrumb])
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">{{$title}}</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
            <div class="row">
              <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">{{$total_price}}</span>
                    <span class="info-box-number text-center text-muted mb-0">{{$order->total_price}}</span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <div class="info-box bg-light">
                  <div class="info-box-content">
                    <span class="info-box-text text-center text-muted">{{$service_charge}}</span>
                    <span class="info-box-number text-center text-muted mb-0">{{$order->service_charge}}</span>
                  </div>
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-12">
                <h4>Order Items</h4>
                  <div class="post">
                    
                    <!-- <p> Lorem ipsum. </p> -->

                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">Item Id</th>
                          <th scope="col">Product</th>
                          <th scope="col">Quantity</th>
                        </tr>
                      </thead>
                      <tbody>

                        @foreach($order_items as $i)
                        <tr>
                          <th scope="row">{{$i->id}}</th>
                          <td>{{$i->prod_name}}</td>
                          <td>{{$i->qty}}</td>
                        </tr>
                        @endforeach
                        
                        
                      </tbody>
                    </table>

                  </div>

                  
              </div>
            </div>
          </div>
  

        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
    
@endsection