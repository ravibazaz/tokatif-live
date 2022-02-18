<link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/13.1.5/nouislider.css" rel="stylesheet">


<section class="filter-teacher">
<div id="navbar_top">
 <div class="accordion filter-bar" id="accordionExample" style="margin-top:0px;">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="collapsed tag-filter" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          From
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <div class="filter-container" style="width:300px;">
     <div class="filter-body">
       <div>
      <div class="filter-dropdown-checkboxes">
        <!--<div class="filter-dropdown-search  items-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="#D9D9D9" xmlns="http://www.w3.org/2000/svg" class="pl-1">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M6.75 12C6.75 9.10051 9.10051 6.75 12 6.75C14.8995 6.75 17.25 9.10051 17.25 12C17.25 13.347 16.7427 14.5755 15.9088 15.5049C15.8209 15.5415 15.7385 15.5956 15.667 15.6671C15.5956 15.7386 15.5415 15.8209 15.5049 15.9088C14.5755 16.7427 13.347 17.25 12 17.25C9.10051 17.25 6.75 14.8995 6.75 12ZM16.2133 17.2739C15.0585 18.1976 13.5938 18.75 12 18.75C8.27208 18.75 5.25 15.7279 5.25 12C5.25 8.27208 8.27208 5.25 12 5.25C15.7279 5.25 18.75 8.27208 18.75 12C18.75 13.5938 18.1976 15.0585 17.2739 16.2133L18.5304 17.4697C18.8233 17.7626 18.8233 18.2375 18.5304 18.5304C18.2375 18.8233 17.7626 18.8233 17.4697 18.5304L16.2133 17.2739Z"></path>
          </svg>
          <input type="text" placeholder="Search by country or region">
        </div>-->
        <div class="filter-dropdow-items">
          <p class="filter-dropdown-head"><span>Popular countries/regions</span></p>
          
          @foreach ($countries as $val)
          <label class="filter-checkbox ant-checkbox-wrapper"><span class="ant-checkbox">
            <input type="checkbox" class="ant-checkbox-input searchCountryNameClass" data-cy="ts_from_AF" name="searchCountryName" value="{{$val->name}}">
            <span class="ant-checkbox-inner"></span></span><span><span>{{$val->name}}</span></span></label>
          @endforeach 

        </div>
      </div>
      <div class="filter-footer">
        <button type="button" data-filter="country" class="teacherSearchApplyBtn ant-btn filter-apply-btn ant-btn-primary ant-btn-sm"><span data-cy="ts_apply">Apply</span></button>
      </div>
    </div>
  </div>
   </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="collapsed tag-filter" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Also speaks
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        <div class="filter-container filter-container-speaks">
      <div class="filter-body">
    <div>
      <div class="filter-from">
          
        @foreach ($languages as $val)
        <label class="filter-checkbox ant-checkbox-wrapper"><span class="ant-checkbox">
          <input type="checkbox" class="ant-checkbox-input searchLanguageNameClass" data-cy="ts_alsospeak_english" name="searchLanguageName" value="{{$val->name}}">
          <span class="ant-checkbox-inner"></span></span><span><span>{{$val->name}}</span></span></label>
        @endforeach 
          

        <!--<p class="flex filter-from-all-languages justify-center items-center"><span data-cy="ts_showmore">Show More</span><svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" fill="#8C8C8C">
          <path clip-rule="evenodd" d="M7.97 9.97a.75.75 0 011.06 0L12 12.94l2.97-2.97a.75.75 0 111.06 1.06l-3.5 3.5a.75.75 0 01-1.06 0l-3.5-3.5a.75.75 0 010-1.06z" fill-rule="evenodd"></path>
          </svg></p>-->
      </div>
      <div class="filter-footer">
        <button type="button" data-filter="language" class="teacherSearchApplyBtn ant-btn filter-apply-btn ant-btn-primary ant-btn-sm"><span data-cy="ts_apply">Apply</span></button>
      </div>
    </div>
  </div>
    </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="collapsed tag-filter" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Price
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
        <div class="filter-container filter-container-speaks">
        <div class="range-box">
        	<div class="d-flex pt-3">
        		<span>Price </span> 
        		<span class="example-val" id="slider-range-value"></span>
        	</div>
	        <div id="slider-range"></div>
    
            <div class="filter-footer">
                <button type="button" data-filter="price" class="teacherSearchApplyBtn ant-btn filter-apply-btn ant-btn-primary ant-btn-sm"><span data-cy="ts_apply">Apply</span></button>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingFour">
      <h2 class="mb-0">
        <button class="collapsed tag-filter" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
          Availability
        </button>
      </h2>
    </div>
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
      <div class="card-body">
        <div class="filter-container filter-container-speaks">
           <div class="bd-example bd-example-tabs">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <a class="nav-item nav-link active show" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">General time</a>
                  <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Specific time</a>
                </div>
            </nav>
            
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="filter-availability-tab-body">
                	  <div class="filter-availability-tab-item">
                        <div class="availability-day-range-head"><span>Days of the week</span></div>
                        <div class="availability-day-range">
                          <div class="availability-day-choice" data-DayName="Friday" data-cy="ts_ab_day1">Fri</div>
                          <div class="availability-day-choice" data-DayName="Saturday" data-cy="ts_ab_day2">Sat</div>
                          <div class="availability-day-choice" data-DayName="Sunday" data-cy="ts_ab_day3">Sun</div>
                          <div class="availability-day-choice" data-DayName="Monday" data-cy="ts_ab_day4">Mon</div>
                          <div class="availability-day-choice" data-DayName="Tuesday" data-cy="ts_ab_day5">Tue</div>
                          <div class="availability-day-choice" data-DayName="Wednesday" data-cy="ts_ab_day6">Wed</div>
                          <div class="availability-day-choice" data-DayName="Thursday" data-cy="ts_ab_day7">Thu</div>
                        </div>
                        <div class="availability-time-range-head"><span>Time range</span></div>
                        <div class="availability-time-range">
                          <div class="availability-time-choice" data-cy="ts_ab_time0004">00 - 04</div>
                          <div class="availability-time-choice" data-cy="ts_ab_time0408">04 - 08</div>
                          <div class="availability-time-choice" data-cy="ts_ab_time0812">08 - 12</div>
                          <div class="availability-time-choice" data-cy="ts_ab_time1216">12 - 16</div>
                          <div class="availability-time-choice" data-cy="ts_ab_time1620">16 - 20</div>
                          <div class="availability-time-choice" data-cy="ts_ab_time2024">20 - 24</div>
                        </div>
                        <p class="availability-timezone"><span class="user-based-timezone"><span>Based on your timezone</span> (UTC+08:00)</span></p>
                    </div>
                    </div>
                    <div class="filter-footer">
                        <button type="button" data-filter="availability" class="teacherSearchApplyBtn ant-btn filter-apply-btn ant-btn-primary ant-btn-sm"><span data-cy="ts_apply">Apply</span></button>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
          <div class="filter-availability-tab-body">
      <div class="filter-availability-tab-item">
        <div class="filter-availability-date">
          <div class="filter-availability-date-arrow items-center" data-cy="ts_ab_specifictime_leftbtn"><svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" fill="#333">
            <path clip-rule="evenodd" d="M16.494 3.436a.75.75 0 01.07 1.058L9.997 12l6.567 7.506a.75.75 0 11-1.128.988l-7-8a.75.75 0 010-.988l7-8a.75.75 0 011.058-.07z" fill-rule="evenodd"></path>
            </svg></div>
          <div class="filter-availability-date-range">Jun 18, 2021&nbsp;-&nbsp;Jun 24, 2021</div>
          <div class="filter-availability-date-arrow items-center" data-cy="ts_ab_specifictime_rightbtn"><svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" fill="#333">
            <path clip-rule="evenodd" d="M7.506 3.436a.75.75 0 00-.07 1.058L14.003 12l-6.567 7.506a.75.75 0 001.128.988l7-8a.75.75 0 000-.988l-7-8a.75.75 0 00-1.058-.07z" fill-rule="evenodd"></path>
            </svg></div>
        </div>
        <div class="fitler-availability-days">
          <div class="fitler-availability-day-section" data-cy="ts_ab_specifictime_day1">
            <p class="fitler-availability-weekday">Fri</p>
            <p class="fitler-availability-day">18</p>
          </div>
          <div class="fitler-availability-day-section" data-cy="ts_ab_specifictime_day2">
            <p class="fitler-availability-weekday">Sat</p>
            <p class="fitler-availability-day">19</p>
          </div>
          <div class="fitler-availability-day-section" data-cy="ts_ab_specifictime_day3">
            <p class="fitler-availability-weekday">Sun</p>
            <p class="fitler-availability-day">20</p>
          </div>
          <div class="fitler-availability-day-section" data-cy="ts_ab_specifictime_day4">
            <p class="fitler-availability-weekday">Mon</p>
            <p class="fitler-availability-day">21</p>
          </div>
          <div class="fitler-availability-day-section" data-cy="ts_ab_specifictime_day5">
            <p class="fitler-availability-weekday">Tue</p>
            <p class="fitler-availability-day">22</p>
          </div>
          <div class="fitler-availability-day-section" data-cy="ts_ab_specifictime_day6">
            <p class="fitler-availability-weekday">Wed</p>
            <p class="fitler-availability-day">23</p>
          </div>
          <div class="fitler-availability-day-section" data-cy="ts_ab_specifictime_day7">
            <p class="fitler-availability-weekday">Thu</p>
            <p class="fitler-availability-day">24</p>
          </div>
        </div>
        <div class="fitler-availability-container">
          <div class="fitler-availability-times-head">
          <span><img src="http://api.crescentek.in/tokatif/public/frontendassets/images/icon_sun.6c8f206b.svg" alt="right" width="16">
          <span>Morning</span></span></div>
          <div class="fitler-availability-times">
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time1">00:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time2">01:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time3">02:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time4">03:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time5">04:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time6">05:00</p>
            </div>
          </div>
          <div class="fitler-availability-times">
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time7">06:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time8">07:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time9">08:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time10">09:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time11">10:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time12">11:00</p>
            </div>
          </div>
        </div>
        <div class="fitler-availability-container">
          <div class="fitler-availability-times-head">
          <span><img src="http://api.crescentek.in/tokatif/public/frontendassets/images/icon_moon.1a260e44.svg" alt="right" width="16">
          <span>Afternoon/Evening</span></span>
          </div>
          <div class="fitler-availability-times">
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time13">12:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time14">13:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time15">14:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time16">15:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time17">16:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time18">17:00</p>
            </div>
          </div>
          <div class="fitler-availability-times">
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time19">18:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time20">19:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time21">20:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time22">21:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time23">22:00</p>
            </div>
            <div class="fitler-availability-time-section">
              <p class="fitler-availability-time" data-cy="ts_ab_specifictime_time24">23:00</p>
            </div>
          </div>
        </div>
        <p class="availability-timezone"><span class="user-based-timezone"><span>Based on your timezone</span> (UTC+08:00)</span></p>
      </div>
    </div>
          <div class="filter-footer">
           <button type="button" data-filter="" class="teacherSearchApplyBtn ant-btn filter-apply-btn ant-btn-primary ant-btn-sm"><span data-cy="ts_apply">Apply</span></button>
          </div>
        </div>
        
            </div>
        </div>
    </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingFive">
      <h2 class="mb-0">
        <button class="collapsed tag-filter" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseThree">
          Teacher types
        </button>
      </h2>
    </div>
    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
      <div class="card-body">
        <div class="filter-container filter-container-speaks" style="width: 280px;">
          <div class="filter-body">
            <div class="ant-radio-group ant-radio-group-outline filter-radio-group">
              <div class="filter-radio">
                <label class="ant-radio-wrapper"><span class="ant-radio">
                  <input name="teacher_type_search" id="teacher-type-pro" type="radio" class="ant-radio-input" value="specialist_teacher"> 
                  <span class="ant-radio-inner"></span></span><span><span data-cy="ts_teachertypes_pro">Specialist Teachers</span></span></label>
                <p class="filter-radio-tips"><span>Certified professionals that are highly-skilled in the art of foreign language acquisition.</span></p>
              </div>
              <div class="filter-radio">
                <label class="ant-radio-wrapper"><span class="ant-radio">
                  <input name="teacher_type_search" id="teacher-type-com" type="radio" class="ant-radio-input" value="community_tutor"> 
                  <span class="ant-radio-inner"></span></span><span><span data-cy="ts_teachertypes_general">Community Tutors</span></span></label>
                <p class="filter-radio-tips"><span>Native speakers or advanced speakers who can help through informal tutoring or speaking practice.</span></p>
              </div>
            </div>
            <div class="filter-footer">
              <button type="button" data-filter="teacherType" class="teacherSearchApplyBtn ant-btn filter-apply-btn ant-btn-primary ant-btn-sm"><span data-cy="ts_apply">Apply</span></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingSix">
      <h2 class="mb-0">
        <button class="collapsed tag-filter" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseThree">
          Lesson Type
        </button>
      </h2>
    </div>
    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
      <div class="card-body">
        <div class="filter-container filter-container-category">
          <div class="filter-body">
            <div class="filter-checkbox-groups">
              <div class="filter-checkbox-group">
                  
                @foreach ($lessonType as $val)
                <label class="filter-checkbox ant-checkbox-wrapper"><span class="ant-checkbox">
                  <input type="checkbox" name="searchLessonType" class="ant-checkbox-input" data-cy="ts_category_1" value="{{$val->name}}">
                  <span class="ant-checkbox-inner"></span></span><span><span>{{$val->name}}</span></span></label>
                @endforeach
                
                
                <!--<label class="filter-checkbox ant-checkbox-wrapper"><span class="ant-checkbox">
                  <input type="checkbox" class="ant-checkbox-input" data-cy="ts_category_2" value="">
                  <span class="ant-checkbox-inner"></span></span><span><span>Informal tutoring</span></span></label>
                <label class="filter-checkbox ant-checkbox-wrapper"><span class="ant-checkbox">
                  <input type="checkbox" class="ant-checkbox-input" data-cy="ts_category_3" value="">
                  <span class="ant-checkbox-inner"></span></span><span><span>Conversation Practice</span></span></label>
                
                  <label class="filter-checkbox ant-checkbox-wrapper"><span class="ant-checkbox">
                  <input type="checkbox" class="ant-checkbox-input" data-cy="ts_category_6" value="">
                  <span class="ant-checkbox-inner"></span></span><span><span>Kids</span></span></label>-->
              </div>
            </div>
            <div class="filter-footer">
              <button type="button" data-filter="lessonType" class="teacherSearchApplyBtn ant-btn filter-apply-btn ant-btn-primary ant-btn-sm"><span data-cy="ts_apply">Apply</span></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingSeven">
      <h2 class="mb-0">
        <button class="collapsed tag-filter" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
          Native speaker
        </button>
      </h2>
    </div>
    <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionExample">
      <div class="card-body">
        <div class="filter-container filter-container-speaks" style="width: 280px;">
          <div class="filter-body">
            <div class="ant-radio-group ant-radio-group-outline filter-radio-group">
              <div class="filter-radio">
                <label class="ant-radio-wrapper"><span class="ant-radio">
                  <input name="speaker_type_search" id="teacher-type-pro" type="radio" class="ant-radio-input" value="native">
                  <span class="ant-radio-inner"></span></span><span><span data-cy="ts_teachertypes_pro">Native speaker</span></span></label>
              </div>
              <div class="filter-radio">
                <label class="ant-radio-wrapper"><span class="ant-radio">
                  <input name="speaker_type_search" id="teacher-type-com" type="radio" class="ant-radio-input" value="non_native">
                  <span class="ant-radio-inner"></span></span><span><span data-cy="ts_teachertypes_general">Non-native speaker</span></span></label>
              </div>
              <div class="filter-radio">
                <label class="ant-radio-wrapper ant-radio-wrapper-checked"><span class="ant-radio ant-radio-checked">
                  <input name="speaker_type_search" id="teacher-type-all" type="radio" class="ant-radio-input" value="both">
                  <span class="ant-radio-inner"></span></span><span><span data-cy="ts_teachertypes_both">Both</span></span></label>
              </div>
              
            </div>
            <div class="filter-footer">
              <button type="button" data-filter="nativeSpeaker" class="teacherSearchApplyBtn ant-btn filter-apply-btn ant-btn-primary ant-btn-sm"><span data-cy="ts_apply">Apply</span></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingEight">
      <h2 class="mb-0">
        <button class="collapsed tag-filter" type="button" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
          Instant Tutoring
        </button>
      </h2>
    </div>
    <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordionExample">
      <div class="card-body">
        <div class="filter-container filter-container-speaks" style="width: 280px;">
          <div class="filter-body">
            
            <div class="filter-from">
                <div class="filter-radio">
                    <label class="ant-radio-wrapper ant-radio-wrapper-checked"><span class="ant-radio ant-radio-checked">
                      <input name="instant_tutoring_search" type="radio" class="ant-radio-input" value="30 mins">
                      <span class="ant-radio-inner"></span></span><span><span data-cy="ts_teachertypes_both">30 minutes</span></span></label>
                </div>
                <div class="filter-radio">
                    <label class="ant-radio-wrapper ant-radio-wrapper-checked"><span class="ant-radio ant-radio-checked">
                      <input name="instant_tutoring_search" type="radio" class="ant-radio-input" value="45 mins">
                      <span class="ant-radio-inner"></span></span><span><span data-cy="ts_teachertypes_both">45 minutes</span></span></label>
                </div>
                <div class="filter-radio">
                    <label class="ant-radio-wrapper ant-radio-wrapper-checked"><span class="ant-radio ant-radio-checked">
                      <input name="instant_tutoring_search" type="radio" class="ant-radio-input" value="60 mins">
                      <span class="ant-radio-inner"></span></span><span><span data-cy="ts_teachertypes_both">60 minutes</span></span></label>
                </div>
                <div class="filter-radio">
                    <label class="ant-radio-wrapper ant-radio-wrapper-checked"><span class="ant-radio ant-radio-checked">
                      <input name="instant_tutoring_search" type="radio" class="ant-radio-input" value="75 mins">
                      <span class="ant-radio-inner"></span></span><span><span data-cy="ts_teachertypes_both">75 minutes</span></span></label>
                </div>
                <div class="filter-radio">
                    <label class="ant-radio-wrapper ant-radio-wrapper-checked"><span class="ant-radio ant-radio-checked">
                      <input name="instant_tutoring_search" type="radio" class="ant-radio-input" value="90 mins">
                      <span class="ant-radio-inner"></span></span><span><span data-cy="ts_teachertypes_both">90 minutes</span></span></label>
                </div>   
                                                                      
                <div class="filter-footer">
                  <button type="button" data-filter="instantTutoring" class="teacherSearchApplyBtn ant-btn filter-apply-btn ant-btn-primary ant-btn-sm"><span data-cy="ts_apply">Apply</span></button>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingNine">
      <h2 class="mb-0">
        <button class="collapsed tag-filter" type="button" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
          Focus Areas
        </button>
      </h2>
    </div>
    <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordionExample">
      <div class="card-body">
        <div class="filter-container filter-container-speaks" style="width: 280px;">
          <div class="filter-body">
            <div class="filter-from">
                
                @foreach ($lessonTags as $val) 
                <label class="filter-checkbox ant-checkbox-wrapper"><span class="ant-checkbox">
                    <input type="checkbox" name="searchfocusAreas" class="ant-checkbox-input" data-cy="" value="{{$val->tag}}">
                    <span class="ant-checkbox-inner"></span></span><span><span>{{$val->tag}}</span></span></label> 
                @endforeach
                
                                                                      
                <div class="filter-footer">
                  <button type="button" data-filter="focusAreas"  class="teacherSearchApplyBtn ant-btn filter-apply-btn ant-btn-primary ant-btn-sm"><span data-cy="ts_apply">Apply</span></button>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</section>