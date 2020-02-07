@extends('layout')
@section('content')
<div style="margin-top: 10px" class="container">
   <a href="{{route('about')}}" class="btn btn-sm btn-warning">back</a> 
</div>
 <h1 style="margin-left: 10px"> Details About: <span style="font-style: oblique;font-family: serif;">{{ $single_contact->contact_name }}</span></h1>
              <hr>
 <div  style="margin-left: 20px;margin-top: 30px;background-color: darkcyan;border-radius: 10px">
               <!-- Basic example -->
             
              
               
                    
                        
                        

                        <div class="panel-body">
                            
                                <div style="margin-left: 200px" class="form-group">
                                    <p><img style="height: 400px; width: 400px;border-radius: 500px"  src="{{ URL::to($single_contact->contact_image) }}" /></p>
                                </div>
                                <h1 style="margin-left: 320px;color: gold">Developer</h1>
                                <h4 style="margin-left: 320px;color: orange">PHP & Laravel Expert</h4>
                                <hr style="height: 7px">
                                <br>
                                <div style="margin-left: 300px">
                                    <div class="form-group">
                                    <label style="font-size: large;" for="exampleInputEmail1"><b>Name</b></label>
                                   <p style="font-size: medium;color: white;">{{ $single_contact->contact_name }}</p>
                                </div>
                                <div class="form-group">
                                    <label style="font-size: large;" for="exampleInputPassword20"><b>Email</b></label>
                                     <p style="font-size: medium;color: white;">{{ $single_contact->contact_email }}</p>
                                </div>
                                <div class="form-group">
                                    <label style="font-size: large;" for="exampleInputPassword21"><b>Address</b></label>
                                     <p style="font-size: medium; color: white;">{{ $single_contact->contact_address }}</p>
                                </div>
                                <div class="form-group">
                                    <label style="font-size: large;" for="exampleInputPassword19"><b>City</b></label>
                                     <p style="font-size: medium;color: white;">{{ $single_contact->contact_city }}</p>
                                </div>
                                <div class="form-group">
                                    <label style="font-size: large;" for="exampleInputPassword18"><b>Contact Number</b></label>
                                     <p style="font-size: medium;color: white;">{{ $single_contact->contact_phone }}</p>
                                </div>
                                
                                </div>
                                <hr>
                            
                        </div><!-- panel-body -->
                    </div> <!-- panel -->
                

           
       
   
@endsection
       
                   
   







