@extends('layout.main')

@section('hyasabicontentauncha')
<!-- ABOUT US PAGE -->
<div class="about-page">
    <!-- Hero Section -->
    <section class="about-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">About Sanskriti Bazar</h1>
                <p class="hero-subtitle">Preserving Nepal's Rich Cultural Heritage Through Authentic Handicrafts</p>
                <div class="hero-description">
                    <p>Welcome to Sanskriti Bazar, your premier destination for authentic Nepali handicrafts, traditional musical instruments, and cultural treasures. We are dedicated to preserving and promoting Nepal's rich cultural heritage while supporting local artisans and vendors.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="our-story-section">
        <div class="container">
            <div class="story-content">
                <div class="story-text">
                    <h2 class="section-title">Our Story</h2>
                    <p>Founded with a passion for Nepal's cultural heritage, Sanskriti Bazar began as a small initiative to connect traditional artisans with customers who appreciate authentic craftsmanship. Our journey started when we realized that many beautiful, handcrafted items were not reaching the people who would truly value them.</p>
                    
                    <p>Today, we serve as a bridge between skilled artisans from across Nepal and customers worldwide, ensuring that traditional crafts continue to thrive in the modern world. Every product in our marketplace tells a story of dedication, skill, and cultural pride.</p>
                    
                    <p>We believe that by supporting local vendors and artisans, we're not just selling products – we're preserving traditions, supporting families, and keeping Nepal's cultural heritage alive for future generations.</p>
                </div>
                <div class="story-image">
                    <img src="{{ asset('assets/images/about-story.jpg') }}" alt="Our Story" class="story-img">
                </div>
            </div>
        </div>
    </section>

    <!-- Our Mission Section -->
    <section class="mission-section">
        <div class="container">
            <h2 class="section-title">Our Mission</h2>
            <div class="mission-grid">
                <div class="mission-card">
                    <div class="mission-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                    </div>
                    <h3 class="mission-title">Preserve Heritage</h3>
                    <p class="mission-description">To preserve and promote Nepal's rich cultural heritage through authentic handicrafts and traditional arts.</p>
                </div>
                
                <div class="mission-card">
                    <div class="mission-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <h3 class="mission-title">Support Artisans</h3>
                    <p class="mission-description">To provide a platform for local artisans and vendors to showcase their skills and earn a sustainable livelihood.</p>
                </div>
                
                <div class="mission-card">
                    <div class="mission-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27,6.96 12,12.01 20.73,6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                    </div>
                    <h3 class="mission-title">Quality Assurance</h3>
                    <p class="mission-description">To ensure every product meets the highest standards of authenticity, quality, and craftsmanship.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- What We Offer Section -->
    <section class="offerings-section">
        <div class="container">
            <h2 class="section-title">What We Offer</h2>
            <div class="offerings-grid">
                <div class="offering-item">
                    <div class="offering-icon">🎵</div>
                    <h3>Traditional Musical Instruments</h3>
                    <p>Authentic Nepali instruments like Madal, Sarangi, Bansuri, Damphu, and more, crafted by skilled musicians and artisans.</p>
                </div>
                
                <div class="offering-item">
                    <div class="offering-icon">🎨</div>
                    <h3>Handcrafted Artifacts</h3>
                    <p>Beautiful handicrafts including pottery, wood carvings, metalwork, and traditional decorative items.</p>
                </div>
                
                <div class="offering-item">
                    <div class="offering-icon">🧵</div>
                    <h3>Textiles & Fabrics</h3>
                    <p>Handwoven textiles, traditional clothing, and fabric items showcasing Nepal's textile heritage.</p>
                </div>
                
                <div class="offering-item">
                    <div class="offering-icon">🏺</div>
                    <h3>Cultural Collectibles</h3>
                    <p>Unique cultural items, religious artifacts, and collectibles that represent Nepal's diverse traditions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="why-choose-section">
        <div class="container">
            <h2 class="section-title">Why Choose Sanskriti Bazar</h2>
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4"></path>
                            <path d="M21 12c-1 0-3-1-3-3s2-3 3-3 3 1 3 3-2 3-3 3"></path>
                            <path d="M3 12c1 0 3-1 3-3s-2-3-3-3-3 1-3 3 2 3 3 3"></path>
                            <path d="M12 3c0 1-1 3-3 3s-3-2-3-3 1-3 3-3 3 2 3 3"></path>
                            <path d="M12 21c0-1 1-3 3-3s3 2 3 3-1 3-3 3-3-2-3-3"></path>
                        </svg>
                    </div>
                    <h3>100% Authentic</h3>
                    <p>Every product is verified for authenticity and sourced directly from skilled artisans.</p>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                    <h3>Secure Shopping</h3>
                    <p>Safe and secure payment methods with buyer protection and satisfaction guarantee.</p>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="1" y="3" width="15" height="13"></rect>
                            <polygon points="16,3 19,7 21,7 21,13 16,13"></polygon>
                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                        </svg>
                    </div>
                    <h3>Fast Delivery</h3>
                    <p>Quick and reliable delivery across Nepal and international shipping available.</p>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <h3>Customer Support</h3>
                    <p>Dedicated customer service team ready to help with any questions or concerns.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="container">
            <h2 class="section-title">Our Commitment</h2>
            <div class="commitment-content">
                <p class="commitment-text">At Sanskriti Bazar, we are committed to being more than just a marketplace. We are cultural ambassadors, working tirelessly to ensure that Nepal's artistic traditions continue to flourish. Every purchase you make supports local communities and helps preserve invaluable cultural knowledge for future generations.</p>
                
                <div class="commitment-stats">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Artisans Supported</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">1000+</div>
                        <div class="stat-label">Products Available</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Districts Covered</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">5000+</div>
                        <div class="stat-label">Happy Customers</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Join Our Cultural Journey</h2>
                <p class="cta-description">Discover authentic Nepali handicrafts and be part of preserving our cultural heritage.</p>
                <div class="cta-buttons">
                    <a href="{{ route('shop.index') }}" class="btn-primary">Explore Products</a>
                    <a href="{{ route('contact') }}" class="btn-secondary">Contact Us</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('styles')
