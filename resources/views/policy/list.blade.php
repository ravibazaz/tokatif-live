@include('include/head')

@if(session('id')!='' && session('role')=='1')
    @include('include/student-dashboard-header')
@elseif(session('id')!='' && session('role')=='2')
    @include('include/teacher-dashboard-header')
@else
    @include('include/header')
@endif


@php 
$getVisitorCountry = getVisitorCountry();
@endphp




<section id="terms-page" class="bg-snow wide-70 inner-page-hero terms-section division">
	<div class="container">


		<!-- TERMS CONTENT -->
		<div class="row justify-content-center">	
			<div class="col-lg-10">


				<!-- TERMS TITLE -->
				<div class="terms-title text-center">

					<!-- Title -->
					<h2 class="h2-md">Our Privacy Policy </h2>


				</div>


				<!-- DIVIDER LINE -->
				<hr class="divider">

				

				<!-- TERMS BOX -->
				@foreach($privacy as $val)
				<div class="terms-box">

					<!-- Title -->
					<h5 class="h5-xl">{{$val->title}}</h5>
					
					<!-- Text -->  
					<p class="p-lg">{{$val->description}}</p>

				</div>	<!-- END TERMS BOX -->
				@endforeach



			</div>	<!-- END TERMS CONTENT -->


		</div>     <!-- End row -->		
	</div>	    <!-- End container -->
</section>


@include('include/footer')








