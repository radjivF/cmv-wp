<?php if( Bw::get_meta('enable_scroller') and Bw::bwpb_active() ): ?>
<div class="bw-scroller bw-no-select<?php echo Bw::get_meta('scroller_dark') ? ' bw-scroller-dark' : ''; ?>">
    <i class="bw-scroller-up fa fa-long-arrow-up"></i>
    <div class="bw-scroller-counter">
        <em>01</em>/<span>01</span>
    </div>
    <i class="bw-scroller-down fa fa-long-arrow-down"></i>
</div>
<?php endif;