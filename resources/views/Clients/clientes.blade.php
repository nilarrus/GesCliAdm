@extends('home')

@section('content')

<!--$sign_in=True;-->
	</div>
	 <nav class="navbar navbar-inverse" >
	  <div class="container-fluid">
	  	<div class="navbar-header">
      		<a class="navbar-brand" href="#">GesCliAdm</a>
    	</div>
	    <ul class="nav navbar-nav navbar-right" >
	<!--   < @if ($sign_in === True)-->
	      <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
	      <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
	<!--	@elseif($sign_in ===False)-->
	       <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign In</a></li>
	      <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
	<!--    @endif -->
	    </ul>
	  </div>
	</nav> 
<!---->

@stop