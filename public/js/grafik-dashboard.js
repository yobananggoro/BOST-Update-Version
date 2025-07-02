
$(function(){
    var chart_l = [];
    var chart_d = [];
      $.ajax({
          method: 'get',
          url: 'home/getdata',
          dataType: "json",
          success: function(data){
             chart_l = data.chart_labels;       
             chart_d = data.chart_dataset; 
             var canvas = document.getElementById('myChart').getContext('2d');
             var myChart = new Chart(canvas, {
                                    type: 'pie',
                                    data: {
                                        labels: chart_l,
                                        datasets: [{
                                            label: '# of Votes',
                                            data: chart_d,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.2)',
                                                'rgba(54, 162, 235, 0.2)',
                                                'rgba(255, 206, 86, 0.2)',
                                                'rgba(75, 192, 192, 0.2)',
                                                'rgba(153, 102, 255, 0.2)',
                                                'rgba(255, 159, 64, 0.2)'
                                            ],
                                            borderColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(255, 159, 64, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true
                                                }
                                            }]
                                        }
                                    }
                    });      
          }
          
    });
    
});
$(function(){
    var chart_l2 = [];
    var chart_d2 = [];
      $.ajax({
          method: 'get',
          url: 'home/getdata2',
          dataType: "json",
          success: function(data){
             chart_l2 = data.chart_labels2;       
             chart_d2 = data.chart_dataset2; 
             var canvas = document.getElementById('myChart2').getContext('2d');
             var myChart = new Chart(canvas, {
                                    type: 'pie',
                                    data: {
                                        labels: chart_l2,
                                        datasets: [{
                                            label: '# of Votes',
                                            data: chart_d2,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.2)',
                                                'rgba(54, 162, 235, 0.2)',
                                                'rgba(255, 206, 86, 0.2)',
                                                'rgba(75, 192, 192, 0.2)',
                                                'rgba(153, 102, 255, 0.2)',
                                                'rgba(255, 159, 64, 0.2)'
                                            ],
                                            borderColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(255, 159, 64, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true
                                                }
                                            }]
                                        }
                                    }
                    });      
          }
          
    });
    
});
$(function(){
    var chart_l3 = [];
    var chart_d3 = [];
      $.ajax({
          method: 'get',
          url: 'home/getdata3',
          dataType: "json",
          success: function(data){
             chart_l3 = data.chart_labels3;       
             chart_d3 = data.chart_dataset3; 
             var canvas = document.getElementById('myChart3').getContext('2d');
             var myChart = new Chart(canvas, {
                                    type: 'polarArea',
                                    data: {
                                        labels: chart_l3,
                                        datasets: [{
                                            label: '# of Votes',
                                            data: chart_d3,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.2)',
                                                'rgba(54, 162, 235, 0.2)',
                                                'rgba(255, 206, 86, 0.2)',
                                                'rgba(75, 192, 192, 0.2)',
                                                'rgba(153, 102, 255, 0.2)',
                                                'rgba(255, 159, 64, 0.2)'
                                            ],
                                            borderColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(255, 159, 64, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true
                                                }
                                            }]
                                        }
                                    }
                    });      
          }
          
    });
    
});
$(function(){
    var chart_l3 = [];
    var chart_d3 = [];
      $.ajax({
          method: 'get',
          url: 'home/getdata4',
          dataType: "json",
          success: function(data){
             chart_l4 = data.chart_labels4;       
             chart_d4 = data.chart_dataset4; 
             var canvas = document.getElementById('myChart4').getContext('2d');
             var myChart = new Chart(canvas, {
                                    type: 'pie',
                                    data: {
                                        labels: chart_l4,
                                        datasets: [{
                                            label: '# of Votes',
                                            data: chart_d4,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.2)',
                                                'rgba(54, 162, 235, 0.2)',
                                                'rgba(255, 206, 86, 0.2)',
                                                'rgba(75, 192, 192, 0.2)',
                                                'rgba(153, 102, 255, 0.2)',
                                                'rgba(255, 159, 64, 0.2)'
                                            ],
                                            borderColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(255, 159, 64, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true
                                                }
                                            }]
                                        }
                                    }
                    });      
          }
          
    });
    
});