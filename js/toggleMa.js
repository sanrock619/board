    $(document).ready(function() {
      var c = 1;
      $("#maFlip").click(function() {
        $("#maPanel").slideToggle("slow");
        c++;
        if (c % 2 != 0) {
          $("#maFlip").text("隱藏管理表單");
        }
        else
          $("#maFlip").text("顯示管理表單");
      });
    });