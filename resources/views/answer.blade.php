@extends('layouts.app')

@section('title', $qtnRespo['question'])

@section('content')
<style>
   .answer{
    font-size:16px;
    line-height:28px;
   } 
</style>
<div class="container py-2"> 
    <div class="py-2 qtn-answer">
        <h2 style="color: #ff5722;">{{$qtnRespo['question']}}</h2>
        <p class="answer">{!! $qtnRespo['answer'] !!}</p>
    </div>   

    <!-- Ask Us Form -->
    <div class="py-4" style="background-color: #f8f9fa; border-radius: 8px;">
        <h5 class="text-center mb-4">Do you have other Questions?</h5>
        <div class="text-center">
            <p class="mb-4">Got questions about life, jobs, or visas in Sweden? Ask us anything, or browse our FAQ to find answers!</p>
        </div>
        <form id="askForm" class="mx-auto" style="max-width: 600px;">
            @csrf
            <div class="form-group mb-3">
                <textarea class="form-control" id="question" name="question" rows="3" placeholder="Type your question here..." style="border: 1px solid #ced4da; border-radius: 5px;"></textarea>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <button type="submit" class="btn btn-primary px-5" id="submitButton">Ask Me</button>
                <div id="loadingSpinner" class="ms-3" style="display: none;">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <small>Processing...</small>
                </div>
            </div>
        </form>
        <div id="answer" class="alert alert-success mt-4 text-center" style="display: none;"></div>
        <div id="error" class="alert alert-danger mt-4 text-center" style="display: none;"></div>
    </div>
    
</div>
@endsection