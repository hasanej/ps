@php 
	use App\User;


	$id = Auth::user()->id;
	$role = User::find($id)->role;
@endphp

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>IN_DEVELOPMENT</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	@include('admin.css')

</head>

<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">

		<header class="main-header">
		    <a href="{{ 'administrator' }}" class="logo">
		    	<span class="logo-mini"><b>I</b>D</span>
			    <span class="logo-lg"><b>In</b>Development</span>
	    	</a>
	    	<nav class="navbar navbar-static-top">
	      		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
	        		<span class="sr-only">Toggle navigation</span>
	      		</a>
	      		<div class="nav navbar-nav pull-right">
	      			<li class="dropdown messages-menu btn-danger" title="Logout">
            			<a href="{{ url('/logout') }}">
                        	<i class="fa fa-power-off"></i>
            			</a>
            		</li>
	      		</div>
		    </nav>
	  	</header>
	  
	  	<aside class="main-sidebar">
	    	<section class="sidebar">

	    		<div class="user-panel">
        			<div class="pull-left image">
          				<img src="{{ asset('assets/image/logo_gunadarma.jpg') }}" alt="Administrator">
        			</div>
        			<div class="pull-left info">
          				<p><i class="fa fa-circle text-success"></i> {{ Auth::user()->name }}</p>
          				<p>{{ $role->nama }}</p>
        			</div>
      			</div>

	      		<ul class="sidebar-menu" data-widget="tree">
	        		<li class="header">MENU</li>
	        		<li class="{!! Request::is('beranda') ? 'active' : '' !!}"><a href="{{ route('beranda.index') }}">
            			<i class="fa fa-home"></i> <span>Beranda</span>
	            		<span class="pull-right-container">
            			</span></a>
	            	</li>
	        		<li class="treeview {!! Request::is('berita') ? 'active' : Request::is('artikel') ? 'active' : Request::is('publikasi') ? 'active' : '' !!}">
			          	<a href="#">
			            	<i class="fa fa-list-alt"></i> 
			            	<span>Manajemen Konten</span>
			            	<span class="pull-right-container">
			              		<i class="fa fa-angle-left pull-right"></i>
			            	</span>
			          	</a>
			          	<ul class="treeview-menu">
			            	<li class="{!! Request::is('berita') ? 'active' : '' !!}">
			              		<a href="{{ route('berita.index') }}"><i class="fa fa-newspaper-o"></i>Berita</a>
			              	</li>
			            	<li class="{!! Request::is('artikel') ? 'active' : '' !!}">
			            		<a href="{{ route('artikel.index') }}"><i class="fa fa-file-text"></i>Artikel</a>
			            	</li>
			            	<li class="{!! Request::is('riset') ? 'active' : '' !!}">
			            		<a href="{{ route('riset.index') }}"><i class="fa fa-rocket"></i>Riset</a>
			            	</li>
			            	<li class="{!! Request::is('publikasi') ? 'active' : '' !!}">
			            		<a href="{{ route('publikasi.index') }}"><i class="fa fa-book"></i>Publikasi</a>
			            	</li>
			          	</ul>
			        </li>
			        <li class="{!! Request::is('kategori') ? 'active' : '' !!}"><a href="{{ route('kategori.index') }}">
            			<i class="fa fa-list"></i> <span>Kategori</span>
	            		<span class="pull-right-container">
            			</span></a>
	            	</li>
	            	<li class="{!! Request::is('user') ? 'active' : '' !!}"><a href="{{ route('user.index') }}">
            			<i class="fa fa-users"></i> <span>Manajemen Pengguna</span>
	            		<span class="pull-right-container">
            			</span></a>
	            	</li>
	            	@if((Auth::user()->id_role)==1)
	            	<li class="{!! Request::is('admin') ? 'active' : '' !!}"><a href="{{ route('admin.index') }}">
            			<i class="fa fa-user"></i> <span>Manajemen Administrator</span>
	            		<span class="pull-right-container">
            			</span></a>
	            	</li>
	            	@endif
	      		</ul>
	    	</section>
	  	</aside>

	  	<div class="content-wrapper">	    	
	    	<section class="content">
				@yield('content')
	    	</section>
	  	</div>
	  
	  	<footer class="main-footer">
	    	<div class="pull-right hidden-xs">
	      		<b>Version</b> 1.0
	    	</div>
	    	<strong>Copyright &copy; 2018 <a>Gunadarma University Computing Center</a>.</strong>
	  	</footer>

	</div>

	@include('admin.js')

</body>
</html>