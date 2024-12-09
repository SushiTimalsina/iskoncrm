<!DOCTYPE html>
<html lang="en-US">
<head>

<!-- Mobile Specific
================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->

<!-- Meta Tags -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!-- Title Tag
================================================== -->
<title>@yield('metatitle')</title>
<meta name="description" content="@yield('metadescription')">
<link rel="apple-touch-icon" href="{{ asset('uploads/logo/logo.png') }}}">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/logo/logo.png') }}">

<!-- Load HTML5 dependancies for IE
================================================== -->
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

@include('backend.layouts.styles')
@yield('styles')
</head>
<body id="kt_app_body" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" class="app-default" onselectstart="return false">
  <!--begin::Theme mode setup on page load-->
  <script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
  <!--end::Theme mode setup on page load-->
