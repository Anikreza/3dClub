@extends('master')
@section('content')
    @include('layouts.banner')
    @include('pages.home.partial.aboutHome')
    @include('pages.home.partial.homeProduct', ['products' => $publishedArticles ])
    @include('pages.home.partial.companyAd')
@endsection
