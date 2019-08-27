
@section("socialmedia")

        <!--Signin Modal -->
<div class="modal fade socialmedia signinModalWrap" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="buttonclose" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="trueicon-tt-close-icon"></span>
            </button>
            <div class="modal-body">
                <h3>Share</h3>
                <div id="unik" data-ayoshare="<?php if(isset($social_media_url)) echo urldecode($social_media_url); ?>"></div>
                <div id="my-inline-buttons"></div>
            </div>
        </div>
    </div>
</div>

@show