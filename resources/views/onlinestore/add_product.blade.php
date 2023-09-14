@extends('layout')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ecommerce manager') }}</div>
  
                <div class="card-body">
                    
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="container mt-2">
                        <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="pull-left">
                                    <h2></h2>
                                </div>
                                <div class="pull-right mb-2">
                                    <a class="btn btn-success" href="{{ route('onlinestore.create-product') }}"> Add product</a>
                                    <a class="btn btn-success" href="{{ route('onlinestore.create-category') }}"> Add category</a>
                                    <a class="btn btn-success" href="{{ route('products') }}"> Onlinestore</a>
                                </div>
                            </div>
                        </div>
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Color</th>
                                    <th>Size</th>
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                    @foreach ($products as $product)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td><img src="/image/{{ $product->image }}" width="100px"></td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{$product->category->name}}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->color }}</td>
                                        <td>{{ $product->size }}</td>
                                        <td>
                                            <form action="{{url('/onlinestore-destroy/'.$product->id)}}" method="POST">
                                                 
                                               <!--  <a class="btn btn-info" href="#">Show</a> -->
                                  
                                              <a class="btn btn-primary"  href="{{url('/onlinestore-edit/'.$product->id)}}">Edit</a>
                                 
                                                @csrf
                                                @method('DELETE')
                                    
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
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
@endsection