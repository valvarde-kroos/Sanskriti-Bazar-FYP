@extends('layout.main')

@section('hyasabicontentauncha')
<!-- This is the advanced version of the home page with more features -->
<!-- You can use this by renaming it to home.blade.php if you want the advanced version -->

<!-- SUCCESS MESSAGE -->
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">Traditional Nepali Instruments</h1>
                <p class="hero-subtitle">Authentic. Cultural. Unique.</p>
                <p class="hero-description">
                    Discover the rich musical heritage of Nepal with our collection of authentic traditional instruments 
                    crafted by skilled artisans. Each piece tells a story of Nepal's vibrant culture.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('shop.index') }}" class="btn-primary">
                        <i class="fas fa-shopping-bag"></i>
                        Explore Products
                    </a>
                    <a href="#about" class="btn-secondary">
                        <i class="fas fa-info-circle"></i>
                        Learn More
                    </a>
                </div>
                
                <!-- Quick Stats -->
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Happy Customers</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Local Vendors</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Authentic Products</div>
                    </div>
                </div>
            </div>
            <div class="hero-image">
                <div class="instrument-showcase">
                    <div class="main-instrument">
                        <i class="fas fa-drum"></i>
                        <span>Traditional Madal</span>
                    </div>
                    <div class="floating-instruments">
                        <div class="floating-item item-1">
                            <i class="fas fa-guitar"></i>
                        </div>
                        <div class="floating-item item-2">
                            <i class="fas fa-wind"></i>
                        </div>
                        <div class="floating-item item-3">
                            <i class="fas fa-music"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Note: This file contains the advanced version with animations, testimonials, about section, etc. -->
<!-- To use this version, rename this file to home.blade.php -->

@endsection