<div class="job-desc-right br-10 px-40 bg-gray mb-40 mt-lg-0 mt-md-5 mt-4">
    <div class="desc-box d-flex justify-content-between mb-2">
        <div class="d-flex align-items-center mb-3">
            <i class="fa-solid fa-calendar-days text-primary me-2 fs-18"></i>
            <p class="fs-14 text-secondary mb-0">
                {{__('messages.candidate_profile.education')}}:</p>
        </div>
        <p class="fs-14 text-gray text-end">
           {{!empty($candidateDetails->experience) ? $candidateDetails->experience.  ' '.__('messages.candidate_profile.years') : __('messages.common.n/a')}} </p>
    </div>

    @if($candidateDetails->user->dob)
        <div class="desc-box d-flex justify-content-between mb-2">
            <div class="d-flex align-items-center mb-3">
                <i class="fa-solid fa-clock text-primary me-2 fs-18"></i>
                <p class="fs-14 text-secondary mb-0">
                    <i class="icon icon-expiry"></i>{{__('messages.candidate_profile.age')}}:</p>
            </div>
            <p class="fs-14 text-gray text-end">
                {{!empty($candidateDetails->user->dob) ?\Carbon\Carbon::parse($candidateDetails->user->dob)->age. ' '.__('messages.candidate_profile.years') : __('messages.common.n/a')}}
            </p>
        </div>
    @endif
    <div class="desc-box d-flex justify-content-between mb-2">
        <div class="d-flex align-items-center mb-3">
            <i class="fa-solid fa-location-dot text-primary me-2 fs-18"></i>
            <p class="fs-14 text-secondary mb-0">{{__('messages.candidate.current_salary')}}:</p>
        </div>
        <p class="fs-14 text-gray text-end">
            {{ !empty($candidateDetails->current_salary) ? $candidateDetails->current_salary : __('messages.common.n/a')}}
        </p>
    </div>
    <div class="desc-box d-flex justify-content-between mb-2">
        <div class="d-flex align-items-center mb-3">
            <i class="fa-solid fa-briefcase text-primary me-2 fs-18"></i>
            <p class="fs-14 text-secondary mb-0"> <i class="icon icon-salary"></i>{{__('messages.candidate.expected_salary')}}:</p>
        </div>
        <p class="fs-14 text-gray text-end">
            {{ !empty($candidateDetails->expected_salary) ? $candidateDetails->expected_salary : __('messages.common.n/a') }}</p>
    </div>

        <div class="desc-box d-flex justify-content-between mb-2">
            <div class="d-flex align-items-center mb-3">
                <i class="fa-solid fa-briefcase text-primary me-2 fs-18"></i>
                <p class="fs-14 text-secondary mb-0"> <i class="icon icon-salary"></i><i class="icon icon-user-2"></i>{{__('messages.candidate.gender')}}:</p>
            </div>
            <p class="fs-14 text-gray text-end">
                @if($candidateDetails->user->gender == 0)
                    {{ __('messages.common.male')}}
                @elseif($candidateDetails->user->gender == 1)
                    {{ __('messages.common.female')}}
                @else
                    {{ __('messages.common.n/a')}}
                @endif
               </p>
        </div>
    @if(! empty($candidateDetails->user->facebook_url) || ! empty($candidateDetails->user->twitter_url) || ! empty($candidateDetails->user->google_plus_url) || ! empty($candidateDetails->user->pinterest_url) || ! empty($candidateDetails->user->linkedin_url))
        <div class="sidebar-widget social-media-widget">
            <h4 class="widget-title">{{__('messages.social_media')}}</h4>
            <div class="widget-content">
                <div class="social-links">
                    @if(! empty($candidateDetails->user->facebook_url))
                        <a href="{{ (isset($candidateDetails->user->facebook_url)) ? addLinkHttpUrl($candidateDetails->user->facebook_url) : 'javascript:void(0)' }}"
                           target="_blank"><i class="fab fa-facebook-f me-2"></i></a>
                    @endif
                    @if(! empty($candidateDetails->user->twitter_url))
                        <a href="{{ (isset($candidateDetails->user->twitter_url)) ? addLinkHttpUrl($candidateDetails->user->twitter_url) : 'javascript:void(0)' }}"
                           target="_blank"><i class="fab fa-twitter me-2"></i></a>
                    @endif
                    @if(! empty($candidateDetails->user->google_plus_url))
                        <a href="{{ (isset($candidateDetails->user->google_plus_url)) ? addLinkHttpUrl($candidateDetails->user->google_plus_url) : 'javascript:void(0)' }}"
                           target="_blank"><i class="fab fa-google-plus-g me-2"></i></a>
                    @endif
                    @if(! empty($candidateDetails->user->pinterest_url))
                        <a href="{{ (isset($candidateDetails->user->pinterest_url)) ? addLinkHttpUrl($candidateDetails->user->pinterest_url) : 'javascript:void(0)' }}"
                           target="_blank"><i class="fab fa-pinterest-p me-2"></i></a>
                    @endif
                    @if(! empty($candidateDetails->user->linkedin_url))
                        <a href="{{ (isset($candidateDetails->user->linkedin_url)) ? addLinkHttpUrl($candidateDetails->user->linkedin_url) : 'javascript:void(0)' }}"
                           target="_blank"><i class="fab fa-linkedin-in me-2"></i></a>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

<div class="job-desc-right br-10 px-40 bg-gray mb-40 mt-lg-0 mt-md-5 mt-4">

<div class="sidebar-widget">
    <h4 class="widget-title">{{__('messages.professional_skills')}}</h4>
    <div class="widget-content">
        <ul class="job-skills ps-0">
            @if($candidateDetails->user->candidateSkill->count())
                @foreach($candidateDetails->user->candidateSkill as $candidateSkill)
                    <li>
                        <a class="text-hover-primary text-gray cursor-default">{{ html_entity_decode($candidateSkill->name) }}</a>
                    </li>
                @endforeach
            @else
                <h4 class="text-center">{{ __('messages.skill.no_skill_available') }}</h4>
            @endif
        </ul>
    </div>
</div>
</div>
