@extends('default')

@section('content')
<div class="container">


    <div class="col-md-8 offset-2">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">
                        <h5></h5>
                    </div>
                    
                </div> 
            </div>
            <div class="card-body">
                
                <form action="{{ route('formsubmit') }}" method="POST">
                     @csrf
                  <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Select Date</label>
                    <div class="col-sm-10">
                      <input type="text" name="daterange" value="" class="form-control" />
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-10">
                       <button type="submit" class="btn btn-primary" disabled>Submit</button>
                    </div>
                  </div>


                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
@section('jquery')
<script type="text/javascript">
    
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left',

  }, function(start, end, label) {

    const date1 = new Date(start.format('YYYY-MM-DD'));
    const date2 = new Date(end.format('YYYY-MM-DD'));
    const diffTime = Math.abs(date2 - date1);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
    if(diffDays <= 7){
        $(':input[type="submit"]').prop('disabled', false);
    }else{
        alert("End date should not exceed more than 7 days");
        $(':input[type="submit"]').prop('disabled', true);
    }

  });
});


</script>
@endsection 