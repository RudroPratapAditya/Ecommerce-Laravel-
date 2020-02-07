@extends('layout')
@section('content')

<div>
		
	
	
           
	

			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>All Available Products</h2>
						
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  
								  <th>Product Name</th>
								  <th>Product Image</th>
								  <th>Action</th>
								  
								  
							  </tr>
						  </thead>   
						 @foreach($all_product as $v_product)
						  <tbody>
							<tr>
								{{-- <td>{{ $v_product->product_id }}</td> --}}
								<td class="center">{{$v_product->product_name}}</td>
								<td><img src="{{URL::to($v_product->product_image)}}"   height="100" width="100" style="border-radius: 50%;" ></td>
								<td>
									<a class="btn btn-sm btn-success" href="{{url('/view_product/'.$v_product->product_id)}}"">View Product</a>
									
								</td>
								
							</tr>
							
						  </tbody>
						  @endforeach

					  </table>  
					
				
			
		</div>          
	</div>
</div><!--/span-->
</div>
				<div class="text-center">
				      {{ $all_product->links() }}
				</div>
</div>





@endsection

