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





<section class="article-list">

<style>
  .delete-artical{
    position: absolute;
    background: red;
    float: right;
    color: white;
    border-radius: 50%;
    padding: 9px;
    text-align: center;
    right: 4%;
  }
</style>

<div class="container-fluid">

  <div class="row">
  
    <div class="col-lg-3 col-md-3 col-sm-12 col-12 mt-5">
        @if(session('id')!='' && session('role')=='2')
            @include('include/teacher-left-sidebar')
        @endif
     </div>
     

     <div class="col-lg-6 col-md-6 col-sm-12 col-12">

       <div class="row">

        

        @if(count($communities)>0)   

            @foreach($communities as $val)

            <div class="col-lg-6 col-md-6 col-sm-6 col-12 mt-5">

               <div class="aricle-box">
                    <a href="{{ url('delete-community', $val->id) }}">
                      <div class="col-md-1 delete-artical">
                        <i class="fa fa-close"></i>
                      </div>
                    </a>
                    @php 

                        $exists = file_exists( storage_path() . '/app/article/' . $val->photo );

                    @endphp

                    

                    @if($exists && $val->photo!='') 

                        <img src="{{url('storage/app/article/'.$val->photo)}}" class="img-fluid">

                    @else

                        <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                    @endif

                    

                    

                    <a href="{{route('edit-community',['id'=>$val->id])}}"><h4>{{$val->title}}</h4></a>    

                    <p>{{$val->description}}</p>   

                    

                  <div class="my-lessons my-teacher-00 mt-3">

                    <div class="row align-items-center">

                        @php

                        $addedByData = DB::table('registrations')->where('id', '=', $val->added_by)->first(); 

                        $addedByName = $addedByData->name;

                          

                          if($addedByData->teacher_type!='' && $addedByData->teacher_type=='specialist_teacher')

                            $teacherType = 'Specialist Teacher';

                          elseif($addedByData->teacher_type!='' && $addedByData->teacher_type=='community_tutor')

                            $teacherType = 'Community Tutor';

                          else

                            $teacherType = '';

                          

                        @endphp

                        

                        <div class="col-lg-3 col-md-6 col-sm-12 col-12 pr-0">

                            @php 

                                $addedByPhotoExists = file_exists( storage_path() . '/app/user_photo/' . $addedByData->profile_photo );

                            @endphp

                         

                            @if($addedByPhotoExists && $addedByData->profile_photo!='') 

                              <img src="{{url('storage/app/user_photo/'.$addedByData->profile_photo)}}" class="img-fluid">

                            @else

                              <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                            @endif

                         <!--<img src="{{asset('public/frontendassets/images/upload-teacher.png')}}" class="img-fluid">-->

                         </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                           <h4>{{$addedByName}}</h4>

                           <h5>{{ $teacherType }}</h5>

                        </div> 

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">

                          <h3>{{date("F d, Y", strtotime($val->created_at))}}</h3>

                        </div> 

                     </div>

                     <hr/>

                     <div class="row">

                      <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">

                        @php

                          $taughtLanguageArr = json_decode($addedByData->languages_taught, true);  

                        @endphp

                        

                        

                        <ul class="community-list">

                            @if($addedByData->languages_taught!='' && count($taughtLanguageArr)>0)

                            @foreach($taughtLanguageArr as $key=>$value)

                                <li> 

                                    <a href="javascript:void(0);">   

                                    {{ $value['language'] }} <img src="{{ asset('public/frontendassets/images/meter1.png') }}" class="img-fluid"/> 

                                    </a>

                                </li>

                            @endforeach

                            @endif

                            

                            <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>

                            <li><a href="#"><i class="fa fa-commenting-o" aria-hidden="true"></i> 654</a></li> 

                        

                        </ul>

                        

                        

                    <!--<ul class="community-list">

                       <li><a href="#">Japanese <img src="{{asset('public/frontendassets/images/meter3.png')}}" class="img-fluid"></a></li>

                       <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>

                       <li><a href="#"><i class="fa fa-commenting-o" aria-hidden="true"></i> 654</a></li> 

                    </ul>-->

                    </div>

                    </div>

                    

             		</div>

               </div>

            </div>

            @endforeach

        @else

            <div class="col-md-12">

                <div class="aricle-box">

                    <h2 class="text-center">No article found!!</h2>

                </div>

            </div>

        @endif

        

      </div>

     </div>

     <div class="col-lg-3 col-md-3 col-sm-12 col-12">

        @if(session('role')=='2')

            <a href="{{route('add-community')}}" class="btn btn-submit">Create New Article</a>

        @endif

       <div class="aricle-box mb-5">
        <h2>Trending Articles</h2>

        

            @if(count($TrendingArticles)>0)   

                @foreach($TrendingArticles as $pValue)

                <div class="trending-box">

                    <h3>{{$pValue->title}}</h3>    

                    <div class="my-lessons my-teacher-00 mt-3">

                        <div class="row align-items-center">

                            @php

                            $addedBy_P_Data = DB::table('registrations')->where('id', '=', $pValue->added_by)->first(); 

                            $addedByPName = $addedBy_P_Data->name;

                              

                              if($addedBy_P_Data->teacher_type!='' && $addedBy_P_Data->teacher_type=='specialist_teacher')

                                $teacherTypeP = 'Specialist Teacher';

                              elseif($addedBy_P_Data->teacher_type!='' && $addedBy_P_Data->teacher_type=='community_tutor')

                                $teacherTypeP = 'Community Tutor';

                              else

                                $teacherTypeP = '';

                              

                            @endphp

                            <div class="col-lg-3 col-md-3 col-sm-12 col-12 pr-0">

                                @php 

                                    $addedBy_P_PhotoExists = file_exists( storage_path() . '/app/user_photo/' . $addedBy_P_Data->profile_photo );

                                @endphp

                             

                                @if($addedBy_P_PhotoExists && $addedBy_P_Data->profile_photo!='') 

                                  <img src="{{url('storage/app/user_photo/'.$addedBy_P_Data->profile_photo)}}" class="img-fluid">

                                @else

                                  <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                                @endif

                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">

                               <h4>{{$addedByPName}}</h4>

                               <h5>{{$teacherTypeP}}</h5>

                            </div> 

                            <div class="col-lg-3 col-md-3 col-sm-12 col-12 p-0">

                              <h3>{{date("F d, Y", strtotime($pValue->created_at))}}</h3>

                            </div> 

                        </div>

                 	</div>

                </div>

                @endforeach

            @endif

            

            

           <!--<div class="trending-box">

                  <h3>Bachelor of Arts in Counseling Skills</h3>    

                  <div class="my-lessons my-teacher-00 mt-3">

                    <div class="row align-items-center">

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 pr-0">

                         <img src="{{asset('public/frontendassets/images/upload-teacher.png')}}" class="img-fluid">

                         </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">

                           <h4>Mr. Zhang </h4>

                           <h5>Community Tutor</h5>

                        </div> 

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 p-0">

                          <h3>Sep 1, 2020</h3>

                        </div> 

                     </div>

                    

             		</div>

               </div>

           <div class="trending-box">

                  <h3>Bachelor of Arts in Counseling Skills</h3>    

                  <div class="my-lessons my-teacher-00 mt-3">

                    <div class="row align-items-center">

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 pr-0">

                         <img src="{{asset('public/frontendassets/images/upload-teacher.png')}}" class="img-fluid">

                         </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">

                           <h4>Mr. Zhang </h4>

                           <h5>Community Tutor</h5>

                        </div> 

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 p-0">

                          <h3>Sep 1, 2020</h3>

                        </div> 

                     </div>

                    

             		</div>

               </div>

           <div class="trending-box">

                  <h3>Bachelor of Arts in Counseling Skills</h3>    

                  <div class="my-lessons my-teacher-00 mt-3">

                    <div class="row align-items-center">

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 pr-0">

                         <img src="{{asset('public/frontendassets/images/upload-teacher.png')}}" class="img-fluid">

                         </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">

                           <h4>Mr. Zhang </h4>

                           <h5>Community Tutor</h5>

                        </div> 

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 p-0">

                          <h3>Sep 1, 2020</h3>

                        </div> 

                     </div>

                    

             		</div>

               </div>  -->      

       </div>

       

      <figure><img src="{{asset('public/frontendassets/images/ad-post.png')}}" class="img-fluid"/></figure> 

     </div>

   </div>

  </div>

</section>





@include('include/footer')