<style>
    /* ABOUT PAGE STYLES */
    .about-page {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Hero Section */
    .about-hero {
        background: linear-gradient(135deg, #ff4757 0%, #ff3742 100%);
        color: white;
        padding: 100px 0;
        text-align: center;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 2rem;
        opacity: 0.9;
    }

    .hero-description {
        max-width: 800px;
        margin: 0 auto;
        font-size: 1.1rem;
        line-height: 1.8;
        opacity: 0.9;
    }

    /* Container */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Section Title */
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 3rem;
        color: #2c3e50;
    }

    /* Our Story Section */
    .our-story-section {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .story-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .story-text p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 1.5rem;
    }

    .story-img {
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    /* Mission Section */
    .mission-section {
        padding: 80px 0;
    }

    .mission-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 40px;
    }

    .mission-card {
        text-align: center;
        padding: 40px 30px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .mission-card:hover {
        transform: translateY(-10px);
    }

    .mission-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #ff4757 0%, #ff3742 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .mission-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #2c3e50;
    }

    .mission-description {
        color: #666;
        line-height: 1.6;
    }

    /* Offerings Section */
    .offerings-section {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .offerings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }

    .offering-item {
        background: white;
        padding: 30px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease;
    }

    .offering-item:hover {
        transform: translateY(-5px);
    }

    .offering-icon {
        font-size: 3rem;
        margin-bottom: 20px;
    }

    .offering-item h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #2c3e50;
    }

    .offering-item p {
        color: #666;
        line-height: 1.6;
    }

    /* Why Choose Section */
    .why-choose-section {
        padding: 80px 0;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
    }

    .feature-item {
        text-align: center;
        padding: 30px 20px;
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #ff4757 0%, #ff3742 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .feature-item h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #2c3e50;
    }

    .feature-item p {
        color: #666;
        line-height: 1.6;
    }

    /* Team Section */
    .team-section {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .commitment-content {
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .commitment-text {
        font-size: 1.2rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 3rem;
    }

    .commitment-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 30px;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #ff4757;
        margin-bottom: 10px;
    }

    .stat-label {
        font-size: 1rem;
        color: #666;
        font-weight: 600;
    }

    /* CTA Section */
    .cta-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        text-align: center;
    }

    .cta-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .cta-description {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        opacity: 0.9;
    }

    .cta-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-primary, .btn-secondary {
        padding: 15px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .btn-primary {
        background: #ff4757;
        color: white;
    }

    .btn-primary:hover {
        background: #ff3742;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: transparent;
        color: white;
        border: 2px solid white;
    }

    .btn-secondary:hover {
        background: white;
        color: #2c3e50;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
        }

        .section-title {
            font-size: 2rem;
        }

        .story-content {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .mission-grid,
        .offerings-grid,
        .features-grid {
            grid-template-columns: 1fr;
        }

        .commitment-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .cta-buttons {
            flex-direction: column;
            align-items: center;
        }

        .btn-primary, .btn-secondary {
            width: 200px;
        }
    }

    @media (max-width: 480px) {
        .hero-title {
            font-size: 2rem;
        }

        .section-title {
            font-size: 1.75rem;
        }

        .commitment-stats {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection