@include('include/head')
@include('include/student-dashboard-header')

@php 
    $getLoggedIndata = getLoggedinData();
    $getVisitorCountry = getVisitorCountry();
@endphp


<section class="messages-section">
 <div class="container">
	<div class="row">
	  <div class="col-md-4">
       <div class="gift-card-left">
           <h3>Tokatif Gift Cards</h3>
           <h5>Give the gift of language</h5>
           <a href="#">Buy Now</a>
           <h4>Redeem a Gift Card</h4>
           <p>To redeem your Gift Card, simply copy and paste the code into the box below and submit.</p>
           <form>
             <div class="form-group gift-code clearfix">
                  <input type="email" name="email" value="" placeholder="Please enter your code" required>
                  <button type="submit" class="gift-btn"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
                </div>
           </form>
       </div>
      </div>
	  <div class="col-md-8">
        <div class="my-wallet">
           <div class="row"> 
           <div class="col-lg-6 col-12"><h3>Student Wallet</h3></div>
           <div class="col-lg-6 col-12 text-right"><a href="{{route('add-credit')}}" class="bye-credite">Buy Credits</a></div>
          </div>
           <div class="row">
           <div class="col-lg-4 col-12">
             <div class="avaliable-box">
               <h4>${{number_format($getLoggedIndata->student_wallet_amount,2)}} USD</h4>
                <p>Available Balance <i class="fa fa-question-circle" aria-hidden="true"></i></p>
             </div>
           </div>
           <!--<div class="col-lg-4 col-12">
             <div class="avaliable-box total-blans">
               <h4>${{number_format($getLoggedIndata->student_wallet_amount,2)}} USD</h4>
                <p>Total Balance <i class="fa fa-question-circle" aria-hidden="true"></i></p>
             </div>
           </div>
           <div class="col-lg-4 col-12">
            <div class="avaliable-box unavailable-box">
               <h4>$10.50 USD</h4>
                <p>Unavailable Pending <i class="fa fa-question-circle" aria-hidden="true"></i></p>
             </div>
           </div>-->
         </div>
          <p class="pt-4">The amounts listed here are close approaximations. 
             There may be a slight difference due to changes in foreign exachange rate. All amounts are based on US Dollars.</p>
        </div>
        
        <div class="wallet-table">
          <h3>Transaction History</h3>
          
         <table id="myTable" class="table table-striped table-bordered" style="width:100%">
          <thead>
              <tr>
                <th>Date</th>
                <th>Transcation ID</th>
                <th>Description</th>
                <th>Amount (USD)</th>
                <th>Type</th>
              </tr>
          </thead>
          <tbody>
          @foreach($walletLog as $val)
            @php
            if($val->credit_debit=='credit'){
                $sign = '+';
            }else if($val->credit_debit=='debit'){
                $sign = '-';
            }else{
                $sign = '';
            }
            @endphp
        
          <tr>
            <td>{{ date('d M Y, h:i a', strtotime($val->created_at)) }}</td>
            <td>{{$val->transaction_id}}</td>
            <td>{{$val->purpose}}</td>
            <td>{{$sign}} {{$val->wallet_amount}} USD</td>
            <td class="succes-td">{{$val->credit_debit}}</td>
          </tr>
          @endforeach
          
          </tbody>
        </table>

        </div>
      </div>
	</div>
  </div>
</section>

@include('include/footer')


