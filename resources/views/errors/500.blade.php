@extends('errors.layout')

@section('title', __('Server Error'))
@section('code', '500')
@section('heading', __('Server Error'))
@section('message', __('Something went wrong on our end. Please try again later.'))
