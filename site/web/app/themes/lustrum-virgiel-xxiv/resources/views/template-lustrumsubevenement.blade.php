{{--
  Template Name: LustrumSubEvenement
--}}

@extends('layouts.app')

@section('hero')
    <section class="hero lazy" @if(get_the_post_thumbnail_url()) data-src="{{ the_post_thumbnail_url() }}" @endif>
        <div class="hero-body">
            <div class="container">
                <h1 class="is-uppercase fancy_title has-text-centered-mobile">{!! App::title() !!}</h1>
                @if(!empty(get_field('event_subtitle')))
                    <div class="subtitle">
                        <h2 class="is-uppercase is-size-5 is-size-4-tablet is-size-3-desktop has-text-weight-bold has-text-centered-mobile">{{ the_field('event_subtitle') }}</h2>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('content')
    {{  App::wps_yoast_breadcrumb_bulma() }}

    <hr>

    @while(have_posts()) @php(the_post())

    <div class="is-hidden-desktop">
        @include('partials.subevent-quick-info')
    </div>

    <div class="dropcap has-text-justified">
        @include('partials.content-page')
    </div>

        @if(have_rows('artists'))
            <div class="artists">
                <div class="columns is-multiline is-mobile">
                    @while(have_rows('artists')) @php(the_row())
                        <div class="artist column is-half-mobile is-one-quarter-tablet">
                            <a href="{!! TemplateLustrumsubevenement::artistLink() !!}" target="_blank" rel="nofollow">
                                <div class="artist-tile has-shadow z-depth-1" data-tilt>
                                    <div class="artist-image lazy" data-src="{!! TemplateLustrumsubevenement::artistImage() !!}">
                                    </div>
                                    <div class="artist-title">
                                        <h5 class="has-text-weight-bold is-marginless is-uppercase has-shadow z-depth-2">{{ TemplateLustrumsubevenement::artistName() }}</h5>
                                    </div>
                                    <div class="artist-link-out">
                                        <svg viewBox="0 0 24 24">
                                            <path fill="#fff" d="M14,3V5H17.59L7.76,14.83L9.17,16.24L19,6.41V10H21V3M19,19H5V5H12V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V12H19V19Z" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endwhile
                </div>
            </div>
        @endif

    <div class="dropcap has-text-justified">
        {{ the_field('practical_information') }}
    </div>
    @endwhile
@endsection

@section('sidebar')
    <div class="is-hidden-touch">
        @include('partials.subevent-quick-info')
    </div>

    <hr>

    @if($related_posts->have_posts())
        <section class="widget widget_related_posts">
            <h3><div class="widget-title has-shadow z-depth-1">
                    <span class="icon lazy" data-src="@asset('images/common/3d-icon.svg')"></span> Updates</div></h3>

            @while($related_posts->have_posts())  @php($related_posts->the_post())
            @include('partials.content-related')
            @endwhile
            {{ wp_reset_postdata() }}

        </section>

    @endif

    @if(!empty($event_location))
        <section class="widget">
            <h3><div class="widget-title has-shadow z-depth-1">
                    <span class="icon lazy" data-src="@asset('images/common/2d-icon.svg')"></span> Locatie
                </div>
            </h3>

            <div class="acf-map">
                <div class="marker" data-lat="{!! $event_location['lat'] !!}" data-lng="{!! $event_location['lng'] !!}"></div>
            </div>
        </section>
    @endif

    @if(have_rows('stages'))
        @while(have_rows('stages')) @php(the_row())
        <section class="widget timetable">
            <h3><div class="widget-title has-shadow z-depth-1 mdi mdi-clock mdi-24px">
                    {{ the_sub_field('titel') }}
            </div></h3>
            <table class="timetable-table">
                <tbody>
                    @if(have_rows('timetable'))
                        @while(have_rows('timetable')) @php(the_row())
                            <tr class="row">
                                <td class="time has-text-weight-light">{{ the_sub_field('time') }}</td>
                                <td class="artist has-text-weight-bold is-size-5 is-uppercase">{{ the_sub_field('artist') }}</td>
                            </tr>
                        @endwhile
                    @endif
                </tbody>
            </table>
        </section>
        @endwhile
    @endif

    @if (App\display_sidebar())
        @include('partials.sidebar')
    @endif
@endsection

@section('content_footer')
    <div class="content-footer">
        <h2 class="is-uppercase has-text-weight-bold">Programma</h2>
        <div class="columns is-multiline is-mobile event-tiles">
            @while(have_rows('activiteiten', TemplateLustrumsubevenement::parentPageID())) @php(the_row())
            <div class="column is-one-third-mobile is-2-tablet">
                <a href="{!! get_permalink(TemplateLustrumevenement::activityPage()->ID) !!}">
                    <div class="event-tile has-shadow z-depth-1">
                        <div class="event-image lazy" data-src="{!! TemplateLustrumevenement::activityImage() !!}">
                        </div>
                        <div class="event-date">
                            <span class="font-fit">{!! TemplateLustrumevenement::activityDate(TemplateLustrumevenement::activityPage()) !!}</span>
                            <span class="font-fit">{!! TemplateLustrumevenement::activityMonth(TemplateLustrumevenement::activityPage()) !!}</span>
                        </div>
                        <div class="event-title">
                            <span class="font-fit">{!! TemplateLustrumevenement::activityTitle() !!}</span>
                        </div>
                        <div class="event-read-more has-text-black has-text-weight-bold">
                            <span class="is-size-7">Lees meer</span>
                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                <path fill="#000" d="M8.59,16.58L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.58Z" />
                            </svg>
                        </div>
                        @if(get_field('sold_out', TemplateLustrumevenement::activityPage()->ID))
                            <span class="sold-out is-uppercase has-text-weight-bold has-background-danger">Uitverkocht!</span>
                        @endif
                    </div>
                </a>
            </div>
            @endwhile
        </div>
    </div>
@endsection