<div class="cbp-l-testimonials-wrap" >
    <div class="cbp-l-testimonials-title-block">
        {{ $title }}
    </div>

    <div id="js-grid-testimonials" class="cbp">
        @if(is_array($contents)) 
            @foreach($contents as $key=>$value)
            <div class="cbp-item graphic">
                <div class="cbp-l-grid-testimonials-body">
                     {!! $value['note'] !!}
                </div>
                <div class="cbp-l-grid-testimonials-footer">
                    {!! $value['written'] !!}
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>    


<script type="text/javascript">
(function($, window, document, undefined) {
    'use strict';

    // init cubeportfolio
    $('#js-grid-testimonials').cubeportfolio({
        layoutMode: 'slider',
        drag: true,
        auto: false,
        autoTimeout: 5000,
        autoPauseOnHover: true,
        showNavigation: false,
        showPagination: true,
        rewindNav: false,
        scrollByPage: false,
        gridAdjustment: 'responsive',
        mediaQueries: [{
            width: 1,
            cols: 1
        }],
        gapHorizontal: 0,
        gapVertical: 0,
        caption: '',
        displayType: 'default',
    });
})(jQuery, window, document);

</script>