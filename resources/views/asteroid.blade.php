@extends('default')

@section('content')
<div class="container">


    <div class="col-md-12">
    
          <p>Fastest Asteroid in km/h: {{ max($fastestAsteroidArr) }} </p>   
          <p>Closest Asteroid: {{ min($closestAsteroidArr) }}</p>   
          <p>Average Size of the Asteroids in kilometers: {{$avgAsteroid}}</p>  

          <div id="line_chart" style="width: 900px; height: 500px"></div>
          
          <a href="/" class="btn btn-success">Go Back</a>
        
    </div>
</div>
@endsection 
 <script src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    
   google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

    var asteroidData = <?php echo json_encode($asteroidData); ?>;
    console.log(asteroidData);


      var data = new google.visualization.DataTable();
      data.addColumn('number', '');
      data.addColumn('number', 'Fastest Asteroid');
      data.addColumn('number', 'Closest Asteroid');
      data.addColumn('number', 'Average Size of Asteroid');

      data.addRows(asteroidData);

      var options = {
        chart: {
          title: 'Asteroid Data',
        },
        width: 900,
        height: 500
      };

      var chart = new google.charts.Line(document.getElementById('line_chart'));

      chart.draw(data, google.charts.Line.convertOptions(options));

  }

</script>