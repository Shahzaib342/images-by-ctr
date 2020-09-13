/**
 *
 * @type {{Created by Shahzaib 07 Sep,2020}}
 */
var app = {};

(function ($) {
    'use strict';

    $(document).ready(function () {
        app.image = $(".image");
        app.waitNotification = $(".text-wait");
        app.imageStats = $(".image-stats");
        app.errorNotification = $(".error");
        //load images
        app.getImage();
        setInterval(function(){
         app.getImage();
          }, 120000);

        //show timer
        var $timer = 120;
        setInterval(function(){
         app.waitNotification.text('Loading next image in ' + $timer--);
         app.waitNotification.removeClass('g-dn');
         if($timer == 0) {
            $timer = 120;
         }
          }, 1000);
    });

    //get random image by highest CTR from DB
    app.getImage = function () {
        app.image.addClass("g-dn");
        app.imageStats.empty().addClass("g-dn");
        app.errorNotification.addClass("g-dn");
        $.ajax({
            url: "lib/all.php",
            type: "get",
            data: {"action": "getImage"},
            dataType: "json",
            success: function (response) {
                app.image.removeClass('g-dn');
                app.image.attr('src', response.data[0].URL);
                app.image.attr('id', response.data[0].ID);
                setTimeout(function () {
                    app.imageStats.append('<span>ID: ' + response.data[0].ID + '</span><br>');
                    app.imageStats.append('<span>Hits: ' + response.data[0].HITS + '</span><br>');
                    app.imageStats.append('<span>Clicks: ' + response.data[0].CLICKS + '</span><br>');
                    app.imageStats.append('<span>CTR: ' + response.data[0].CTR + '.00%</span>');
                    app.imageStats.removeClass("g-dn");
                }, 2000);
                app.updateStatus(response.data[0].ID);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                app.errorNotification.removeClass('g-dn').text('There is some database error occurred please contact support');
            }
        });
    };

    //update clicks after image is clicked
    app.updateClicks = function (elem) {
        app.errorNotification.addClass("g-dn");
        var id = parseInt(elem.attr("id"));
        $.ajax({
            url: "lib/all.php",
            type: "get",
            data: {"action": "updateClicks", id: id},
            dataType: "json",
            success: function (response) {
                if(!response.data) {
                    app.errorNotification.removeClass('g-dn').text('There is some database error occurred while updating CTR please contact support');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                app.errorNotification.removeClass('g-dn').text('There is some database error occurred please contact support');
            }
        });
    };


    //update view status after image is viewed
    app.updateStatus = function (id) {
        $.ajax({
            url: "lib/all.php",
            type: "get",
            data: {"action": "updateStatus", id: id},
            dataType: "json",
            success: function (response) {
                if(!response.data) {
                    app.errorNotification.removeClass('g-dn').text('There is some database error occurred while updating CTR please contact support');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                app.errorNotification.removeClass('g-dn').text('There is some database error occurred please contact support');
            }
        });
    };
}(jQuery));