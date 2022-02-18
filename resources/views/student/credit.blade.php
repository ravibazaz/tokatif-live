@include('include/head')
@include('include/student-dashboard-header')

@php 
    $getLoggedIndata = getLoggedinData();
    $getVisitorCountry = getVisitorCountry();
@endphp


<section class="Purchase-page">
<div class="container">
  <div class="row">
      
     <div class="col-lg-9 col-md-8 col-sm-12 col-12">
          @if(Session::get('success'))
          <div class="alert alert-success alert-dismissible fade show">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> {{Session::get('success')}}</div>
          @endif
          @if(Session::get('error'))
          <div class="alert alert-danger alert-dismissible fade show">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Note!</strong> {{Session::get('error')}}</div>
          @endif
      
       <h3 class="title-h3">How Many tokatif tokens Would You Like To Purchase?</h3>
       <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-4 col-12">
          <div class="slot-box">
           <h4>$ 100 USD</h4>
            <input class="form-check-input creditAmt" type="radio" name="creditAmount" id="" value="100" > 
         </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-12">
          <div class="slot-box">
           <h4>$ 300 USD</h4>
            <input class="form-check-input creditAmt" type="radio" name="creditAmount" id="" value="300" >
         </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-12">
          <div class="slot-box " type="button" class="btn btn-primary" data-toggle="modal" data-target="#transaction_details">
           <h4>$ 500 USD</h4>
            <input class="form-check-input creditAmt" type="radio" name="creditAmount" id="" value="500" >
         </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-12">
          <div class="slot-box">
           <h4>$ 700 USD</h4>
            <input class="form-check-input creditAmt" type="radio" name="creditAmount" id="" value="700" >
         </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-12">
          <div class="slot-box">
           <h4>$ 900 USD</h4>
            <input class="form-check-input creditAmt" type="radio" name="creditAmount" id="" value="900" >
         </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-12">
          <div class="slot-box">
           <h4>$ 1200 USD</h4>
            <input class="form-check-input creditAmt" type="radio" name="creditAmount" id="" value="1200" >
         </div>
        </div>
        @if ($errors->has('credit_amount'))
            <span class="text-danger">{{ $errors->first('credit_amount') }}</span>
        @endif
       </div>
       <div class="row">
        <div class="col-md-12 mb-5 mt-4">
          <div class="input-group">
            <input type="text" class="form-control" id="creditvalue" placeholder="Enter Your Amount" aria-describedby="inputGroupPrepend" required disabled>
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroupPrepend">USD</span>
            </div>
          </div>
        </div>    
        </div>
       <div class="purchase-card">
          
         <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
            Select A New Payment Method</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
            Use A Saved Method</a>
          </div>
        </nav>
        <div class="tab-content mt-4" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <form action="{{ route('stripe.credit.post') }}" method="POST" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"> 
            @csrf
            
            <input type="hidden" id="credit_amount" name="credit_amount" value="" />
            
            <div class="row">
                <div class="col-lg-12 col-12">
                    <label>Cardholder's Name</label>
                    <input type="text" name="c_cardholder_name" id="c_cardholder_name" class="form-control" value="{{Request::old('c_cardholder_name')}}" required> 
                    @if ($errors->has('c_cardholder_name'))
                        <span class="text-danger">{{ $errors->first('c_cardholder_name') }}</span>
                    @endif
                </div>
             </div>   
              <div class="row mt-3">   
                <div class="col-lg-12 col-12">
                    <label>Card Number</label>
                    <input type="text" name="c_card_no" id="c_card_no" size="20" value="{{Request::old('c_card_no')}}" class="form-control card-number" required> 
                    @if ($errors->has('c_card_no'))
                        <span class="text-danger">{{ $errors->first('c_card_no') }}</span>
                    @endif
                </div>
               </div> 
                
                
               
                <div class="row mt-3"> 
                    <div class="col-lg-4 col-12"> 
                        <label>Expiry Month</label>
                        <select name="c_expiry_month" id="c_expiry_month" class="form-control card-expiry-month" required>
                            <option value="01" {{ (Request::old('c_expiry_month') == '01') ? 'selected' : '' }}>01</option>
                            <option value="02" {{ (Request::old('c_expiry_month') == '02') ? 'selected' : '' }}>02</option>
                            <option value="03" {{ (Request::old('c_expiry_month') == '03') ? 'selected' : '' }}>03</option>
                            <option value="04" {{ (Request::old('c_expiry_month') == '04') ? 'selected' : '' }}>04</option>
                            <option value="05" {{ (Request::old('c_expiry_month') == '05') ? 'selected' : '' }}>05</option>
                            <option value="06" {{ (Request::old('c_expiry_month') == '06') ? 'selected' : '' }}>06</option>
                            <option value="07" {{ (Request::old('c_expiry_month') == '07') ? 'selected' : '' }}>07</option>
                            <option value="08" {{ (Request::old('c_expiry_month') == '08') ? 'selected' : '' }}>08</option>
                            <option value="09" {{ (Request::old('c_expiry_month') == '09') ? 'selected' : '' }}>09</option>
                            <option value="10" {{ (Request::old('c_expiry_month') == '10') ? 'selected' : '' }}>10</option>
                            <option value="11" {{ (Request::old('c_expiry_month') == '11') ? 'selected' : '' }}>11</option>
                            <option value="12" {{ (Request::old('c_expiry_month') == '12') ? 'selected' : '' }}>12</option>
                        </select>
                        @if ($errors->has('c_expiry_month'))
                            <span class="text-danger">{{ $errors->first('c_expiry_month') }}</span>
                        @endif
                    </div>
                    <div class="col-lg-4 col-12">
                        <label>Expiry Year</label>
                        <input type="text" name="c_expiry_year" id="c_expiry_year" size="4" value="{{Request::old('c_expiry_year')}}" class="form-control card-expiry-year" required> 
                        @if ($errors->has('c_expiry_year'))
                            <span class="text-danger">{{ $errors->first('c_expiry_year') }}</span>
                        @endif
                    </div>
                    <div class="col-lg-4 col-12">
                        <label>Security Code (CVV)</label>
                        <input type="text" name="c_cvv" id="c_cvv" size="3" value="{{Request::old('c_cvv')}}" class="form-control card-cvc" required> 
                        @if ($errors->has('c_cvv'))
                            <span class="text-danger">{{ $errors->first('c_cvv') }}</span>
                        @endif
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12 col-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="saveinformation" id="saveinformation" class="custom-control-input" > 
                            <label class="custom-control-label" for="saveinformation">Save this card information for next time</label>
                        </div>
                    </div>
                </div> 
                        
                <div class="row">
                    <div class="col-lg-12 col-12 mt-3">
                     <p>All currency conversion is an estimate and may vary. <br/>
                        Your final payment will be made in USD. All sales are final, <br/>
                        purchases may be refunded for Tokatif Credits only.</p>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-lg-12 col-12 mt-3">
                        <button type="submit" class="btn btn-submit">Pay USD <span id="creditAmtSpan"></span></button>
                    </div>
                </div>
            
             
            </form>
          </div>
          <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="row">
                
               @foreach($userCardDetail as $val)
               <div class="col-lg-12 col-12">
                <div class="communication-row ">
                     <div class="row align-items-center"> 
                       <div class="col-lg-1 col-12"> 
                         <div class="form-check">
                          <!--<input class="form-check-input" type="radio" name="exampleRadiosSkype" id="" value="exampleRadiosSkype" checked="">-->
                         </div>
                        </div>
                        
                        <div class="col-lg-8 col-12">
                          <div class="visa-details">
                         <img src="{{ asset('public/frontendassets/images/stripe.png') }}" class="img-fluid"/> 
                         <h5>Card Number</h5>
                         <p>{{$val->card_no}}</p>
                         </div>
                        </div>
                        
                        <div class="col-lg-3 col-12">
                           <h5>Expiration Date</h5>
                            <h6>{{$val->expiry_month}}/{{$val->expiry_year}}</h6>
                        </div>
                        
                      </div>
                   </div>
               </div>     
               @endforeach
               
               <!--<div class="col-lg-12 col-12">
                <div class="communication-row active">
                     <div class="row align-items-center"> 
                       <div class="col-lg-1 col-12"> 
                         <div class="form-check">
                          <input class="form-check-input" type="radio" name="exampleRadiosSkype" id="" value="exampleRadiosSkype" checked="">
                        </div>
                        </div>
                        
                        <div class="col-lg-8 col-12">
                          <div class="visa-details">
                         <img src="{{ asset('public/frontendassets/images/stripe.png') }}" class="img-fluid"/> 
                         <h5>Card Number</h5>
                         <p>85XX - XXXX - XXXX - 8080</p>
                         </div>
                        </div>
                        
                        <div class="col-lg-3 col-12">
                           <h5>Expiration Date</h5>
                            <h6>07/25</h6>
                        </div>
                        
                      </div>
                   </div>
               </div><div class="col-lg-12 col-12">
                 <div class="communication-row">                                     
                   <div class="row align-items-center"> 
                       <div class="col-lg-1 col-12"> 
                         <div class="form-check">
                          <input class="form-check-input" type="radio" name="exampleRadiosSkype" id="" value="exampleRadiosSkype" checked="">
                        </div>
                        </div>
                        
                        <div class="col-lg-8 col-12">
                          <div class="visa-details">
                         <img src="{{ asset('public/frontendassets/images/paypal.png') }}" class="img-fluid"/> 
                         <h5>Card Number</h5>
                         <p>85XX - XXXX - XXXX - 8080</p>
                         </div>
                        </div>
                        
                        <div class="col-lg-3 col-12">
                           <h5>Expiration Date</h5>
                            <h6>07/25</h6>
                        </div>
                        
                      </div>   
                 </div>
               </div> -->
               <div class="col-lg-12 col-12 mt-3">
                 <p>All currency conversion is an estimate and may vary.<br/>
        			Your final payment will be made in USD.<br/>
        			All sales are final, purchases may be refunded for tokatif Credits only.</p>
                </div>                                                                                                            
             </div>
          </div>
        </div>
       </div>
     </div>
     <div class="col-lg-3 col-md-4 col-sm-12 col-12">
      <div class="my-lessons my-teacher-00 recommended-teacher">
        <div class="row">
            <div class="col-lg-4 col-md-3 col-sm-12 col-12">
                <div class="lesson-rightpic">
                    <img src="{{ asset('public/frontendassets/images/doller.png') }}" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-8 col-md-9 col-sm-12 col-12 pl-0">
               <h4>Tokatif Tokens</h4>
               <h5>$100.00 USD</h5>
            </div>  
        </div> 
        <div class="lesson-type-text">
         <div class="row">
          <div class="col-lg-6">
           <h5>Sub Total</h5>
          </div>
          <div class="col-lg-6 text-right"><h3 class="creditAmtDiv"></h3></div>
        </div>
        </div>
        <!--<div class="lesson-type-text">
         <div class="row">
          <div class="col-lg-6">
           <h5>Processing Fee</h5>
          </div>
          <div class="col-lg-6 text-right"><h3>USD 4.50</h3></div>
        </div>
        </div>-->
        <div class="lesson-type-text">
            <div class="row">
              <div class="col-lg-6">
               <h5>Total</h5>
              </div>
              <div class="col-lg-6 text-right"><h3 class="creditAmtDiv"></h3></div>
            </div>
        </div>
            
        <!--<div class="form-row">
            <div class="form-group col-lg-12 col-12 mt-3">
               <input type="text" class="form-control" id="" placeholder="Type Your Tokatif Password"> 
            </div>
        </div>-->
              
            
            <!--<button type="submit" class="btn btn-submit">Pay USD <span id="creditAmtSpan"></span></button>-->
        </div>
         
     </div>
   </div>
  </div>
</section>


@include('include/footer')
