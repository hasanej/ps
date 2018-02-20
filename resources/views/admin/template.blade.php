@php 
	use App\User;


	$id = Auth::user()->id;
	$role = User::find($id)->role;
@endphp

<!DOCTYPE html>
<html>
<head>
	<style>
		ul.wysihtml5-toolbar li a[title="Insert image"] { display: none; }
		ul.wysihtml5-toolbar li a[title="Insert link"] { display: none; }
		ul.wysihtml5-toolbar li a[title="Outdent"] { display: none; }
		ul.wysihtml5-toolbar li a[title="Indent"] { display: none; }
		ul.wysihtml5-toolbar li a[data-wysihtml5-command-value="blockquote"] { display: none; }
	</style>

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
	        		<li class="treeview {!! Request::is('berita') ? 'active' : Request::is('artikel') ? 'active' : '' !!}">
			          	<a href="#">
			            	<i class="fa fa-newspaper-o"></i> 
			            	<span>Manajemen Konten</span>
			            	<span class="pull-right-container">
			              		<i class="fa fa-angle-left pull-right"></i>
			            	</span>
			          	</a>
			          	<ul class="treeview-menu">
			            	<li class="{!! Request::is('berita') ? 'active' : '' !!}">
			              		<a href="{{ route('berita.index') }}"><i class="fa fa-list-alt"></i>Daftar Berita</a>
			              	</li>
			            	<li class="{!! Request::is('artikel') ? 'active' : '' !!}">
			            		<a href="{{ 'komenBerita' }}"><i class="fa fa-comments-o"></i>Daftar Artikel</a>
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
	            	<li class="{!! Request::is('admin') ? 'active' : '' !!}"><a href="{{ route('admin.index') }}">
            			<i class="fa fa-user"></i> <span>Manajemen Administrator</span>
	            		<span class="pull-right-container">
            			</span></a>
	            	</li>
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