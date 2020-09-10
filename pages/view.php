<div class="container pt-3 d-block">
    <div class="row">
        <div class="span4 col-lg-4">
            <a href="#" onclick="app.getImage();">Get Image</a><br>
            <span class="text-wait g-dn">Please wait.........</span>
            <div class="image-stats g-dn">
                <label>Image Stats:</label><br>
            </div>
        </div>
        <div class="span4 col-lg-8">
            <span class="error g-dn"></span>
            <img class="center-block g-dn image" src="#" onclick="app.updateClicks($(this));"/>
        </div>
    </div>
</div>