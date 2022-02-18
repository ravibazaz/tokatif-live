@include('include/head')

@include('include/teacher-dashboard-header')



@php

 $getLoggedIndata = getLoggedinData();

@endphp





<section class="add-lesson-section">

 <div class="container">

	<div class="row">
    
     <div class="col-lg-3 col-md-3 col-sm-12 col-12">
      @include('include/teacher-left-sidebar')
     </div>

       <div class="col-lg-9 col-md-9 col-sm-9 col-12">

           

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

          

          @if ($errors->any())

          <div class="alert alert-danger">

              <ul>

                  @foreach ($errors->all() as $message)

                      <li>{{ $message }}</li>

                  @endforeach

              </ul>

          </div>

          @endif

          

         <div class="add-lesson">

           <h2>Create a new Lesson</h2>

            <form role="form" action="{{ route('post-lesson-data') }}" method="POST" enctype="multipart/form-data" > 

            {{ csrf_field() }}

                <input type="hidden" class="form-control" name="id" value="{{$getLoggedIndata->id}}" />

                <input type="hidden" class="form-control" name="role" value="{{$getLoggedIndata->role}}" />

                

            

            

            <div class="form-row mt-3"> 

              <div class="form-group col-md-12">

                <label for="">Type *</label>

                <select class="custom-select mr-sm-2" name="lesson_type" id="lesson_type">

                    <option value="">Please Select</option>

                    <option value="trial" {{ (Request::old('lesson_type') == 'trial') ? 'selected' : '' }}>Trial</option>

                    <option value="non_trial" {{ (Request::old('lesson_type') == 'non_trial') ? 'selected' : '' }}>Non Trial</option>

                </select>

                @if ($errors->has('lesson_type'))

                    <span class="text-danger">{{ $errors->first('lesson_type') }}</span>

                @endif

              </div>

            </div>



            <div class="form-row mt-3"> 

              <div class="form-group col-md-12">

                <label for="">Title *</label>

                <input type="text" class="form-control" name="lesson_name" value="{{Request::old('lesson_name')}}" placeholder="Title">

                @if ($errors->has('lesson_name'))

                    <span class="text-danger">{{ $errors->first('lesson_name') }}</span>

                @endif

              </div>

            </div>

                      

            <div class="form-row mt-3">            

                <div class="form-group col-md-12">

                    <label for="exampleFormControlTextarea1">Description</label>

                    <textarea class="form-control" name="lesson_description" rows="3">{{Request::old('lesson_description')}}</textarea> 

                </div>

            </div>

            

            @php

              $taughtLanguageArr = json_decode($getLoggedIndata->languages_taught, true);  //dd($taughtLanguageArr); 

            @endphp

            <div class="form-row mb-2">

                <div class="form-group col-md-4">

                  <label for="">Language Taught *</label>

                  <select class="custom-select mr-sm-2" name="language_taught">

                    <option value="">Please Select</option>

                    @foreach($taughtLanguageArr as $key=>$value)

                    <option value="{{ $value['language'] }}" {{ (Request::old('language_taught') == $value['language']) ? 'selected' : '' }}>{{ $value['language'] }}</option>

                    @endforeach

                  </select>

                  

                  @if ($errors->has('language_taught'))

                    <span class="text-danger">{{ $errors->first('language_taught') }}</span>

                  @endif

                </div>

                <div class="form-group col-md-4">

                  <label for="">Student Language Level</label>

                  <select class="custom-select mr-sm-2" name="student_languages_level_from" id="student_languages_level_from">

                    <option value="">Please Select</option>

                    <option value="A1" {{ (Request::old('student_languages_level_from') == 'A1') ? 'selected' : '' }}>A1</option>

                    <option value="A2" {{ (Request::old('student_languages_level_from') == 'A2') ? 'selected' : '' }}>A2</option>

                    <option value="B1" {{ (Request::old('student_languages_level_from') == 'B1') ? 'selected' : '' }}>B1</option>

                    <option value="B2" {{ (Request::old('student_languages_level_from') == 'B2') ? 'selected' : '' }}>B2</option

                    ><option value="C1" {{ (Request::old('student_languages_level_from') == 'C1') ? 'selected' : '' }}>C1</option>

                    <option value="C2" {{ (Request::old('student_languages_level_from') == 'C2') ? 'selected' : '' }}>C2</option>

                  </select>

                </div>

                <div class="form-group col-md-4">

                  <label for="">&nbsp;</label>

                  <select class="custom-select mr-sm-2" name="student_languages_level_to" id="student_languages_level_to"> 

                    <option value="">Please Select</option>

                    <option value="A1" {{ (Request::old('student_languages_level_to') == 'A1') ? 'selected' : '' }}>A1</option>

                    <option value="A2" {{ (Request::old('student_languages_level_to') == 'A2') ? 'selected' : '' }}>A2</option>

                    <option value="B1" {{ (Request::old('student_languages_level_to') == 'B1') ? 'selected' : '' }}>B1</option>

                    <option value="B2" {{ (Request::old('student_languages_level_to') == 'B2') ? 'selected' : '' }}>B2</option

                    ><option value="C1" {{ (Request::old('student_languages_level_to') == 'C1') ? 'selected' : '' }}>C1</option>

                    <option value="C2" {{ (Request::old('student_languages_level_to') == 'C2') ? 'selected' : '' }}>C2</option>

                  </select>

                </div>

            </div>   

              

           

           

           <div class="form-row mb-2">

                <div class="form-group col-md-6">

                  <label for=""> Lesson Type *</label>

                  <select class="custom-select mr-sm-2" name="lesson_category" id="lesson_category">

                    <option value="">Please Select</option>

                    @foreach($lessonCategory as $key=>$value)

                    <option value="{{ $value->name }}" {{ (Request::old('lesson_category') == $value->name) ? 'selected' : '' }}>{{ $value->name }}</option>

                    @endforeach

                  </select>

                  

                  @if ($errors->has('lesson_category'))

                    <span class="text-danger">{{ $errors->first('lesson_category') }}</span>

                  @endif

                </div>

                

                <div class="form-group col-md-6">

                  <label for=""> Focus Areas </label>

                  <select class="custom-select mr-sm-2" name="lesson_tag[]" id="lesson_tag" multiple >

                    <option value="">Please Select</option>

                  </select>

                </div>

            </div>   

           

            <div class="form-row mb-2 align-items-center">

                <div class="form-group col-md-12 text-left">Price <span class="priceHint">Min. $10 USD/lesson, Max. $80 USD/lesson</span></div>

            </div>

           

            <div class="form-row mb-2 align-items-center">

               <div class="form-group col-md-6 text-center">Individual Lessons</div>

               <div class="form-group col-md-3 text-center">Packages</div>

               <div class="form-group col-md-3 text-center">Total</div>

            </div>

           

            <div class="form-row mb-2 align-items-center individual-lessons">

                <div class="form-group col-md-1"> 

                    <div class="form-check">

                        <label for="">&nbsp;</label>

                        <input type="checkbox" class="" id="">

                    </div>

                </div>

                

                <div class="form-group col-md-3">

                   <span class="individual-doller-sign">$</span>

                  <input type="text" class="form-control individual-price" name="individual_lesson[]" id="individual_lesson_30" aria-describedby="emailHelp" placeholder=""> 

                   <span class="individual-usd">USD</span>

                </div>

                        

                <div class="form-group col-md-2"> 

                    <label for="">&nbsp;</label> 

                    <p>/ 30 min </p> <input type="hidden" value="30 mins" name="time[]">

                </div>

                        

                <div class="form-group col-md-3">                     

                    <select class="custom-select mr-sm-2" name="package[]" id="package_lesson_30">  

                        <option value="">N/A</option>

                        <option value="5 lessons">5 lessons</option>

                        <option value="10 lessons">10 lessons</option>

                        <option value="20 lessons">20 lessons</option>

                    </select>

                </div>

                        

                <div class="form-group col-md-3"> 

                    <span class="individual-doller-sign">$</span>

                    <input type="text" class="form-control individual-price" name="total[]" id="package_total_30">

                    <span class="individual-usd">USD</span>

                </div>

                        

            </div>    

            

            

            

            <div class="form-row mb-2 align-items-center individual-lessons">

                <div class="form-group col-md-1"> 

                    <div class="form-check">

                        <label for="">&nbsp;</label>

                        <input type="checkbox" class="" id="">

                    </div>

                </div>

                <div class="form-group col-md-3">

                    <span class="individual-doller-sign">$</span>

                    <input type="text" class="form-control individual-price" name="individual_lesson[]" id="individual_lesson_45" aria-describedby="emailHelp" placeholder=""> 

                    <span class="individual-usd">USD</span>

                </div>

                        

                <div class="form-group col-md-2"> 

                    <label for="">&nbsp;</label> 

                    <p>/ 45 min </p> <input type="hidden" value="45 mins" name="time[]">

                </div>

                        

                <div class="form-group col-md-3">                     

                  <select class="custom-select mr-sm-2" name="package[]" id="package_lesson_45">

                    <option value="">N/A</option>

                    <option value="5 lessons">5 lessons</option>

                    <option value="10 lessons">10 lessons</option>

                    <option value="20 lessons">20 lessons</option>

                  </select>

                </div>

                        

                <div class="form-group col-md-3"> 

                    <span class="individual-doller-sign">$</span>

                    <input type="text" class="form-control individual-price" name="total[]" id="package_total_45">

                    <span class="individual-usd">USD</span>

                </div>

                        

            </div>

            

            

            <div class="form-row mb-2 align-items-center individual-lessons">

                <div class="form-group col-md-1"> 

                    <div class="form-check">

                        <label for="">&nbsp;</label>

                        <input type="checkbox" class="" id="">

                    </div>

                </div>

                

                <div class="form-group col-md-3">

                    <span class="individual-doller-sign">$</span>

                    <input type="text" class="form-control individual-price" name="individual_lesson[]" id="individual_lesson_60" aria-describedby="emailHelp" placeholder=""> 

                    <span class="individual-usd">USD</span>

                </div>

                        

                <div class="form-group col-md-2"> 

                    <label for="">&nbsp;</label> 

                    <p>/ 60 min </p>  <input type="hidden" value="60 mins" name="time[]">

                </div>

                        

                <div class="form-group col-md-3">                     

                    <select class="custom-select mr-sm-2" name="package[]" id="package_lesson_60">

                        <option value="">N/A</option>

                        <option value="5 lessons">5 lessons</option>

                        <option value="10 lessons">10 lessons</option>

                        <option value="20 lessons">20 lessons</option>

                    </select>

                </div>

                        

                <div class="form-group col-md-3"> 

                    <span class="individual-doller-sign">$</span>

                    <input type="text" class="form-control individual-price" name="total[]" id="package_total_60">

                    <span class="individual-usd">USD</span>

                </div>     

            </div>

            

            

            

            <div class="form-row mb-2 align-items-center individual-lessons">

                <div class="form-group col-md-1"> 

                    <div class="form-check">

                        <label for="">&nbsp;</label>

                        <input type="checkbox" class="" id="">

                    </div>

                </div>

                

                <div class="form-group col-md-3">

                    <span class="individual-doller-sign">$</span>

                    <input type="text" class="form-control individual-price" name="individual_lesson[]" id="individual_lesson_75" aria-describedby="emailHelp" placeholder=""> 

                    <span class="individual-usd">USD</span>

                </div>

                        

                <div class="form-group col-md-2"> 

                    <label for="">&nbsp;</label> 

                    <p>/ 75 min </p>  <input type="hidden" value="75 mins" name="time[]">

                </div>

                        

                <div class="form-group col-md-3">                     

                    <select class="custom-select mr-sm-2" name="package[]" id="package_lesson_75">

                        <option value="">N/A</option>

                        <option value="5 lessons">5 lessons</option>

                        <option value="10 lessons">10 lessons</option>

                        <option value="20 lessons">20 lessons</option>

                    </select>

                </div>

                        

                <div class="form-group col-md-3"> 

                    <span class="individual-doller-sign">$</span>

                    <input type="text" class="form-control individual-price" name="total[]" id="package_total_75">

                    <span class="individual-usd">USD</span>

                </div>       

            </div> 

            

            

            

            <div class="form-row mb-2 align-items-center individual-lessons">

                <div class="form-group col-md-1"> 

                    <div class="form-check">

                        <label for="">&nbsp;</label>

                        <input type="checkbox" class="" id="">

                    </div>

                </div>

                

                <div class="form-group col-md-3">

                    <span class="individual-doller-sign">$</span>

                    <input type="text" class="form-control individual-price" name="individual_lesson[]" id="individual_lesson_90" aria-describedby="emailHelp" placeholder=""> 

                    <span class="individual-usd">USD</span>

                </div>

                        

                <div class="form-group col-md-2"> 

                    <label for="">&nbsp;</label> 

                    <p>/ 90 min </p>  <input type="hidden" value="90 mins" name="time[]">

                </div>

                        

                <div class="form-group col-md-3">                     

                    <select class="custom-select mr-sm-2" name="package[]" id="package_lesson_90">

                        <option value="">N/A</option>

                        <option value="5 lessons">5 lessons</option>

                        <option value="10 lessons">10 lessons</option>

                        <option value="20 lessons">20 lessons</option>

                    </select>

                </div>

                        

                <div class="form-group col-md-3"> 

                    <span class="individual-doller-sign">$</span>

                    <input type="text" class="form-control individual-price" name="total[]" id="package_total_90">

                    <span class="individual-usd">USD</span>

                </div>       

            </div> 

            

            

            <div class="form-row mt-4">

                <div class="form-group col-md-12 example">

                    <label for="">Status</label><br/>

                    <!--<button type="button" class="btn btn-toggle mb-4" data-toggle="button" aria-pressed="false" autocomplete="off">-->

                    <button type="button" class="btn btn-toggle mb-4 active" data-toggle="button" aria-pressed="true" autocomplete="off">

                        <div class="handle"></div> 

                    </button>

                </div>

            </div> 

                      

            <div class="form-row mt-4">

                <div class="form-group col-md-12 example">        

                    <button type="submit" class="btn btn-submit">Submit</button> 

                </div>

            </div>                                                

           </form>

         </div>

        </div>

	</div>

  </div>

</section>



@include('include/footer')



