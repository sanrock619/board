    $(document).ready(function() {
      var c = 0;
      $("#flip").click(function() {
        $("#panel").slideToggle("slow");
        c++;
        if (c % 2 != 0) {
          $("#flip").text("隱藏留言表單");
        }
        else
          $("#flip").text("顯示留言表單");
      });
    });