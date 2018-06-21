<div id="js-grid-mosaic" class="cbp cbp-l-grid-mosaic">
 @if(is_array($contents)) 
        @foreach($contents as $key=>$value)

        <div class="cbp-item web-design graphic">
            <a href="{{ asset($value['image']) }}" class="cbp-caption cbp-lightbox"
               data-title="Bolt UI<br>by Tiberiu Neamu">
                <div class="cbp-caption-defaultWrap">
                     <img src="{{ asset($value['image']) }}" alt="">
                </div>
                <div class="cbp-caption-activeWrap">
                    <div class="cbp-l-caption-alignCenter">
                        <div class="cbp-l-caption-body">
                            <div class="cbp-l-caption-title"><?php echo  $value['name'] ;?></div>
                            <div class="cbp-l-caption-desc"><?php echo  $value['caption'] ;?></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    @endforeach
@endif
</div>    


<script type="text/javascript">
(function($, window, document, undefined) {
    'use strict';

    // init cubeportfolio
    $('#js-grid-mosaic').cubeportfolio({
        filters: '#js-filters-mosaic',
        loadMore: '#js-loadMore-mosaic',
        loadMoreAction: 'click',
        layoutMode: 'mosaic',
        sortToPreventGaps: true,
        mediaQueries: [{
            width: 1500,
            cols: 5
        }, {
            width: 1100,
            cols: 4
        }, {
            width: 800,
            cols: 3
        }, {
            width: 480,
            cols: 2
        }, {
            width: 320,
            cols: 1
        }],
        defaultFilter: '*',
        animationType: 'quicksand',
        gapHorizontal: 0,
        gapVertical: 0,
        gridAdjustment: 'responsive',
        caption: 'zoom',
        displayType: 'sequentially',
        displayTypeSpeed: 100,

        // lightbox
        lightboxDelegate: '.cbp-lightbox',
        lightboxGallery: true,
        lightboxTitleSrc: 'data-title'
    });
})(jQuery, window, document);

</script>