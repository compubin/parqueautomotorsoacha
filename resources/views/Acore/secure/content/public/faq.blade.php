<div id="js-filters-faq-{{ $CmsID }}" class="cbp-l-filters-underline">
    <div data-filter="*" class="cbp-filter-item-active cbp-filter-item">
        All
    </div>

</div>

<div id="js-grid-faq-{{ $CmsID }}" class="cbp cbp-l-grid-faq">
 @if(is_array($contents)) 
        @foreach($contents as $key=>$value)
    <div class="cbp-item buying">
        <div class="cbp-caption">
            <div class="cbp-caption-defaultWrap">
                <?php echo  $value['question'] ;?>
            </div>
            <div class="cbp-caption-activeWrap">
                <div class="cbp-l-caption-body">
                    <?php echo $value['answer'] ;?>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endif
</div>    


<script type="text/javascript">
(function($, window, document, undefined) {
    'use strict';

    // init cubeportfolio
    $('#js-grid-faq-{{ $CmsID }}').cubeportfolio({
        filters: '#js-filters-faq-{{ $CmsID }}',
        defaultFilter: '*',
        animationType: 'sequentially',
        gridAdjustment: 'default',
        displayType: 'default',
        caption: 'expand',
        gapHorizontal: 0,
        gapVertical: 0
    });
})(jQuery, window, document);


</script>