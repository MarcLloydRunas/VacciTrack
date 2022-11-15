$(document).ready(function(){
  $.ajax({
    url: "../admin/stat-charts.php",
    method: "GET",
    success: function(data) {
      console.log(data);
      var vaccine_name = [];
      var entries = [];

      for(var i in data) {
        vaccine_name.push("Vaccine " + data[i].vaccine_name);
        entries.push(data[i].score);
      }

      var chartdata = {
        labels: vaccine_name,
        datasets : [
          {
            label: 'Player Score',
            backgroundColor: 'rgba(200, 200, 200, 0.75)',
            borderColor: 'rgba(200, 200, 200, 0.75)',
            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
            hoverBorderColor: 'rgba(200, 200, 200, 1)',
            data: entries
          }
        ]
      };

      var ctx = $("#mycanvas");

      var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata
      });
    },
    error: function(data) {
      console.log(data);
    }
  });
});