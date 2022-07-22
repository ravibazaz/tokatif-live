@include('include/head')



@if(session('id')!='' && session('role')=='1')

    @include('include/student-dashboard-header')

@elseif(session('id')!='' && session('role')=='2')

    @include('include/teacher-dashboard-header')

@else

    @include('include/header')

@endif



@php

 $getLoggedIndata = getLoggedinData();

 $getVisitorCountry = getVisitorCountry();

@endphp







<section class="article-list article-add-page">

<div class="container">

  <div class="row">

  <div class="col-lg-3 col-md-3 col-sm-12 col-12">
      @include('include/teacher-left-sidebar')
     </div>

     <div class="col-lg-6 col-md-6 col-sm-12 col-12">

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

          

      

        <form role="form" action="{{ url('community/update', $community->id) }}" method="POST" enctype="multipart/form-data" > 

        {{ csrf_field() }}

        <input type="hidden" class="form-control" name="role" value="{{$getLoggedIndata->role}}" />

        <div class="form-row">

            <div class="form-group col-lg-12">

                <label for="inputEmail4">Post Type *</label>

                <select class="custom-select mr-sm-2" name="post_type" id="post_type">

                    <option value="">Please Choose</option>

                    <option value="article" {{ ($community->post_type == 'article') ? 'selected' : '' }}>Article</option>

                    <option value="forum" {{ ($community->post_type == 'forum') ? 'selected' : '' }}>Forum</option>

                </select>

                @if ($errors->has('post_type'))

                    <span class="text-danger">{{ $errors->first('post_type') }}</span> 

                @endif

            </div>            

        </div>

        

        <div class="form-row" id="ForumTopicDiv">

            <div class="form-group col-lg-12">

                <label for="inputEmail4">Forum Topic</label>

                <select class="custom-select mr-sm-2" name="forum_topic" id="forum_topic">

                    <!--<option value="">Please Choose</option>-->

                    <option value="lets_discuss" {{ ($community->forum_topic == 'lets_discuss') ? 'selected' : '' }}>Let’s Discuss</option>

                    <option value="ask_a_question" {{ ($community->forum_topic == 'ask_a_question') ? 'selected' : '' }}>Ask A Question</option>

                    <option value="check_my_work" {{ ($community->forum_topic == 'check_my_work') ? 'selected' : '' }}>Check My Work</option>

                    <option value="share_resources" {{ ($community->forum_topic == 'share_resources') ? 'selected' : '' }}>Share Resources</option>

                    <option value="find_a_language_exchange_partner" {{ ($community->forum_topic == 'find_a_language_exchange_partner') ? 'selected' : '' }}>Find A Language Exchange Partner</option>

                </select>

                @if ($errors->has('forum_topic'))

                    <span class="text-danger">{{ $errors->first('forum_topic') }}</span>

                @endif

            </div>            

        </div>



        <div class="form-row mt-3">

            <div class="form-group col-lg-12">

                <label for="inputEmail4">Title *</label>

                <input type="text" class="form-control" name="title" id="title" value="{{Request::old('title', $community->title)}}" placeholder="Enter Title of Article">

                @if ($errors->has('title'))

                    <span class="text-danger">{{ $errors->first('title') }}</span>

                @endif

            </div>

        </div>

        

        <div class="form-row mt-3">

            <div class="form-group col-lg-12">

                <label for="inputEmail4">Description *</label>

                <textarea name="description" id="editor1" class="form-control" rows="5" cols="80">{{Request::old('description', $community->description)}}</textarea> 

                @if ($errors->has('description'))

                    <span class="text-danger">{{ $errors->first('description') }}</span> 

                @endif

            </div>

        </div>

        <div class="form-row mt-3">

            <div class="col-md-12">

                <div class="impression-left">

                    <p>Click or Drag here to upload Photo *</p>

                    <input type="file" class="form-control-file" name="photo" id="community_photo" accept="image/*">

                    <span id="community_photo_frame"></span>

                    @if ($errors->has('photo'))

                        <span class="text-danger">{{ $errors->first('photo') }}</span>

                    @endif

                </div> 

            </div>

        </div>

        <div class="form-row col-md-5 mt-3">
            <img class="col-md-12" src="{{ url('storage/app/article', $community->photo) }}">
        </div>

        <div class="form-row mt-3">

            <div class="form-group col-lg-12">

                <button type="submit" class="btn btn-submit">Save</button> 

                <button type="submit" onClick="history.go(0);" class="cancel-btn">Cancel</button>

            </div>

        </div>                                             

        </form>

    </div>

    <div class="col-lg-3 col-md-3 col-sm-12 col-12">

        <div class="some-god">

         <h3>Some Good Examples for Title</h3>

         <p>How to let this IELTS sentence be correct?</p>

         <p>Can someone explain the role of '하면' in this sentence?</p>

         <p>In English, what's the right way of saying "the middle-left/right</p>

         <p>Is well turned out= neatly turned out?</p>

        </div>

    </div>

   </div>

  </div>

</section>





@include('include/footer')



