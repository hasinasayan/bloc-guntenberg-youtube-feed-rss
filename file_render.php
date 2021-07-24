<?php
$list = array();
$entry_item = $decode_rss->items;
foreach ($entry_item as $feed_item) {
    $title          = $feed_item->snippet->title;
	$video_link     ='https://www.youtube.com/embed/'. $feed_item->id->videoId;
	$image_avant    = $feed_item->snippet->thumbnails->high->url;
	$list[] = array('title'=>$title,'lien_video'=>$video_link,'image_avant'=>$image_avant);
}
?>
<div class="row">
    <?php for ($i=0; $i <= count($list);$i++): ?>
    <?php if (!empty($list[$i]) && isset($list[$i])): ?>
    <div class="col-lg-4 col-md-12 mb-4 youtube-card">
        <!--Modal: Name-->
        <div class="modal popup fade" id="modal<?php echo $i; ?>" tabindex="-1" role="dialog" data-modal="modal<?php echo $i; ?>" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body mb-0 p-0">
                        <div class="embed-responsive embed-responsive-16by9 z-depth-1-half">
                            <iframe id="video" class="embed-responsive-item" src="<?php echo $list[$i]['lien_video']; ?>" allowfullscreen  allow="autoplay"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal: Name-->
        <a class="lien-modal" data-src="<?php echo $list[$i]['lien_video']; ?>" style="cursor: pointer;"><img class="img-fluid z-depth-1" src="<?php echo $list[$i]['image_avant']; ?>" alt="video"
                data-toggle="modal" data-target="#modal<?php echo $i; ?>"></a>
        <h4 class="text-dark pt-2 font-weight-bold" style="font-size: 15px;"><?php echo $list[$i]['title']; ?></h4>
    </div>
<?php endif; endfor; ?>
</div>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery(".lien-modal").on('click',function () {
            var _modal = jQuery(".modal");
            var _modal_link = jQuery(this).data('src');
            _modal.on('show.bs.modal', function () {
                var _this = jQuery(this);
                var _idElement = _this.data('modal');
                var _video = jQuery('#' + _idElement + ' iframe');
                _video.attr("src", _modal_link+"?autoplay=1");
            });
            _modal.on('hidden.bs.modal', function () {
                var _this = jQuery(this);
                var _idElement = _this.data('modal');
                var _video = jQuery('#' + _idElement + ' iframe');
                _video.attr("src", _modal_link);
            });
        });
    });
</script>
