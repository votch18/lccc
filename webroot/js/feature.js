$(document).ready(function(){

   $(function() {

        var datas = [];
        var id = [];
        var titles = [];
        var desc = [];
        var backgrounds = [];
        var newsid = [];

        function testAjax() {
            return $.ajax({
                url: "/ajax/?a=featured"
            });
        }

        var promise = testAjax();

        promise.success(function (data) {
            //console.log(data);

            datas  = JSON.parse(data);
            var x = 0;
            $.each(datas, function() {
                id[x] = datas[x]._id;
                titles[x] = datas[x].title;
                desc[x] = datas[x].content;
                backgrounds[x] = datas[x].img;
                newsid[x] = datas[x].newsid;
                //alert(datas[x].title);
                x++;
            });

        });



        var img = $("#feat-img");

        var pos = -1;
        var current = -1;


        function nextBackground() {
          var location = '';
          var title = '';
          var link = ''

          current = (pos = ++pos % backgrounds.length);

          if (backgrounds.length < 1){
              location = '/uploads/news/cover/feat_default.jpg';
              title = 'Welcome to San Francisco, Agusan del Sur!';
              link = '/';
          } else {
              location = '/uploads/news/cover/' + backgrounds[current];
              title = titles[current];
              link = "/news/?t=" + newsid[current];
          }

            img.css({						//change css style
                "background-image":"url('" + location + "')",
                "background-size":"cover",
                "background-position":"center",
                "background-repeat":"no-repeat"
            });


            $("#feat-desc").html(
                "<a href='" + link + "' style='color: #ffffff;'><h3>"+ title +"</h3></a><br/>"
            );
            setTimeout(nextBackground, 10000);
            move();
        }
        //var num = (current == 0) ? 1 : 10000;
        setTimeout(nextBackground, 10000);
        move();
        //img.css('background', backgrounds[0]);


    });

function move() {
    var elem = document.getElementById("myBar");
    var width = 1;
    var id = setInterval(frame, 100);
    function frame() {
        if (width >= 100) {
            clearInterval(id);
        } else {
            width++;
            elem.style.width = width + '%';
        }
    }
}


});
